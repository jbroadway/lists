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
	
	public static function embed_lists () {
		$lists = self::query ('id, name')
			->order ('name', 'asc')
			->fetch_orig ();
		
		$out = array ();
		foreach ($lists as $list) {
			$out[] = (object) array ('key' => $list->id, 'value' => $list->name);
		}
		return $out;
	}
	
	public static function by_user ($user) {
		return self::query ('l.id, l.name')
			->from ('#prefix#lists l, #prefix#lists_member m')
			->where ('m.list = l.id')
			->where ('m.user', $user)
			->order ('l.name', 'asc')
			->fetch_orig ();
	}
}

?>