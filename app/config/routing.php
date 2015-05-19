<?php

//Events
$app->get('/', 'Valiknet\Controller\EventsController::indexAction');

//Groups
$app->get('/groups', 'Valiknet\Controller\GroupsController::indexAction');
$app->get('/groups/{group_code}', 'Valiknet\Controller\GroupsController::viewAction')
->bind('view_group_client');

//Subject
$app->get('/subjects', 'Valiknet\Controller\SubjectsController::indexAction');
$app->get('/subjects/{subject_code}', 'Valiknet\Controller\SubjectsController::viewAction')
->bind('view_subject_client');

//Auditories
$app->get('/auditories', 'Valiknet\Controller\AuditoriesController::indexAction');
$app->get('/auditories/{auditory_number}', 'Valiknet\Controller\AuditoriesController::viewAction')
->bind('view_auditory_client');

//Teachers
$app->get('/teachers', 'Valiknet\Controller\TeachersController::indexAction');
$app->get('/teachers/{teacher_code}', 'Valiknet\Controller\TeachersController::viewAction')
->bind('view_teacher_client');

//Admin

//Events
$app->get('/admin', 'Valiknet\Controller\Admin\EventsController::indexAction');

//Groups
$app->get('/admin/groups', 'Valiknet\Controller\Admin\GroupsController::indexAction')
    ->bind('list_groups_admin');
$app->get('/admin/groups/new', 'Valiknet\Controller\Admin\GroupsController::newAction')
    ->bind('create_group');
$app->post('/admin/groups/story', 'Valiknet\Controller\Admin\GroupsController::storyAction')
    ->bind('story_group');

//Subject
$app->get('/admin/subjects', 'Valiknet\Controller\Admin\SubjectsController::indexAction');

//Auditories
$app->get('/admin/auditories', 'Valiknet\Controller\Admin\AuditoriesController::indexAction')
    ->bind('list_auditories_admin');
$app->get('/admin/auditories/new', 'Valiknet\Controller\Admin\AuditoriesController::createAction')
    ->bind('create_auditory');
$app->post('/admin/auditories/store', 'Valiknet\Controller\Admin\AuditoriesController::storeAction')
    ->bind('store_auditory');

//Teachers
$app->get('/admin/teachers', 'Valiknet\Controller\Admin\TeachersController::indexAction');
