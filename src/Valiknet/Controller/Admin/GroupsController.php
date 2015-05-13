<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Group;
use Valiknet\Model\Model;

class GroupsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $groups = Group::findBy();

        return $app['twig']->render('admin/groups/index.html.twig', ['groups' => $groups]);
    }
}
