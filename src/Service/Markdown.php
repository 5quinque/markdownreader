<?php
namespace App\Service;

class Markdown
{
    private $markdownDirectory;

    public function __construct()
    {
        $this->markdownDirectory = $_ENV['MARKDOWN_DIRECTORY'];

        $this->files = $this->listAll($this->markdownDirectory);
    }

    public function findIndex(array $files = null)
    {
        if (is_null($files)) {
            $files = $this->files;
        }

        foreach ($files as $key => $value) {
            // Only search for the 'index' file one level deep
            if (is_array($value) && ($files === $this->files)) {
                return $this->findIndex($value);
            }

            if ($key == "index") {
                return [$value, $key];
            }
        }
    }

    public function loadMarkdown(string $directory, string $file)
    {
        $directory = preg_replace('/\/..\//', '\/', $directory);

        if (!$this->directoryExists($directory)) {
            return false;
        }

        if (file_exists("{$this->markdownDirectory}/$directory/$file.md")) {
            return file_get_contents("{$this->markdownDirectory}/$directory/$file.md");
        } else {
            return false;
        }
    }

    public function loadImage(string $path)
    {
        if (file_exists("{$this->markdownDirectory}/$path")) {
            return file_get_contents("{$this->markdownDirectory}/$path");
        }
    }

    private function directoryExists(string $directory)
    {
        return is_dir("{$this->markdownDirectory}/$directory");
    }

    public function listAll($dir)
    {
        $result = array();
        $cdir = scandir($dir);
        
        $fullDirectory = str_replace($this->markdownDirectory, '', $dir);
        $fullDirectory = preg_replace('/^\//', '', $fullDirectory);

        foreach ($cdir as $key => $value) {
            // Skip hidden files and current/parent special names ('.', '..')
            if (preg_match('/^\./', $value)) {
                continue;
            }

            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = $this->listAll($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $filename = $this->isMarkdownFile($value);
                if ($filename) {
                    $result[$filename] = $fullDirectory;
                }
            }
        }

        return $result;
    }

    private function isMarkdownFile(string $filename)
    {
        if (preg_match('/\.md$/', $filename)) {
            return preg_replace('/\.md$/', '', $filename);
        }

        return false;
    }
}
