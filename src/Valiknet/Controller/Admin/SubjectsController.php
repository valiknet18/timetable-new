<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;
use Valiknet\Model\Teacher;

class SubjectsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $subjects = Subject::findBy();

        return $app['twig']->render('admin/subjects/index.html.twig', ['subjects' => $subjects]);
    }

    public function newAction(Application $app, Request $request)
    {
        $teachers = Teacher::findBy();

        return $app['twig']->render('admin/subjects/new.html.twig', ['teachers' => $teachers]);
    }

    public function storeAction(Application $app, Request $request)
    {
        $subject = new Subject();

        $subject->subject_name = $request->request->get('subject_name');

        foreach ($request->request->get('teachers') as $teacher) {
            $tc = Teacher::findOneBy($teacher);

            $subject->teachers[] = $tc;
        }

        $subject->create();

        return $app->redirect($app['url_generator']->generate('list_subjects_admin'));
    }
}
