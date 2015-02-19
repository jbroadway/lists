<?php

$this->require_acl ('admin', 'user', 'lists');

if (! $this->internal) return;

$lists = lists\Lists::by_user ($this->data['user']);

echo $tpl->render ('lists/user', array (
	'lists' => $lists
));
