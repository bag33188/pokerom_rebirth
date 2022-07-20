<?php

namespace App\Http\Controllers\WWW;

use App\Http\Controllers\Controller as ViewController;
use App\Http\Requests\StoreRomFileRequest;
use App\Interfaces\Service\RomFileServiceInterface;
use App\Models\RomFile;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use RomFileRepo;
use Symfony\Component\HttpFoundation\StreamedResponse;
use URL;

class RomFileController extends ViewController
{
    private readonly RomFileServiceInterface $romFileService;

    public function __construct(RomFileServiceInterface $romFileService)
    {
        $this->romFileService = $romFileService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        Gate::authorize('viewAny-romFile');
        return response()->view('rom-file.index', [
            'romFiles' => RomFileRepo::getAllRomFilesSortedWithRomData(),
            'romFilesCount' => RomFileRepo::getRomFilesCount()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $romFilesList = RomFileRepo::listRomFilesInStorage();
        usort($romFilesList, fn(string $a, string $b): int => strlen($b) - strlen($a));
        return response()->view('rom-file.create', ['romFilesList' => $romFilesList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRomFileRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreRomFileRequest $request): RedirectResponse
    {
        $this->authorize('create', RomFile::class);
        $romFilename = $request['filename'];
        $this->romFileService->uploadRomFile($romFilename);
        return response()->redirectTo(URL::previous())->banner("file `$romFilename` uploaded!");
    }

    /**
     * Display the specified resource.
     *
     * @param RomFile $romFile
     * @return Response
     * @throws AuthorizationException
     */
    public function show(RomFile $romFile): Response
    {
        $this->authorize('view', $romFile);
        return response()->view('rom-file.show', ['romFile' => $romFile]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RomFile $romFile
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(RomFile $romFile): RedirectResponse
    {
        $this->authorize('delete', $romFile);
        $this->romFileService->deleteRomFile($romFile);
        return response()->redirectTo(route('rom-files.index'))->banner("$romFile->filename deleted!");
    }

    public function download(RomFile $romFile): StreamedResponse
    {
        return $this->romFileService->downloadRomFile($romFile);
    }
}

