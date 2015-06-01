<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Auditory;
use Valiknet\Model\Model;

class AuditoriesController extends AbstractController
{
    public function indexAction(Application $app)
    {
        $auditories = Auditory::findBy();

        return $app['twig']->render('admin/auditories/index.html.twig', ['auditories' => $auditories]);
    }

    public function newAction(Application $app)
    {
        return $app['twig']->render('/admin/auditories/create.html.twig');
    }

    public function storeAction(Application $app, Request $request)
    {
        $auditory = new Auditory();

        $auditory->auditory_number = $request->request->get('auditory_number');
        $auditory->auditory_type = $request->request->get('auditory_type');

        $auditory->create();

        return $app->redirect($app['url_generator']->generate('list_auditories_admin'));
    }

    public function getAction(Application $app, Request $request)
    {
        $auditories = Auditory::findBy($request->query->get('auditory_type'));

        return new Response(json_encode($auditories), 200, ['Content-type' => 'application/json']);
    }
}
