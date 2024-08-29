<?php
namespace SteamApi\Command;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use SteamApi\Entity\Category;
use SteamApi\Entity\Developer;
use SteamApi\Entity\Game;
use SteamApi\Entity\Genre;
use SteamApi\Entity\Movie;
use SteamApi\Entity\MovieDetail;
use SteamApi\Entity\Publisher;
use SteamApi\Entity\Screenshot;
use SteamApi\Entity\UserGameDetail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\VarDumper\VarDumper;
use SteamApi\Service\steamPlayerService;

class LoadPlayerGamesCommand extends Command
{
    protected static $defaultDescription = 'Fetch all games of the player and saves them to the database.';

    /**
     * @var
     */
    protected EntityManager $entityManager;

    protected steamPlayerService $steamPlayerService;

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

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new Loader();
        $executor = new ORMExecutor($this->entityManager, new ORMPurger());

        $newest = (int) $input->getArgument('newest');
        if ($newest === 1){

            $yesterday = new DateTime();
            $interval = new DateInterval('P1D');
            $yesterday->sub($interval);

            $totalOwnedGames = $this->steamPlayerService->getOwnedGames(0, 0, 1);
            $ownedGames = $this->steamPlayerService->getOwnedGames();

            var_dump($ownedGames); die;

            foreach($ownedGames as $game) {



                $newGame = new Game();
                $newGame->setAppId($game['game']['appId']);
                $newGame->setName($game['game']['name']);
                $newGame->setType($game['game']['type']);
                $newGame->setDetailedDescription($game['game']['detailed_description']);
                $newGame->setShortDescription($game['game']['short_description']);
                $newGame->setAboutTheGame($game['game']['about_the_game']);
                $newGame->setHeaderImage($game['game']['header_image']);
                $newGame->setWebsite($game['game']['website']);
                $newGame->save();



                //User game details
                $userGameDetail = new UserGameDetail();
                $userGameDetail->setPlaytimeForever($game['user_game_detail']['play_time_forever']);
                $userGameDetail->setTimeLastPlayed($game['user_game_detail']['time_last_playeds']);
                $userGameDetail->setGame($newGame);
                $userGameDetail->save();

                //Categories (check if category exist)
                if (isset($game['categories'])) {
                    foreach($game['categories'] as $category) {
                        $newCategory = new Category();
                        $newCategory->setId($category['id']);
                        $newCategory->setDescription($category['description']);
                        $newCategory->save();
                    }
                }

                //Genres (check if genre exist)
                if (isset($game['genres'])) {
                    foreach($game['genres'] as $genre) {
                        $newGenre= new Genre();
                        $newGenre->setId($genre['id']);
                        $newGenre->setDescription($genre['description']);
                        $newGenre->save();
                    }
                }

                //Developers (check if developer exist)
                if (isset($game['developers'])) {
                    foreach($game['developers'] as $developer) {
                        $newDeveloper = new Developer();
                        $newDeveloper->setName($developer['developer']);
                        $newDeveloper->save();
                    }
                }

                //Publishers (check if publisher exist)
                if (isset($game['publishers'])) {
                    foreach($game['publishers'] as $publisher) {
                        $newPublisher = new Publisher();
                        $newPublisher->setName($publisher['publisher']);
                        $newPublisher->save();
                    }
                }

                //Screenshots (check if screenshot exist)
                if (isset($game['screenshots'])) {
                    foreach($game['screenshots'] as $screenshot) {
                        $newScreenshot = new Screenshot();
                        $newScreenshot->setPathThumbnail($screenshot['path_thumbnail']);
                        $newScreenshot->setPathFull($screenshot['path_full']);
                        $newScreenshot->save();
                    }
                }

                //Movies (check if movie exist)
                if (isset($game['movies'])) {
                    foreach($game['movies'] as $movie) {
                        $newMovieDetail = new MovieDetail();
                        $newMovieDetail->setId($movie['id']);
                        $newMovieDetail->setName($movie['name']);
                        $newMovieDetail->setThumbnail($movie['name']);
                        $newMovieDetail->save();

                        $newMovieWebm480 = new Movie();
                        $newMovieWebm480->setFormat('webm');
                        $newMovieWebm480->setQuality('480');
                        $newMovieWebm480->setUrl($movie['webm']['480']);
                        $newMovieWebm480->save();

                        $newMovieWebmMax = new Movie();
                        $newMovieWebmMax->setFormat('webm');
                        $newMovieWebmMax->setQuality('max');
                        $newMovieWebmMax->setUrl($movie['webm']['max']);
                        $newMovieWebmMax->save();

                        $newMovieMp4480 = new Movie();
                        $newMovieMp4480->setFormat('mp4');
                        $newMovieMp4480->setQuality('480');
                        $newMovieMp4480->setUrl($movie['mp4']['480']);
                        $newMovieMp4480->save();

                        $newMovieMp4Max = new Movie();
                        $newMovieMp4Max->setFormat('mp4');
                        $newMovieMp4Max->setQuality('max');
                        $newMovieMp4Max->setUrl($movie['mp4']['max']);
                        $newMovieMp4Max->save();

                    }
                }

                //Achievements (check if achievements exist)
                if (isset($game['achievements'])) {
                        $newScreenshot = new Achieve();
                        $newScreenshot->setPathThumbnail($screenshot['path_thumbnail']);
                        $newScreenshot->setPathFull($screenshot['path_full']);
                        $newScreenshot->save();
                }

            }

            echo $yesterday->format('d.m.y');


            return Command::SUCCESS;
        }





        return Command::SUCCESS;

    }
}