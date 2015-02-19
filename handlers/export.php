<?php

$this->require_acl ('admin', 'lists');

$list = new lists\Lists ($_GET['id']);

$page->layout = false;
header ('Cache-control: private');
header ('Content-Type: text/plain');
header ('Content-Disposition: attachment; filename=' . strtolower (URLify::filter ($list->name)) . '.csv');

$members = lists\Member::query ('m.notes, u.name, u.email')
	->from ('#prefix#lists_member m, #prefix#user u')
	->where ('m.user = u.id')
	->where ('m.list', $_GET['id'])
	->order ('u.name', 'asc')
	->fetch_orig ();

echo "Name,Email,Notes\n";

foreach ($members as $member) {
	$name = str_replace ('"', '""', $member->name);
	if (strpos ($name, ',') !== false) {
		$name = '"' . $name . '"';
	}
	$name = str_replace (array ("\n", "\r"), array ('\\n', '\\r'), $name);
	echo $name . ',';
	$email = str_replace ('"', '""', $member->email);
	if (strpos ($email, ',') !== false) {
		$email = '"' . $email . '"';
	}
	$email = str_replace (array ("\n", "\r"), array ('\\n', '\\r'), $email);
	echo $email . ',';
	$notes = str_replace ('"', '""', $member->notes);
	if (strpos ($notes, ',') !== false) {
		$notes = '"' . $notes . '"';
	}
	$notes = str_replace (array ("\n", "\r"), array ('\\n', '\\r'), $notes);
	echo $notes . "\n";
}

?>