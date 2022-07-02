<?php

/**
 * These functions replace the proper **&eacute;**, or **e** character in the word _Poke_ or _Pok&eacute;_
 *
 * ### Examples
 *
 * > {@link unicode_eacute}: _PokeROM => Pok&eacute;ROM_
 *
 * > {@link un_unicode_eacute}: _Pok&eacute;mon => Pokemon_
 *
 * ### Notes:
 * Use string mods after using these functions if lowercase or uppercase is needed.
 */


if (!function_exists('unicode_eacute')) {
    /**
     * Converts the **e** to **&eacute;** in the word _Poke_
     *
     * @param string $text
     * @param bool $useUppercase replace with uppercase eacute
     * @return string
     */
    function unicode_eacute(string $text, bool $useUppercase = false): string
    {
        $replacement = "Pok" . ($useUppercase ? _U_EACUTE : _EACUTE);
        return preg_replace("/Poke/i", $replacement, $text);
    }
}

if (!function_exists('un_unicode_eacute')) {
    /**
     * Converts the **&eacute;** back to **e** in the word _Pok&eacute;_
     *
     * @param string $text
     * @param bool $useUppercase search for uppercase eacute
     * @return string
     */
    function un_unicode_eacute(string $text, bool $useUppercase = false): string
    {
        $pattern = !$useUppercase ? /** @lang RegExp */
            "/Pok\x{E9}/iu" : /** @lang RegExp */
            "/Pok\x{C9}/iu";
        return preg_replace($pattern, "Poke", $text);
    }
}
