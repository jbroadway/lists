<?php

$this->require_acl ('admin', 'lists', 'admin/edit');

if (! isset ($_POST['list'])) {
	$this->add_notification (__ ('Missing list.'));
	$this->redirect ('/lists/admin');
}

$list = new lists\Lists ($_POST['list']);
if ($list->error) {
	$this->add_notification (__ ('List not found.'));
	$this->redirect ('/lists/admin');
}

if (! isset ($_POST['user'])) {
	$this->add_notification (__ ('Missing member.'));
	$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));
}

$u = new User ($_POST['user']);
if ($u->error) {
	$this->add_notification (__ ('Member not found.'));
	$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));
}

$m = new lists\Member (array (
	'list' => $_POST['list'],
	'user' => $_POST['user'],
	'notes' => ''
));
if (! $m->put ()) {
	$this->add_notification (__ ('Member already exists.'));
	$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));
}

$this->add_notification (__ ('Member added.'));
$this->redirect ('/lists/edit?id=' . Template::sanitize ($_POST['list']));

?>