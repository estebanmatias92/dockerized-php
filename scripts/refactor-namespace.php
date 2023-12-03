<?php

<?php

function getPhpFiles($dir, $excludeFile) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    $phpFiles = [];
    foreach ($iterator as $file) {
        if ($file->isDir()) continue;
        if (strtolower($file->getExtension()) === 'php') {
            if ($file->getPathname() !== $excludeFile) {
                $phpFiles[] = $file->getPathname();
            }
        }
    }
    return $phpFiles;
}

function replaceNamespace($filePath, $oldNamespace, $newNamespace) {
    $content = file_get_contents($filePath);
    $content = str_replace($oldNamespace, $newNamespace, $content);
    file_put_contents($filePath, $content);
}

echo "Enter the new namespace: ";
$newNamespace = trim(fgets(STDIN));

$oldNamespace = '{{ placeholder }}'; 
$scriptFile = __FILE__; // Path to the current script
$projectDir = dirname(__DIR__);// Root

$phpFiles = getPhpFiles($projectDir, $scriptFile);

foreach ($phpFiles as $file) {
    replaceNamespace($file, $oldNamespace, $newNamespace);
    echo "Updated namespace in file: $file\n";
}

echo "Namespace refactoring complete.\n";
