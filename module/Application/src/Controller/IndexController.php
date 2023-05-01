<?php

declare(strict_types=1);

namespace Application\Controller;

use Blog\Service\blogService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Event\Service\eventService;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use SteamApi\Service\steamPlayerService;
use StravaApi\Service\StravaService;
use Symfony\Component\VarDumper\VarDumper;
use Twitter\Service\twitterOathService;
use Twitter\Service\twitterService;
use Event\Service\eventCategoryService;

class IndexController extends AbstractActionController
{
    /** @var blogService */
    protected blogService $blogService;
    /** @var eventService */
    protected eventService $eventService;
    /** @var StravaService */
    protected StravaService $stravaService;
    /** @var twitterService */
    protected twitterService $twitterService;
    /** @var twitterOathService */
    protected twitterOathService $twitterOathService;
    /** @var  eventCategoryService */
    protected eventCategoryService $eventCategoryService;
    /**  */
    protected $viewHelperManager;
    /** @var steamPlayerService */
    protected steamPlayerService $steamPlayerService;

    public function __construct(
        blogService        $blogService,
        eventService       $eventService,
        stravaService      $stravaService,
        twitterService     $twitterService,
        twitterOathService $twitterOathService,
                           $viewHelperManager,
        eventCategoryService $eventCategoryService,
        $steamPlayerService
    )
    {
        $this->blogService          = $blogService;
        $this->eventService         = $eventService;
        $this->stravaService        = $stravaService;
        $this->twitterService       = $twitterService;
        $this->twitterOathService   = $twitterOathService;
        $this->viewHelperManager    = $viewHelperManager;
        $this->eventCategoryService = $eventCategoryService;
        $this->steamPlayerService   = $steamPlayerService;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws Exception
     */
    public function indexAction(): ViewModel
    {

        $this->viewHelperManager->get('inlineScript')->appendFile('/assets/js/index.js');
        $this->viewHelperManager->get('inlineScript')->appendFile('/assets/flipClock/js/flipclock.js');
        $this->viewHelperManager->get('headLink')->appendStylesheet('/assets/flipClock/css/flipclock.css');

        //Get blogs
        $blogs = $this->blogService->getOnlineBlogsBasedOnStartAndOffSet(0, 6);
        //Get events
        $events = $this->eventService->getUpcommingEvent(3);
        $upcommingEvent = $this->eventService->getUpcommingEvent();
        //Tweets
        $tweets = $this->twitterOathService->getTwitterUserTimeline(1, 4);
        $tweets = $this->twitterService->createTweetArray($tweets);
        //Steam
        $steamGames = $this->steamPlayerService->getOwnedGames(3);

        return new ViewModel([
            'blogs' => $blogs,
            'events' => $events,
            'totalRunActivities' => $this->stravaService->activityRepository->getTotalItems('Run'),
            'totalRunDistance' => $this->stravaService->activityRepository->getTotalDistance('Run'),
            'totalRunTime' => $this->stravaService->activityRepository->getTotalTime('Run'),
            'averageSpeed' => $this->stravaService->activityRepository->getAverageSpeed('Run'),
            'averageElevation' => $this->stravaService->activityRepository->getAverageElevation('Run'),
            'averageHeartbeat' => $this->stravaService->activityRepository->getAverageHeartbeat('Run'),
            'tweets' => $tweets,
            'upcommingEvent' => $upcommingEvent,
            'steamGames' => $steamGames,
        ]);
    }

    public function eventsAction()
    {
        $this->viewHelperManager->get('headScript')->appendFile('/js/eventsFrontEnd.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/lodash.js');
        $this->viewHelperManager->get('headScript')->appendFile('/js/moment.js');
        $this->viewHelperManager->get('headLink')->appendStylesheet('/css/events.css');
        $currentYear = new \DateTime();
        $year = $currentYear->format('Y');
        $categoryId = 'all';
        if ($this->getRequest()->isPost()) {
            $year = $this->getRequest()->getPost('year');
            $categoryId = $this->getRequest()->getPost('category');
        }

        $events = $this->eventService->getEventsByYearAndCategory($year, $categoryId);
        $categories = $this->eventCategoryService->getEventCategories();
        $years = $this->eventService->getYearsOfEvents();
        $locations = $this->eventService->createEventsArrayForMaps($events);


        // Return variables to view script with the help of
        // ViewObject variable container
        return new ViewModel(array(
            'categories' => $categories,
            'year' => $year,
            'categoryId' => $categoryId,
            'years' => $years
        ));
    }

    /**
     * This is the "event" action. It is used to display the "event" page.
     */
    public function eventAction()
    {
        $id = (int)$this->getRequest()->getPost('eventId');
        $succes = true;
        $errorMessage = null;
        if (empty($id)) {
            $succes = false;
            $errorMessage = 'Geen id meegegeven.';
        }
        $event = $this->eventService->getEventById($id);
        if (empty($event)) {
            $succes = false;
            $errorMessage = 'Event niet gevonden';
        }

        VarDumper::dump($event->getCategory()); die;

        $eventArray = [];
        $eventArray['eventStartDate'] = $event->getEventStartDate()->format('Y-m-d');
        $eventArray['eventEndDate'] = $event->getEventEndDate()->format('Y-m-d');
        $eventArray['title'] = $event->getTitle();
        $eventArray['labelText'] = $event->getLabelText();
        $eventArray['text'] = $event->getText();
        $eventArray['category'] = $event->getCategory()->getName();
        $eventArray['categoryImage'] = $event->getCategory()->getFile()->getPath();
        $image = $event->getEventImage();
        $eventArray['eventImage'] = $image->getImageTypes('original')[0]->getFolder() . $image->getImageTypes('original')[0]->getFileName();

        VarDumper::dump($event->getCategory()); die;

        // Return variables to view script with the help of
        // ViewObject variable container
        return new JsonModel(array(
            'succes' => $succes,
            'event' => $eventArray,
            'errorMessage' => $errorMessage
        ));
    }


    public function getLocationsAction()
    {
        $success = true;
        $errorMessage = null;

        $year = $this->getRequest()->getPost('year');
        $categoryId = $this->getRequest()->getPost('category');

        $events = $this->eventService->getEventsByYearAndCategory($year, $categoryId);
        $categories = $this->eventCategoryService->getEventCategories();
        $years = $this->eventService->getYearsOfEvents();
        $locations = $this->eventService->createEventsArrayForMaps($events);
        $events = $this->eventService->getEventsByYearAndCategory($year, $categoryId, true);

        return new JsonModel(array(
            'success' => $success,
            'years' => $years,
            'categories' => $categories,
            'locations' => $locations,
            'events' => $events,
            'errorMessage' => $errorMessage
        ));
    }
}
