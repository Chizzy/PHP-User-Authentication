<?php

require_once __DIR__ . '/bootstrap.php';

$session->getFlashBag()->add('success', 'Successfully Logged Out');
$cookie = setAuthCookie('expired', 1);
redirect('/login.php', ['cookie' => $cookie]);
