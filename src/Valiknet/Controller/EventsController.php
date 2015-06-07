<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Event;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request, $timestamp = null)
    {
        $count = 10;

        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $count;

        if ($timestamp) {
            $date = new \DateTime();
            $date->setTimestamp($timestamp);
        } else {
            $date = new \DateTime();
            $timestamp = $date->getTimestamp();
        }

        $timestamps = [];
        $timestamps['current'] = $date->format('d-m-Y');

        $prevday = clone($date);
        $prevday->modify('-1 day');
        $timestamps['prevday'] = $prevday->getTimestamp();

        $nextday = clone ($date);
        $nextday->modify('+1 day');
        $timestamps['nextday'] = $nextday->getTimestamp();

        $events = Event::findBy(null, true, $timestamp, ['limit' => $count, 'offset' => $offset]);

        $parameters = [
            'events' => $events,
            'timestamps' => $timestamps
        ];

        if (count($events) > 0) {
            $next_page = $page + 1;
            $prev_page = $page - 1;

            $pagination = [
                'next_page' => $next_page,
                'prev_page' => $prev_page,
                'current_page' => $page
            ];

            $parameters['pagination'] = $pagination;
        }

        return $app['twig']->render('events/index.html.twig', $parameters);
    }

    public function viewAction(Application $app, Request $request, $event_code)
    {
        $event = Event::findOneBy($event_code);

        return $app['twig']->render('events/view.html.twig', ['event' => $event]);
    }
}
