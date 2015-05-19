<?php

namespace Valiknet\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Model\Group;
use Valiknet\Model\Model;

class GroupsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $groups = Group::findBy();

        return $app['twig']->render('groups/index.html.twig', ['groups' => $groups]);
    }

    public function viewAction(Application $app, Request $request, $group_code)
    {
        $group = Group::findOneBy($group_code);

        return $app['twig']->render('groups/view.html.twig', ['group' => $group]);
    }
}
