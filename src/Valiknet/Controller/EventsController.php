<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Model\Model;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
//        $pdo = Model::exec("SELECT get_event_by_day()");

        return $app['twig']->render('events/index.html.twig');
    }
}
