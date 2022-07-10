<?php

if (!function_exists('isDirEmpty')) {

    define('FSI_FLAGS', FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS);

    /**
     * Checks if a given directory is empty (devoid of files)
     *
     * _Loaded in `composer.json`_
     *
     * @param string $dir
     * @return bool
     */
    function isDirEmpty(string $dir): bool
    {
        $iterator = new FilesystemIterator($dir, FSI_FLAGS);
        return !$iterator->valid();
    }
}
