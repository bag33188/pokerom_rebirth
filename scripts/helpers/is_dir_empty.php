<?php

if (!function_exists('isDirEmpty')) {
    function isDirEmpty($dir): bool
    {
        $iterator = new FilesystemIterator($dir);
        return !$iterator->valid();
    }
}
