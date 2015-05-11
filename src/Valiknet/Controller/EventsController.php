<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return new Response('Hello world');
    }
}
