<?php

declare(strict_types=1);

namespace Application\Controller;

use Blog\Service\blogService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Event\Service\eventService;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use StravaApi\Service\StravaService;
use Twitter\Service\twitterOathService;
use Twitter\Service\twitterService;

class IndexController extends AbstractActionController
{
    /** @var blogService */
    protected $blogService;
    /** @var eventService */
    protected $eventService;
    /** @var StravaService */
    protected $stravaService;
    /** @var twitterService */
    protected $twitterService;
    /** @var twitterOathService  */
    protected $twitterOathService;

    public function __construct(
        blogService $blogService,
        eventService $eventService,
        stravaService $stravaService,
        twitterService $twitterService,
        twitterOathService $twitterOathService
    ) {
        $this->blogService          = $blogService;
        $this->eventService         = $eventService;
        $this->stravaService        = $stravaService;
        $this->twitterService       = $twitterService;
        $this->twitterOathService   = $twitterOathService;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws Exception
     */
    public function indexAction(): ViewModel
    {
        //Get blogs
        $blogs = $this->blogService->getOnlineBlogsBasedOnStartAndOffSet(0, 6);
        //Get events
        $events         = $this->eventService->getUpcommingEvent(3);

        $upcommingEvent = $this->eventService->getUpcommingEvent();

        //Tweets
        $tweets = $this->twitterOathService->getTwitterUserTimeline(1, 4);
        $tweets = $this->twitterService->createTweetArray($tweets);

        return new ViewModel([
            'blogs'                 => $blogs,
            'events'                => $events,
            'totalRunActivities'    => $this->stravaService->activityRepository->getTotalItems('Run'),
            'totalRunDistance'      => $this->stravaService->activityRepository->getTotalDistance('Run'),
            'totalRunTime'          => $this->stravaService->activityRepository->getTotalTime('Run'),
            'averageSpeed'          => $this->stravaService->activityRepository->getAverageSpeed('Run'),
            'averageElevation'      => $this->stravaService->activityRepository->getAverageElevation('Run'),
            'averageHeartbeat'      => $this->stravaService->activityRepository->getAverageHeartbeat('Run'),
            'tweets'                => $tweets,
            'upcommingEvent'        => $upcommingEvent,
        ]);
    }
}
