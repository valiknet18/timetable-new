<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;

class SubjectsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $subjects = Subject::findBy();

        return $app['twig']->render('admin/subjects/index.html.twig', ['subjects' => $subjects]);
    }

    public function newAction(Application $app, Request $request)
    {

    }

    public function storeAction(Application $app, Request $request)
    {

    }
}
