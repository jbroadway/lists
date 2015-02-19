<?php

namespace lists;

/**
 * Member lists
 *
 * Fields:
 * - id
 * - name
 * - description
 */
class Lists extends \Model {
	public $table = '#prefix#lists';
	public $key = 'id';
}

?>