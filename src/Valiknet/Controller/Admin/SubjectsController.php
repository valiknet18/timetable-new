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
        $count = 10;

        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $count;

        $subjects = Subject::findBy(null, ['limit' => $count, 'offset' => $offset]);

        $parameters = [
            'subjects' => $subjects
        ];

        if (count($subjects) > 0) {
            $next_page = $page + 1;
            $prev_page = $page - 1;

            $pagination = [
                'next_page' => $next_page,
                'prev_page' => $prev_page,
                'current_page' => $page
            ];

            $parameters['pagination'] = $pagination;
        }

        return $app['twig']->render('admin/subjects/index.html.twig', $parameters);
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
