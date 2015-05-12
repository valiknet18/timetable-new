<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Model\Model;

class SubjectsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('subjects/index.html.twig');
    }
}
