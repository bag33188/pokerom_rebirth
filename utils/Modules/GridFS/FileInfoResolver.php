<?php

namespace Utils\Modules\GridFS;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FileInfoResolver
{
    /**
     * The path on the server to which the uploaded file should be retrieved from.
     * @var string
     */
    protected static string $serverUploadFilePath;
    public final const VALID_FILENAME_PATTERN = /** @lang RegExp */
        "/^([\w\d\s\-_]+)\.[\w\d]+$/i";
    protected UploadedFile $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        self::$serverUploadFilePath = Config::get('gridfs.fileUploadPath');
    }

    public function getFilename(): string
    {
        $filename = @$this->file->getClientOriginalName();
        $this->checkFormatOfFileName($filename);
        self::normalizeFileName($filename);
        return $filename;
    }


    public function getFilePath(): string
    {
        return sprintf("%s/%s",
            self::$serverUploadFilePath, $this->getFilename());
    }

    private function checkFormatOfFileName(string $filename): void
    {
        if (!preg_match(self::VALID_FILENAME_PATTERN, $filename)) {
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
