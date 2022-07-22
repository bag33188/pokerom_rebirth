<?php

if (!function_exists('joinHtmlClasses')) {
    /**
     * Convert an array of CSS classes and join them together into an HTML class-attribute string.
     *
     * @param string[] $classes string array of CSS classes
     * @return string joined HTML class string
     */
    function joinHtmlClasses(array $classes): string
    {
        return implode(_SPACE, $classes);
    }
}
