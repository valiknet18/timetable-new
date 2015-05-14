<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;
use Valiknet\Model\Teacher;

class TeachersController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $teachers = Teacher::findBy();

        return $app['twig']->render('admin/teachers/index.html.twig', ['teachers' => $teachers]);
    }
}
