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
        $auditories = Auditory::findBy();

        return $app['twig']->render('auditories/index.html.twig', ['auditories' => $auditories]);
    }

    public function viewAction(Application $app, $auditory_number)
    {
        $auditory = Auditory::findOneBy(['auditory_number' => $auditory_number]);

        return $app['twig']->render('auditories/view.html.twig', ['auditory' => $auditory]);
    }
}
