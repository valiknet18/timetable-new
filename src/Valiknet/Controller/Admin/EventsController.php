<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Auditory;
use Valiknet\Model\Event;
use Valiknet\Model\Everyday;
use Valiknet\Model\Everymonth;
use Valiknet\Model\Everyweek;
use Valiknet\Model\Exception;
use Valiknet\Model\Group;
use Valiknet\Model\Teacher;

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

        return $app['twig']->render('admin/events/index.html.twig', $parameters);
    }

    public function createAction(Application $app, Request $request)
    {
        $teachers = Teacher::findBy();
        $events = Event::findBy();

        return $app['twig']->render(
            'admin/events/create.html.twig',
            [
                'teachers' => $teachers,
                'events' => $events
            ]
        );
    }

    public function storeAction(Application $app, Request $request)
    {
        switch ($request->request->get('repeat_type')) {
            case 0:
                $event = new Event();

                $event->setData($request);
                $event->create();

                break;

            case 1:

                $event = new Everyday();

                $event->setData($request);
                $event->create();

                break;

            case 2:

                $event = new Everyweek();

                $event->setData($request);
                $event->create();

                break;

            case 3:

                $event = new Everymonth();

                $event->setData($request);
                $event->create();

                break;

            case 4:

                $event = new Exception();

                $event->setData($request);
                $event->create();

                break;
        }

        return $app->redirect($app['url_generator']->generate('list_events_admin'));
    }

    public function getAction(Application $app, Request $request)
    {
        $events = Event::findBy();

        return new Response(json_encode($events), 200, ['Content-type' => 'application/json']);
    }
}
