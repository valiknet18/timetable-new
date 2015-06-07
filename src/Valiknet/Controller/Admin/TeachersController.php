<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;
use Valiknet\Model\Teacher;

class TeachersController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $count = 10;

        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $count;

        $teachers = Teacher::findBy(null, ['limit' => $count, 'offset' => $offset]);

        $parameters = [
            'teachers' => $teachers
        ];

        if (count($teachers) > 0) {
            $next_page = $page + 1;
            $prev_page = $page - 1;

            $pagination = [
                'next_page' => $next_page,
                'prev_page' => $prev_page,
                'current_page' => $page
            ];

            $parameters['pagination'] = $pagination;
        }

        return $app['twig']->render('admin/teachers/index.html.twig', $parameters);
    }

    public function newAction(Application $app, Request $request)
    {
        $subjects = Subject::findBy();

        return $app['twig']->render('admin/teachers/new.html.twig', ['subjects' => $subjects]);
    }

    public function storeAction(Application $app, Request $request)
    {
        $teacher = new Teacher();

        $teacher->teacher_name = $request->request->get('teacher_name');
        $teacher->teacher_surname = $request->request->get('teacher_surname');
        $teacher->teacher_last_name = $request->request->get('teacher_last_name');
        $teacher->teacher_phone = $request->request->get('teacher_phone');

        foreach ($request->request->get('subjects') as $subject) {
            $sb = Subject::findOneBy($subject);
            $teacher->subjects[] = $sb;
        }

        $teacher->create();

        return $app->redirect($app['url_generator']->generate('list_teachers_admin'));
    }

    public function getAction(Application $app, Request $request)
    {
        $teacher = Teacher::findOneBy($request->query->get('teacher_code'));

        return new Response(json_encode($teacher), 200, array('Content-type' => 'application/json'));
    }
}
