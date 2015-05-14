<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('events/index.html.twig');
    }
}
