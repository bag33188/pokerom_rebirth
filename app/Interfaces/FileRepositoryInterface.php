<?php

namespace App\Interfaces;

interface FileRepositoryInterface
{
    public function getAllFilesSorted();

    public function findFileIfExists(string $fileId);

    public function getRomAssociatedWithFile(string $fileId);
    public function searchForRomMatchingFile(string $fileId);
}
