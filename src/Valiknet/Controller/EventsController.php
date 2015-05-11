<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class EventsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return new Response('Hello world');
    }
}
