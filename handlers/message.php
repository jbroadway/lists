<?php

$this->require_acl ('admin', 'lists');

$list = new lists\Lists ($_GET['id']);

$page->title = $list->name . ' - ' . __ ('Message list');
$page->layout = 'admin';

$form = new Form ('post', $this);

$form->data = array (
	'id' => $_GET['id']
);

echo $form->handle (function ($form) use ($page, $list) {
	$members = lists\Member::query ('m.notes, u.name, u.email')
		->from ('#prefix#lists_member m, #prefix#user u')
		->where ('m.user = u.id')
		->where ('m.list', $_GET['id'])
		->fetch_orig ();

	$count = 0;

	try {
		set_time_limit (0);

		foreach ($members as $member) {
			Mailer::send (array (
				'to' => array ($member->email, $member->name),
				'subject' => $_POST['subject'],
				'text' => $_POST['body']
			));

			$count++;
		}
	} catch (Exception $e) {
		error_log ('Error sending message: ' . $e->getMessage ());
		$form->failed[] = 'email';
		return false;
	}
	
	$form->controller->add_notification (__ ('%d messages sent.', $count));
	$form->controller->redirect ('/lists/edit?id=' . Template::sanitize ($_GET['id']));
});
