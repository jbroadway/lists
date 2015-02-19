<?php

$this->require_acl ('admin', 'lists', 'admin/delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$this->redirect ('/lists/admin');
}

$list = new lists\Lists;
$list->remove ($_POST['id']);

if ($list->error) {
	error_log ('Error deleting list: ' . DB::error ());
	$this->add_notification (__ ('Unable to delete list.'));
	$this->redirect ('/lists/admin');
}

lists\Member::delete_list ($_POST['id']);

$this->add_notification (__ ('List deleted.'));
$this->redirect ('/lists/admin');

?>