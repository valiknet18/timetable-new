<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('admin/events/index.html.twig');
    }
}
