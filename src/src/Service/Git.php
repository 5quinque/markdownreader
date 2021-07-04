<?php
namespace App\Service;

class Git
{
    private $gitCloneCommand;
    private $gitPullCommand;
    private $markdownDirectory;

    public function __construct()
    {
        $this->gitCloneCommand = "git clone {$_ENV['GIT_NOTES_REPOSITORY']}";
        $this->gitPullCommand = "git pull {$_ENV['GIT_NOTES_REPOSITORY']}";
        $this->markdownDirectory = $_ENV['MARKDOWN_DIRECTORY'];
    }

    public function clone()
    {
        chdir("{$this->markdownDirectory}");
        $result = array();

        exec($this->gitCloneCommand, $result);

        $output = "";
        foreach ($result as $line) {
            $output .= "$line\n";
        }

        return $output;
    }

    public function pull()
    {
        // [TODO] Replace 'notes' with the repository name
        chdir("{$this->markdownDirectory}/notes");
        $result = array();

        exec($this->gitPullCommand, $result);

        $output = "";
        foreach ($result as $line) {
            $output .= "$line\n";
        }

        return $output;
    }
}
