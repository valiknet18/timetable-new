<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Model\Model;

class TeachersController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('teachers/index.html.twig');
    }
}
