<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use App\Http\Requests\StoreRomFileRequest;
use App\Interfaces\Action\RomFileActionsInterface;
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
     * @throws AuthorizationException
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
     * @param RomFileActionsInterface $romFileActions
     * @return Response
     */
    public function create(RomFileActionsInterface $romFileActions): Response
    {
        $romFiles = $romFileActions->listRomFilesInStorageSorted();
        return response()->view('rom-file.create', ['romFiles' => $romFiles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRomFileRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRomFileRequest $request): RedirectResponse
    {
        $this->romFileService->uploadRomFile($request['filename']);
        return response()->redirectTo(URL::previous())->banner("file ${request['filename']} uploaded!");
    }

    /**
     * Display the specified resource.
     *
     * @param RomFile $romFile
     * @return Response
     */
    public function show(RomFile $romFile): Response
    {
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

