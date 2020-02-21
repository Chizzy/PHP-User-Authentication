<?php

require_once __DIR__ . '/bootstrap.php';

$session->remove('auth_logged_in');
$session->remove('auth_user_id');

$session->getFlashBag()->add('success', 'Successfully Logged Out');
redirect('/login.php');
