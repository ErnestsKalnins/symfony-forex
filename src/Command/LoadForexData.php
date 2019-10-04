<?php

namespace App\Command;

use App\Service\LatviaBankForexService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadForexData extends Command
{
    protected static $defaultName = 'forex:load';

    private $forexService;

    public function __construct(LatviaBankForexService $forexService)
    {
        $this->forexService = $forexService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Loads forex rates from external service.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Loading forex rates...");
        var_dump($this->forexService->getForexData());
    }
}