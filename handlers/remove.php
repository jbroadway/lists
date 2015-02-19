<?php

$this->require_acl ('admin', 'lists', 'admin/delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$this->redirect ('/lists/admin');
}

$m = new lists\Member;
$m->remove ($_POST['id']);

if ($list->error) {
	error_log ('Error deleting member: ' . DB::error ());
	$this->add_notification (__ ('Unable to remove member.'));
	$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));
}

$this->add_notification (__ ('Member removed.'));
$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));

?>