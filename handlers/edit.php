<?php

$this->require_acl ('admin', 'lists');

if (User::require_acl ('admin/edit')) {
	$this->run ('admin/util/editable', array ('url' => '/lists/editable'));
}

$list = new lists\Lists ($_GET['id']);

$page->layout = 'admin';
$page->title = sprintf (
	'<div class="editable-text" data-property="name" id="%s">%s</div>',
	Template::sanitize ($_GET['id']),
	Template::sanitize ($list->name)
);
$page->window_title = $list->name;

$list = $list->orig ();
$list->members = lists\Member::query ('m.id, m.notes, u.name')
	->from ('#prefix#lists_member m, #prefix#user u')
	->where ('m.user = u.id')
	->where ('m.list', $_GET['id'])
	->order ('u.name', 'asc')
	->fetch_orig ();
$list->chosen = array ();
foreach ($list->members as $member) {
	$list->chosen[] = $member->id;
}

echo $tpl->render ('lists/edit', $list);

?>