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
	
	public static function duplicate ($id, $new_id) {
		\DB::beginTransaction ();

		$members = self::query ()->where ('list', $id)->fetch_orig ();

		foreach ($members as $member) {
			$m = new Member (array (
				'list' => $new_id,
				'user' => $member->user,
				'notes' => $member->notes
			));
			
			if (! $m->put ()) {
				\DB::rollback ();
				return false;
			}
		}
		
		\DB::commit ();
		
		return true;
	}
}

?>