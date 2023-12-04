<?php 

require_once 'FileProcessor.php'; // Include the FileProcessor class

// Menu Screen

// Asking the customizations
echo "Enter the new namespace: ";
$newNamespace = trim(fgets(STDIN));

// Preparing directory, files and patterns to search and replace
$directory = dirname(__DIR__);
$fileNames = ['**/*.php', 'composer.json']; // Files to process, you can use expressions
$replacements = [
    "{{ placeholder }}" => $newNamespace
]; // Patterns and their replacements

// Instantiate the FileProcessor
$processor = new FileProcessor($fileNames, $directory, true);

// Process the files
$modifiedFiles = $processor->processFiles($replacements);

// Showing the results
echo "\nModified files:\n";

foreach ($modifiedFiles as $file) {
    echo "\t- " . $file . "\n";
}
