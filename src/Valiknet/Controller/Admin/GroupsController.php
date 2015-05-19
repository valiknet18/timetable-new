<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Group;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;

class GroupsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $groups = Group::findBy();

        return $app['twig']->render('admin/groups/index.html.twig', ['groups' => $groups]);
    }

    public function newAction(Application $app, Request $request)
    {
        $subjects = Subject::findBy();

        return $app['twig']->render('admin/groups/create.html.twig', ['subjects' => $subjects]);
    }

    public function storyAction(Application $app, Request $request)
    {
        $group = new Group();

        $group->group_name = $request->request->get('group_name');
        $group->group_course = $request->request->get('group_course');
        $group->group_students_count = $request->request->get('group_students_count');

        $group->create();

        return $app->redirect($app['url_generator']->generate('list_groups_admin'));
    }
}
