<?php

$page->layout = false;

$this->require_acl ('admin', 'lists', 'admin/edit');

$notice = false;

switch ($_POST['property']) {
	case 'name':
	case 'description':
		$list = new lists\Lists ($_POST['id']);
		if ($list->error) {
			$notice = __ ('List not found.');
			break;
		}
		
		$list->{$_POST['property']} = $_POST['value'];
		if (! $list->put ()) {
			error_log ('Error updating list ' . $_POST['property'] . ': ' . $list->error);
			$notice = __ ('An unknown error occurred.');
			break;
		}
		
		$notice = __ ('Changes saved.');
		break;

	case 'notes':
		$m = new lists\Member ($_POST['id']);
		if ($m->error) {
			$notice = __ ('Member not found.');
			break;
		}
		
		$m->notes = $_POST['value'];
		if (! $m->put ()) {
			error_log ('Error updating notes: ' . $m->error);
			$notice = __ ('An unknown error occurred.');
			break;
		}
		
		$notice = __ ('Notes saved.');
		break;
}

if ($notice) {
	$this->add_notification ($notice);
}

echo Template::sanitize ($_POST['value']);

?>