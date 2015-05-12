<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;

class TeachersController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        return $app['twig']->render('admin/teachers/index.html.twig');
    }
}
