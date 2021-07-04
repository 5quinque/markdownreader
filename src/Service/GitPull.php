<?php
namespace App\Service;

class GitPull
{
    private $gitPullCommand;
    private $markdownDirectory;

    public function __construct()
    {
        $this->gitPullCommand = $_ENV['GIT_PULL_COMMAND'];
        $this->markdownDirectory = $_ENV['MARKDOWN_DIRECTORY'];
    }

    public function pull()
    {
        // [TODO] Replace 'notes' with the git repository name
        chdir("{$this->markdownDirectory}/notes");
        $result = array();
        #exec("ls -l", $result);
        exec($this->gitPullCommand, $result);


        $output = "";
        foreach ($result as $line) {
            $output .= "$line\n";
        }
        //exec($this->gitPullCommand);
        //
        return $output;
    }
}
