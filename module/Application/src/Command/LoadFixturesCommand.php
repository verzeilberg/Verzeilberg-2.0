<?php
namespace Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Loader;
use Application\DataFixtures\RoleDataFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class LoadFixturesCommand extends Command
{
    protected static $defaultDescription = 'Creates date for the database.';

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to load fixtures.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln([
            'Load role fixtures',
            '============',
            '',
        ]);

        $loader = new Loader();
        $loader->addFixture(new RoleDataFixture());

        $executor = new ORMExecutor($entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures());

        $output->writeln([
            'Load user fixtures',
            '============',
            '',
        ]);

        $output->writeln([
            'Load menu fixtures',
            '============',
            '',
        ]);

        die('test');
// ... put here the code to create the user

// this method must return an integer number with the "exit status code"
// of the command. You can also use these constants to make code more readable

// return this if there was no problem running the command
// (it's equivalent to returning int(0))
        return Command::SUCCESS;

// or return this if some error happened during the execution
// (it's equivalent to returning int(1))
// return Command::FAILURE;

// or return this to indicate incorrect command usage; e.g. invalid options
// or missing arguments (it's equivalent to returning int(2))
// return Command::INVALID
    }
}