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

        return $app['twig']->render('subjects/index.html.twig', $parameters);
    }

    public function viewAction(Application $app, Request $request, $subject_code)
    {
        $subject = Subject::findOneBy($subject_code);

        return $app['twig']->render('subjects/view.html.twig', ['subject' => $subject]);
    }
}
