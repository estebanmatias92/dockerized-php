<?php 

require_once __DIR__ . '/FileProcessor.php'; // Include the FileProcessor class

// Menu Screen

// Asking the customizations
echo "Please enter new namespace: ";
$newNamespace = trim(fgets(STDIN));

// Preparing directory, files and patterns to search and replace
$directory = dirname(dirname(__DIR__));
$fileNames = ['*.php', 'composer.json']; // Files to process, you can use expressions
$replacements = [
    "{{ placeholder.namespace }}" => $newNamespace
]; // Patterns and their replacements

// Instantiate the FileProcessor
$processor = new FileProcessor($fileNames, $directory, true);
$processor->setExcludedDirectories(['config', 'scripts', 'vendor/']);

// Process the files
$modifiedFiles = $processor->processFiles($replacements);


// Showing the results
echo "\nUpdated files:\n";

foreach ($modifiedFiles as $file) {
    echo "    - " . $file . "\n";
}
