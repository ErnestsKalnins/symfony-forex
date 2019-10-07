<?php

namespace App\Command;

use App\Entity\ForexRate;
use App\Repository\ForexRateRepository;
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

    private $forexRepository;

    private $forexService;

    public function __construct(EntityManagerInterface $entityManager, ForexRateRepository $forexRepository, LatviaBankForexService $forexService)
    {
        $this->entityManager = $entityManager;
        $this->forexRepository = $forexRepository;
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

        $persistCount = 0;

        $progressBar = new ProgressBar($output, count($rates));

        foreach ($rates as $rate)
        {
            if (! $this->forexRepository->findOneBy($rate))
            {
                $persistCount++;
                $this->entityManager->persist( new ForexRate($rate) );
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->entityManager->flush();

        $output->writeln($this->persistedEntryMessage($persistCount));
    }

    private function persistedEntryMessage($count)
    {
        return $count == 0
            ? "\tNo new records to persist!"
            : "\tPersisted ${count} new records.";
    }
}