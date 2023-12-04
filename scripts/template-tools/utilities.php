<?php

/**
 * Make Glob Great Again.
 */
function recursiveGlob(string $directory, array $patterns, array $excludedDirectories = []) {
    $directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    $files = [];

    // Check if the current directory is excluded
    if (in_array($directory, $excludedDirectories)) {
        return [];
    }

    // Look for matching files in the current directory
    foreach ($patterns as $pattern) {
        $files = array_merge($files, glob($directory . $pattern));
    }

    // Search in sub-directories
    foreach (glob($directory . '*', GLOB_ONLYDIR) as $subdir) {
        $files = array_merge($files, recursiveGlob($subdir, $patterns, $excludedDirectories));
    }

    return $files;
}
