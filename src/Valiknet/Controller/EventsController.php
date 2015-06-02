<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Event;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request, $timestamp = null)
    {
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

        $events = Event::findBy(null, true, $timestamp);

        return $app['twig']->render('events/index.html.twig', ['timestamps' => $timestamps, 'events' => $events]);
    }

    public function viewAction(Application $app, Request $request, $event_code)
    {
        $event = Event::findOneBy($event_code);

        return $app['twig']->render('events/view.html.twig', ['event' => $event]);
    }
}
