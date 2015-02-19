<?php

$this->require_acl ('admin', 'lists', 'admin/add');

$page->layout = 'admin';
$page->title = __ ('Create a list');

$form = new Form ('post', $this);

echo $form->handle (function ($form) {
	// Create and save a new list 
	$list = new lists\Lists (array (
		'name' => $_POST['name'], 
		'description' => $_POST['description'] 
	));
	$list->put ();

	if ($list->error) {
		// Failed to save
		error_log ('Error adding list: ' . DB::error ());
		$form->controller->add_notification (__ ('Unable to save list.'));
		return false;
	}

	// Save a version of the list 
	Versions::add ($list);

	// Notify the user and redirect on success
	$form->controller->add_notification (__ ('List created.'));
	$form->controller->redirect ('/lists/edit?id=' . $list->id);
});

?>