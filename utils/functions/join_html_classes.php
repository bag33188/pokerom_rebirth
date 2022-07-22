<?php

if (!function_exists('joinHtmlClasses')) {
    /**
     * @param string[] $classes
     * @return string
     */
    function joinHtmlClasses(array $classes): string
    {
        return implode(_SPACE, $classes);
    }
}
