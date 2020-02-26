<?php
require_once 'bootstrap.php';
requireAuth();

$action = request()->get('action');
$task_id = request()->get('task_id');
$task = request()->get('task');
$status = request()->get('status');
$user_id = request()->get('user_id');

$url="../task_list.php";
if (request()->get('filter')) {
    $url.="?filter=".request()->get('filter');
}

switch ($action) {
case "add":
    if (empty($task)) {
        $session->getFlashBag()->add('error', 'Please enter a task');
    } else {
        if (createTask(['task'=>$task, 'status'=>$status], $session->get('auth_user_id'))) {
            $session->getFlashBag()->add('success', 'New Task Added');
        }
    }
    break;
case "update":
    $data = ['task_id'=>$task_id, 'task'=>$task, 'status'=>$status];
    if (!isOwner($user_id)) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/task_list.php');
    } elseif (updateTask($data)) {
        $session->getFlashBag()->add('success', 'Task Updated');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT update task');
    }
    break;
case "status":
    if (updateStatus(['task_id'=>$task_id, 'status'=>$status])) {
        if ($status == 1) $session->getFlashBag()->add('success', 'Task Complete');
    }
    break;
case "delete":
    if (!isOwner($user_id)) {
        $session->getFlashBag()->add('error', 'Not Authorized');
        redirect('/task_list.php');
    } elseif (deleteTask($task_id)) {
        $session->getFlashBag()->add('success', 'Task Deleted');
    } else {
        $session->getFlashBag()->add('error', 'Could NOT Delete Task');
    }
    break;
}
header("Location: ".$url);