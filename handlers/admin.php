<?php

$this->require_acl ('admin', 'lists');

$page->layout = 'admin';
$page->title = __ ('Member Lists');

// Calculate the offset
$limit = 20;
$num = isset ($this->params[0]) ? $this->params[0] : 1;
$offset = ($num - 1) * $limit;

// Fetch the items and total items
$items = lists\Lists::query ()->fetch ($limit, $offset);
$total = lists\Lists::query ()->count ();

// Check for error, e.g., if table hasn't been created yet
if ($items === false) {
	$items = array ();
	$total = 0;
	printf (
		'<p class="visible-notice"><strong>%s</strong>: %s</p>',
		__ ('Notice'),
		__ ('It looks like you need to import your database schema for this app.')
	);
}

// Pass our data to the view template
echo $tpl->render (
	'lists/admin',
	array (
		'limit' => $limit,
		'total' => $total,
		'items' => $items,
		'count' => count ($items),
		'url' => '/lists/admin/%d'
	)
);

?>