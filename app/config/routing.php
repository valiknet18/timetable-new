<?php

//Events
$app->get('/', 'Valiknet\Controller\EventsController::indexAction');

//Groups
$app->get('/groups', 'Valiknet\Controller\GroupsController::indexAction');

//Subject
$app->get('/subjects', 'Valiknet\Controller\SubjectsController::indexAction');

//Auditories
$app->get('/auditories', 'Valiknet\Controller\AuditoriesController::indexAction');

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
$app->get('/admin/auditories', 'Valiknet\Controller\Admin\AuditoriesController::indexAction');

//Teachers
$app->get('/admin/teachers', 'Valiknet\Controller\Admin\TeachersController::indexAction');
