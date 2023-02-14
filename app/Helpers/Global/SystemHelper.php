<?php

if (! function_exists('includeFilesInFolder')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     */
    function includeFilesInFolder(string $folder): void
    {
        try {
            $rdi = new RecursiveDirectoryIterator($folder);
            /** @var DirectoryIterator $it */
            $it = new RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('includeRouteFiles')) {
    function includeRouteFiles(string $folder): void
    {
        includeFilesInFolder($folder);
    }
}
