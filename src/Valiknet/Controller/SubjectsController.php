<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;

class SubjectsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $subjects = Subject::findBy();

        return $app['twig']->render('subjects/index.html.twig', ['subjects' => $subjects]);
    }

    public function viewAction(Application $app, Request $request, $subject_code)
    {
        $subject = Subject::findOneBy($subject_code);

        return $app['twig']->render('subjects/view.html.twig', ['subject' => $subject]);
    }
}
