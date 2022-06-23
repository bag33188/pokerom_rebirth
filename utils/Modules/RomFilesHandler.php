<?php

namespace Utils\Modules;

use App\Models\File;
use FileRepo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Utils\Classes\AbstractGfsFilesHandler;

class RomFilesHandler extends AbstractGfsFilesHandler
{
    protected UploadedFile $file;
    protected string $filename;
    protected string $filepath;
    protected static string $serverUploadFilePath;

    private const DOWNLOAD_CHUNK_SIZE = 0xFF000;
    public final const VALID_FILENAME_PATTERN = "/^([\w\d\s\-_]+)\.[\w\d]+$/i";

    public function __construct(string $databaseName = null)
    {
        self::$serverUploadFilePath = Config::get('gridfs.fileUploadPath');
        parent::__construct($databaseName);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getFileDocument(): File
    {
        return FileRepo::getFileByFilename($this->filename);
    }

    public function upload(UploadedFile $file): void
    {
        $this->setUploadFileData($file);
        $this->uploadFileFromStream();
    }

    public function download(string $fileId): void
    {
        $stream = $this->createDownloadStreamFromFile($fileId);
        $fileDownloader = new FileDownloader($stream, self::DOWNLOAD_CHUNK_SIZE);
        $fileDownloader->downloadFile();
    }

    public function destroy(string $fileId): void
    {
        $this->gfsBucket->delete(self::parseObjectId($fileId));
    }

    /**
     * Sets all needed file information for uploading to database
     *
     * @param UploadedFile $file
     * @return void
     */
    private function setUploadFileData(UploadedFile $file): void
    {
        $this->file = $file;
        $this->createFileNameFromFile();
        $this->createUploadFilePathFromFile();
    }

    /**
     * Creates the filename string from the given uploaded file.
     * Checks if it is in a valid format and then
     * normalizes the filename.
     *
     * @return void
     *
     * @see normalizeFileName
     * @see checkFormatOfFileName
     */
    private function createFileNameFromFile(): void
    {
        $this->filename = @$this->file->getClientOriginalName();
        $this->checkFormatOfFileName();
        self::normalizeFileName($this->filename);
    }

    /**
     * Concatenates the server's upload file path with the filename
     *
     * @return void
     */
    private function createUploadFilePathFromFile(): void
    {
        $this->filepath = sprintf("%s/%s",
            self::$serverUploadFilePath, $this->filename);
    }

    /**
     * Opens a file stream from the defined filepath and
     * opens a mongodb gridfs upload stream using the file's name and
     * newly opened filestream.
     *
     * @return void
     *
     * @see \MongoDB\GridFS\Bucket uploadFromStream
     */
    private function uploadFileFromStream(): void
    {
        $stream = fopen($this->filepath, 'rb');
        $this->gfsBucket->uploadFromStream($this->filename, $stream);
    }

    /**
     * Opens a gridfs download stream from a parsed ObjectID that contains
     * any given file's ID.
     *
     * @param string $fileId
     * @return resource
     *
     * @see \MongoDB\GridFS\Bucket openDownloadStream
     */
    private function createDownloadStreamFromFile(string $fileId)
    {
        return $this->gfsBucket->openDownloadStream(self::parseObjectId($fileId));
    }

    /**
     * Checks if the filename only has 1 period and select chars:
     * `\s, \d, \w, \-, _`
     *
     * @return void
     */
    private function checkFormatOfFileName(): void
    {
        if (!preg_match(self::VALID_FILENAME_PATTERN, $this->filename)) {
            $badFilenameErrorMessage = 'Invalid filename detected. ' .
                'Matched against pattern: `' . self::VALID_FILENAME_PATTERN . '`';
            throw new UnprocessableEntityHttpException($badFilenameErrorMessage, code: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Converts the file extension to lowercase
     * Trims the filename (ext. excluded)
     *
     * @param string $filename
     * @return void
     */
    private static function normalizeFileName(string &$filename): void
    {
        // explode function's limit param can be used to check for single occurrence of the `.` (period) character
        [$name, $ext] = explode('.', $filename, 2);
        $name = trim($name);
        $ext = strtolower($ext);
        $filename = "$name.$ext";
    }
}
