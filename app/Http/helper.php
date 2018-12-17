<?php

/**
 * Get the summary of the long text
 * @param type $text
 * @param type $maxLength
 * @return string
 */
function getSummary($text, $maxLength = 40) {
    if (strlen($text) <= $maxLength) {
        return $text;
    }
    $summary = substr($text, 0, $maxLength - 3);
    $space = strrpos($summary, ' ');
    $summary = substr($summary, 0, $space);
    $summary .= '...';
    return $summary;
}
