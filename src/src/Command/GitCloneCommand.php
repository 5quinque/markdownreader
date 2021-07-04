<?php

namespace App\Command;

Use App\Service\Git;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GitCloneCommand extends Command
{
    protected static $defaultName = 'app:git-clone';

    private $service;

    public function __construct(Git $service)
    {
        $this->service = $service;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Perform a 'git clone' on the markdown directory")
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Performing git clone');
        $output->writeln('===================');

        $serviceOutput = $this->service->clone();
        $output->writeln($serviceOutput);

        return 0;
    }
}
