<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Auditory;
use Valiknet\Model\Model;

class AuditoriesController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $count = 10;

        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $count;

        $auditories = Auditory::findBy(null, ['limit' => $count, 'offset' => $offset]);

        $parameters = [
            'auditories' => $auditories
        ];

        if (count($auditories) > 0) {
            $next_page = $page + 1;
            $prev_page = $page - 1;

            $pagination = [
                'next_page' => $next_page,
                'prev_page' => $prev_page,
                'current_page' => $page
            ];

            $parameters['pagination'] = $pagination;
        }

        return $app['twig']->render('auditories/index.html.twig', $parameters);
    }

    public function viewAction(Application $app, $auditory_number)
    {
        $auditory = Auditory::findOneBy($auditory_number);

        return $app['twig']->render('auditories/view.html.twig', ['auditory' => $auditory]);
    }
}
