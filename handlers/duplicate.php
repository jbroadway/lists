<?php

$this->require_acl ('admin', 'lists', 'admin/add');

$list = new lists\Lists ($_GET['id']);
if ($list->error) {
	$this->add_notification (__ ('List not found.'));
	$this->redirect ('/lists/admin');
}

$list = (array) $list->orig ();
unset ($list['id']);
$list['name'] .= ' (' . __ ('copy') . ')';

$new = new lists\Lists ($list);
if (! $new->put ()) {
	$this->add_notification (__ ('Error duplicating list.'));
	$this->redirect ('/lists/admin');
}

if (! lists\Member::duplicate ($_GET['id'], $new->id)) {
	$this->add_notification (__ ('Error duplicating list.'));
	$this->redirect ('/lists/admin');
}

$this->add_notification (__ ('List duplicated.'));
$this->redirect ('/lists/edit?id=' . $new->id);

?>