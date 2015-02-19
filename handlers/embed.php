<?php

if (! $this->internal) return;

$members = lists\Member::query ('m.notes, u.name, u.email')
	->from ('#prefix#lists_member m, #prefix#user u')
	->where ('m.user = u.id')
	->where ('m.list', $this->data['list'])
	->fetch_orig ();

echo $tpl->render ('lists/embed', array (
	'members' => $members,
	'emails' => ($this->data['emails'] === 'yes') ? true : false
));
