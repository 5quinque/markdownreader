<?php

namespace App\Command;

Use App\Service\GitPull;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GitPullCommand extends Command
{
    protected static $defaultName = 'app:git-pull';

    private $service;

    public function __construct(GitPull $service)
    {
        $this->service = $service;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Perform a 'git pull' on the markdown directory")
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Performing git pull');
        $output->writeln('===================');

        $serviceOutput = $this->service->pull();
        $output->writeln($serviceOutput);

        return 0;
    }
}
