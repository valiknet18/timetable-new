<?php

namespace Valiknet\Controller\Admin;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Valiknet\Controller\AbstractController;
use Valiknet\Model\Group;
use Valiknet\Model\Model;
use Valiknet\Model\Subject;

class GroupsController extends AbstractController
{
    public function indexAction(Application $app, Request $request)
    {
        $count = 10;

        $page = $request->query->get('page', 1);
        $offset = ($page - 1) * $count;

        $groups = Group::findBy(null, ['limit' => $count, 'offset' => $offset]);

        $parameters = [
            'groups' => $groups
        ];

        if (count($groups) > 0) {
            $next_page = $page + 1;
            $prev_page = $page - 1;

            $pagination = [
                'next_page' => $next_page,
                'prev_page' => $prev_page,
                'current_page' => $page
            ];

            $parameters['pagination'] = $pagination;
        }

        return $app['twig']->render('admin/groups/index.html.twig', $parameters);
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

    public function getAction(Application $app, Request $request)
    {
        $groups = Group::findBy($request->query->get('group_course'));

        return new Response(json_encode($groups), 200, ['Content-type' => 'application/json']);
    }
}
