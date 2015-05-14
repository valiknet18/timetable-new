<?php

//Events
$app->get('/', 'Valiknet\Controller\EventsController::indexAction');

//Groups
$app->get('/groups', 'Valiknet\Controller\GroupsController::indexAction');

//Subject
$app->get('/subjects', 'Valiknet\Controller\SubjectsController::indexAction');

//Auditories
$app->get('/auditories', 'Valiknet\Controller\AuditoriesController::indexAction');
$app->get('/auditories/{auditory_number}', 'Valiknet\Controller\AuditoriesController::viewAction')
->bind('view_auditory_client');

//Teachers
$app->get('/teachers', 'Valiknet\Controller\TeachersController::indexAction');


//Admin

//Events
$app->get('/admin', 'Valiknet\Controller\Admin\EventsController::indexAction');

//Groups
$app->get('/admin/groups', 'Valiknet\Controller\Admin\GroupsController::indexAction');

//Subject
$app->get('/admin/subjects', 'Valiknet\Controller\Admin\SubjectsController::indexAction');

//Auditories
$app->get('/admin/auditories', 'Valiknet\Controller\Admin\AuditoriesController::indexAction')
    ->bind('list_auditories_admin');
$app->get('/admin/auditories/new', 'Valiknet\Controller\Admin\AuditoriesController::createAction');
$app->post('/admin/auditories/store', 'Valiknet\Controller\Admin\AuditoriesController::storeAction')
    ->bind('store_auditory');

//Teachers
$app->get('/admin/teachers', 'Valiknet\Controller\Admin\TeachersController::indexAction');
