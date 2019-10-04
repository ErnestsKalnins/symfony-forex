<?php

namespace App\Command;

use App\Entity\ForexRate;
use App\Service\LatviaBankForexService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadForexData extends Command
{
    protected static $defaultName = 'forex:load';

    private $entityManager;

    private $forexService;

    public function __construct(EntityManagerInterface $entityManager, LatviaBankForexService $forexService)
    {
        $this->entityManager = $entityManager;
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

        $rates = $this->forexService->getForexRates();

        $progressBar = new ProgressBar($output, count($rates));

        foreach($rates as $rate)
        {
            $this->persistRate($rate);
            $progressBar->advance();
        }

        $this->entityManager->flush();
        $progressBar->finish();
        $output->writeln("\tCompleted!");
    }

    private function persistRate($rateArr)
    {
        $rate = new ForexRate();
        $rate
            ->setCurrency($rateArr["currency"])
            ->setRate($rateArr["rate"])
            ->setPublishedAt($rateArr["published_at"]);

        $this->entityManager->persist($rate);
    }
}