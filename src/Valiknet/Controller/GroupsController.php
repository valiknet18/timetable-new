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

        return $app['twig']->render('groups/index.html.twig', $parameters);
    }

    public function viewAction(Application $app, Request $request, $group_code)
    {
        $group = Group::findOneBy($group_code);

        return $app['twig']->render('groups/view.html.twig', ['group' => $group]);
    }
}
