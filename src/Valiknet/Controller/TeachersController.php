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

        return $app['twig']->render('teachers/index.html.twig', $parameters);
    }

    public function viewAction(Application $app, Request $request, $teacher_code)
    {
        $teacher = Teacher::findOneBy($teacher_code);

        return $app['twig']->render('teachers/view.html.twig', ['teacher' => $teacher]);
    }
}
