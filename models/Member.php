<?php

namespace lists;

/**
 * List members.
 *
 * Fields:
 * - id
 * - list
 * - user
 * - notes
 */
class Member extends \Model {
	public $table = '#prefix#lists_member';
	public $key = 'id';
	
	public static function delete_list ($id) {
		return \DB::execute ('delete from #prefix#lists_member where list = ?', $id);
	}
}

?>