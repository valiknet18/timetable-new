<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Model;
use Valiknet\Model\Teacher;

class TeachersController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $teachers = Teacher::findBy();

        return $app['twig']->render('teachers/index.html.twig', ['teachers' => $teachers]);
    }

    public function viewAction(Application $app, Request $request, $teacher_code)
    {
        $teacher = Teacher::findOneBy($teacher_code);

        return $app['twig']->render('teachers/view.html.twig', ['teacher' => $teacher]);
    }
}
