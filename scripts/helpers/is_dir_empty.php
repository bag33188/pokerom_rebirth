<?php

if (!function_exists('isDirEmpty')) {
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
        $iterator = new FilesystemIterator($dir, FilesystemIterator::KEY_AS_PATHNAME);
        return !$iterator->valid();
    }
}
