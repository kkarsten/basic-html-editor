<?php
	class Website extends \Spot\Entity {
		protected static $table = 'websites';
		public static function fields() {
			return [
            'id'          => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'name'        => ['type' => 'string', 'required' => true],
            'url'         => ['type' => 'string', 'required' => false]
        ];
		}
	}
?>