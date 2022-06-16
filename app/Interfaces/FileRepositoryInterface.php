<?php

namespace App\Interfaces;

interface FileRepositoryInterface {
    public function downloadFile($fileId);
    public function uploadFile($file);
}
