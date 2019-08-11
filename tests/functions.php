<?php

if (!function_exists('esc_html')) {
    /**
     * @param string $text
     * @return string
     */
    function esc_html(string $text)
    {
        return htmlentities($text);
    }
}
