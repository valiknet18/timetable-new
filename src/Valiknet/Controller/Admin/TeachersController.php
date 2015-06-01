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
        $teachers = Teacher::findBy();

        return $app['twig']->render('admin/teachers/index.html.twig', ['teachers' => $teachers]);
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
