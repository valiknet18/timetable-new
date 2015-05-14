<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('admin/events/index.html.twig');
    }
}
