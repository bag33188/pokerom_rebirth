<?php

namespace App\Http\Controllers\www;

use App\Http\Controllers\Controller as ViewController;
use App\Models\RomFile;
use Illuminate\Http\Request;
use GfsRomFile;
use Illuminate\Http\Response;

class RomFileController extends ViewController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return response()->view('rom-files.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // TODO:  implement better file upload
        //https://laracasts.com/discuss/channels/laravel/advice-on-solutions-for-very-large-file-uploads?page=1&replyId=774409
        //https://github.com/pionl/laravel-chunk-upload
        //https://github.com/23/resumable.js
        $file = $request->file(FILE_FORM_KEY);
        GfsRomFile::upload($file);
//        if (!\Storage::directoryExists('photos')) {
//            \Storage::makeDirectory('photos');
//            \Storage::putFile('photos', $file, 'private');
//        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RomFile $romFile
     * @return Response
     */
    public function edit(RomFile $romFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param RomFile $romFile
     * @return Response
     */
    public function update(Request $request, RomFile $romFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RomFile $romFile
     * @return Response
     */
    public function destroy(RomFile $romFile)
    {
        //
    }
}
