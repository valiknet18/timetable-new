<?php

//Events
$app->get('/', 'Valiknet\Controller\EventsController::indexAction')
->bind('list_events_client');
$app->get('/event/{timestamp}/date', 'Valiknet\Controller\EventsController::indexAction')
->bind('change_date_link');

$app->get('/events/{event_code}', 'Valiknet\Controller\EventsController::viewAction')
->bind('view_event_client');


//Groups
$app->get('/groups', 'Valiknet\Controller\GroupsController::indexAction')
->bind('list_groups_client');
$app->get('/groups/{group_code}', 'Valiknet\Controller\GroupsController::viewAction')
->bind('view_group_client');

//Subject
$app->get('/subjects', 'Valiknet\Controller\SubjectsController::indexAction')
->bind('list_subjects_client');
$app->get('/subjects/{subject_code}', 'Valiknet\Controller\SubjectsController::viewAction')
->bind('view_subject_client');

//Auditories
$app->get('/auditories', 'Valiknet\Controller\AuditoriesController::indexAction')
->bind('list_auditories_client');
$app->get('/auditories/{auditory_number}', 'Valiknet\Controller\AuditoriesController::viewAction')
->bind('view_auditory_client');

//Teachers
$app->get('/teachers', 'Valiknet\Controller\TeachersController::indexAction')
->bind('list_teachers_client');
$app->get('/teachers/{teacher_code}', 'Valiknet\Controller\TeachersController::viewAction')
->bind('view_teacher_client');

//Admin

//Events
$app->get('/admin', 'Valiknet\Controller\Admin\EventsController::indexAction')
    ->bind('list_events_admin');
$app->get('/admin/event/{timestamp}/date', 'Valiknet\Controller\Admin\EventsController::indexAction')
    ->bind('change_date_link_admin');

//$app->get('/admin/events/{event_code}', 'Valiknet\Controller\Admin\EventsController::indexAction');
$app->get('/admin/events/create', 'Valiknet\Controller\Admin\EventsController::createAction')
    ->bind('create_events');
$app->post('/admin/events/story', 'Valiknet\Controller\Admin\EventsController::storeAction')
    ->bind('story_event');
$app->get('admin/events/get', 'Valiknet\Controller\Admin\EventsController::getAction')
    ->bind('get_event');

//Groups
$app->get('/admin/groups', 'Valiknet\Controller\Admin\GroupsController::indexAction')
    ->bind('list_groups_admin');
$app->get('/admin/groups/new', 'Valiknet\Controller\Admin\GroupsController::newAction')
    ->bind('create_group');
$app->post('/admin/groups/story', 'Valiknet\Controller\Admin\GroupsController::storyAction')
    ->bind('story_group');
$app->get('/admin/groups/get', 'Valiknet\Controller\Admin\GroupsController::getAction')
    ->bind('get_group');

//Subject
$app->get('/admin/subjects', 'Valiknet\Controller\Admin\SubjectsController::indexAction')
    ->bind('list_subjects_admin');
$app->get('/admin/subjects/new', 'Valiknet\Controller\Admin\SubjectsController::newAction')
    ->bind('create_subject');
$app->post('/admin/subjects/story', 'Valiknet\Controller\Admin\SubjectsController::storeAction')
    ->bind('story_subject');

//Auditories
$app->get('/admin/auditories', 'Valiknet\Controller\Admin\AuditoriesController::indexAction')
    ->bind('list_auditories_admin');
$app->get('/admin/auditories/new', 'Valiknet\Controller\Admin\AuditoriesController::newAction')
    ->bind('create_auditory');
$app->post('/admin/auditories/store', 'Valiknet\Controller\Admin\AuditoriesController::storeAction')
    ->bind('store_auditory');
$app->get('/admin/auditories/get', 'Valiknet\Controller\Admin\AuditoriesController::getAction')
    ->bind('get_auditory');

//Teachers
$app->get('/admin/teachers', 'Valiknet\Controller\Admin\TeachersController::indexAction')
    ->bind('list_teachers_admin');
$app->get('/admin/teachers/new', 'Valiknet\Controller\Admin\TeachersController::newAction')
    ->bind('create_teacher');
$app->post('/admin/teachers/story', 'Valiknet\Controller\Admin\TeachersController::storeAction')
    ->bind('story_teacher');
$app->get('/admin/teachers/get', 'Valiknet\Controller\Admin\TeachersController::getAction')
    ->bind('get_teacher');
