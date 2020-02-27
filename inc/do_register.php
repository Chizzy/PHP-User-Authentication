<?php

require_once __DIR__ . '/bootstrap.php';

$username = request()->get('username');
$password = request()->get('password');
$confirm_password = request()->get('confirm_password');

if ($password != $confirm_password) {
    $session->getFlashBag()->add('error', 'Passwords do NOT match');
    redirect('/register.php');
}

$user = findUserByUsername($username);
if (!empty($user)) {
    $session->getFlashBag()->add('error', 'User Already Exists');
    redirect('/register.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$user = createUser($username, $hashed);
$session->getFlashBag()->add('success', 'User Registered');
saveUserData($user);
