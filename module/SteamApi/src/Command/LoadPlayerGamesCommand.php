<?php
namespace SteamApi\Command;

use DateInterval;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\VarDumper\VarDumper;

class LoadPlayerGamesCommand extends Command
{
    protected static $defaultDescription = 'Fetch all games of the player and saves them to the database.';

    /**
     * @var
     */
    protected $entityManager;

    protected $steamPlayerService;

    /**
     * Constructs the service.
     */
    public function __construct(
        $entityManager,
        $steamPlayerService
    )
    {
        $this->entityManager        = $entityManager;
        $this->steamPlayerService   = $steamPlayerService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to load all the games of the player into the database.')
            ->addArgument(
                'newest',
                InputArgument::OPTIONAL,
                'Select total games to import',
                0
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new Loader();
        $executor = new ORMExecutor($this->entityManager, new ORMPurger());

        $newest = (int) $input->getArgument('newest');

        if ($newest === 1){

            $yesterday = new DateTime();
            $interval = new DateInterval('P1D');
            $yesterday->sub($interval);

            $ownedGames = $this->steamPlayerService->getOwnedGames();

            foreach($ownedGames as $game) {
                VarDumper::dump($game); die;
            }

            echo $yesterday->format('d.m.y');

            return Command::SUCCESS;
        }





        return Command::SUCCESS;

    }
}