<?php

class FileProcessor {
    private $directory;
    private $fileNames;
    private $isRecursive;

    /**
     * @param array $fileNames An array with the name/expression of the files you want to be included in the processing.
     * @param string $directory Set the path string, by default is the current folder.
     * @param bool $isRecursive Set this to true if you want to include the files from subdirectories too.
     * 
     * @return void
     */
    public function __construct(array $fileNames, string $directory = __DIR__, bool $isRecursive = false) {
        $this->setFileNames($fileNames);
        $this->setDirectory($directory);
        $this->isRecursive = $isRecursive;
    }

    // Setter for $directory
    public function setDirectory(string $directory) {
        // Ensure the directory string ends with a DIRECTORY_SEPARATOR
        $this->directory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    // Setter for $fileNames
    public function setFileNames(array $fileNames) {
        $this->fileNames = $fileNames;
    }

    // Replace all the placeholders in all the files
    public function processFiles(array $replacements) {
        $files = $this->getAllFiles();
        $pattern = $this->createPattern($replacements);

        foreach ($files as $file) {
            if ($this->processFile($file, $pattern, $replacements)) {
                yield $file;
            }
        }        
    }

    // Merge and return all the filepaths
    private function getAllFiles() {
        $list = [];
        $globOptions = ($this->isRecursive) ? GLOB_BRACE : 0;
    
        foreach ($this->fileNames as $fileName) {
            $pattern = $this->directory . $fileName;
            $files = glob($pattern, $globOptions);
            $list = array_merge($list, $files);
        }
    
        return $list;
    }

    /**
     * Build and return a regular expresion with the placeholders
     * 
     * @param array $replacements Set an associative array with the patterns as Keys and the new values to replace as Values.
     * 
     * @return string Returns a regular expression with all the patterns/placeholders concatenated.
     */
    private function createPattern(array $replacements) {
        $patterns = array_map(function($key) {
            return preg_quote($key, "/");
        }, array_keys($replacements));
        
        return "/" . implode('|', $patterns) . "/";
    }

    // Replace the placeholders in the file with the new strings, return if it was successful or not
    private function processFile(string $file, string $pattern, array $replacements) {
        $content = file_get_contents($file);
        if ($content === false) {
            return false; // Manejo de error de lectura
        }

        if (preg_match($pattern, $content)) {
            $modifiedContent = preg_replace_callback($pattern, function($matches) use ($replacements) {
                return $replacements[$matches[0]] ?? $matches[0];
            }, $content);

            if (file_put_contents($file, $modifiedContent) === false) {
                return false; // Manejo de error de escritura
            }

            return true;
        }

        return false;
    }
}

