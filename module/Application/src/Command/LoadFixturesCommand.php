<?php
namespace Application\Command;

use Application\DataFixtures\MenuDataFixture;
use Application\DataFixtures\MenuItemDataFixture;
use Application\DataFixtures\UserDataFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Loader;
use Application\DataFixtures\RoleDataFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class LoadFixturesCommand extends Command
{
    protected static $defaultDescription = 'Creates date for the database.';

    /**
     * @var
     */
    protected $entityManager;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to load fixtures.')
            ->addArgument(
                'fixtures',
                InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
                'Select fixture(s) to be load: role, user, menu',
                ['all']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new Loader();
        $executor = new ORMExecutor($this->entityManager, new ORMPurger());

        $fixtures = $input->getArgument('fixtures');


        if (in_array('all', $fixtures) || in_array('role', $fixtures)){

            $output->writeln([
                'Load role fixtures',
                '============',
                '',
            ]);

        $loader->addFixture(new RoleDataFixture());
        }

        if (in_array('all', $fixtures) || in_array('user', $fixtures)) {
            $output->writeln([
                'Load user fixtures',
                '============',
                '',
            ]);

            $loader->addFixture(new UserDataFixture());
        }

        if (in_array('all', $fixtures) || in_array('menu', $fixtures)) {
            $output->writeln([
                'Load menu fixtures',
                '============',
                '',
            ]);

            $loader->addFixture(new MenuItemDataFixture());
            $loader->addFixture(new MenuDataFixture());

        }


        $executor->execute($loader->getFixtures(), append: true);

        return Command::SUCCESS;

    }
}