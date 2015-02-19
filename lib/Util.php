<?php

namespace lists;

class Util {
	public static function yes_no () {
		return array (
			(object) array ('key' => 'no', 'value' => __ ('No')),
			(object) array ('key' => 'yes', 'value' => __ ('Yes')),
		);
	}
}
