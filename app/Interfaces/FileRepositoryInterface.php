<?php

namespace App\Interfaces;

interface FileRepositoryInterface {
    public function downloadFile($fileId);
    public function uploadFile($file);
    public function deleteFile($fileId,$file);
    public function showRom($file);
}
