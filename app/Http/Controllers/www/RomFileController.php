<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use App\Http\Requests\StoreRomFileRequest;
use App\Interfaces\RomFileActionsInterface;
use App\Interfaces\RomFileDataServiceInterface;
use App\Models\RomFile;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use RomFileRepo;

class RomFileController extends ViewController
{
    private RomFileDataServiceInterface $romFileDataService;

    public function __construct(RomFileDataServiceInterface $romFileDataService)
    {
        $this->romFileDataService = $romFileDataService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function index()
    {
        Gate::authorize('viewAny-romFile');
        return response()->view('rom-file.index', ['romFiles' => RomFileRepo::getAllFilesSorted()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(RomFileActionsInterface $romFileActions)
    {
        return response()->view('rom-file.create', ['romFiles' => $romFileActions->listRomFiles()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRomFileRequest $request
     * @return Response
     */
    public function store(StoreRomFileRequest $request)
    {
        $this->romFileDataService->uploadFile($request['filename']);
        return response()->redirectTo(url()->previous())->banner("file uploaded!");
    }

    /**
     * Display the specified resource.
     *
     * @param RomFile $romFile
     * @return Response
     */
    public function show(RomFile $romFile)
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
    public function destroy(RomFile $romFile)
    {
        $this->authorize('delete', $romFile);
        $this->romFileDataService->deleteFile($romFile);
        return response()->redirectTo(route('rom-files.index'))->banner("$romFile->filename deleted!");
    }
}

