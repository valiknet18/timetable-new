<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Auditory;
use Valiknet\Model\Event;
use Valiknet\Model\Everyday;
use Valiknet\Model\Everymonth;
use Valiknet\Model\Everyweek;
use Valiknet\Model\Exception;
use Valiknet\Model\Teacher;

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

        return $app['twig']->render('admin/events/index.html.twig', ['events' => $events, 'timestamps' => $timestamps]);
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

    }
}
