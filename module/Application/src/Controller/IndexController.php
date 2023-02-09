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
    protected $eventCategoryService;
    /**  */
    protected $viewHelperManager;

    public function __construct(
        blogService        $blogService,
        eventService       $eventService,
        stravaService      $stravaService,
        twitterService     $twitterService,
        twitterOathService $twitterOathService,
                           $viewHelperManager,
        eventCategoryService $eventCategoryService
    )
    {
        $this->blogService          = $blogService;
        $this->eventService         = $eventService;
        $this->stravaService        = $stravaService;
        $this->twitterService       = $twitterService;
        $this->twitterOathService   = $twitterOathService;
        $this->viewHelperManager    = $viewHelperManager;
        $this->eventCategoryService = $eventCategoryService;
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
