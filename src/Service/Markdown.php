<?php
namespace App\Service;

class Markdown
{
    private $markdownDirectory;

    public function __construct()
    {
        $this->markdownDirectory = $_ENV['MARKDOWN_DIRECTORY'];

        $this->files = $this->listAll($this->markdownDirectory);

        $this->files = $this->removeHidden($this->files);
    }

    public function LoadMarkdown(string $directory, string $file)
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

    private function directoryExists(string $directory)
    {
        return is_dir("{$this->markdownDirectory}/$directory");
    }

    public function listAll($dir)
    {
        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value,array(".",".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = $this->listAll($dir . DIRECTORY_SEPARATOR . $value);
                } else {
                    if (preg_match('/\.md$/', $value)) {
                        $result[] = $value;
                    }
                }
            }
        }

        return $result;
    }

    public function removeHidden(array $array): array
    {
        foreach ($array as $key => $value) {
            if (preg_match('/^\./', $key)) { // Remove hidden directory
                unset($array[$key]);
                continue;
            }
            if (is_array($array[$key])) { // Recuse through directories
                $array[$key] = $this->removeHidden($array[$key]);
            } else if (preg_match('/^\./', $value)) { // Remove hidden file
                unset($array[$key]);
                continue;
            }

        }

        return $array;
    }

}
