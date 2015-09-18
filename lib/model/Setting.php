<?php
/**
 * User class
 *
 * @author Christophe Gosiau <christophe@tigron.be>
 * @author Gerry Demaret <gerry@tigron.be>
 * @author David Vandemaele <david@tigron.be>
 */

class Setting {
	use Model, Get, Save, Delete;

	/**
	 * Get by name
	 *
	 * @access public
	 * @param string $name
	 * @return Setting $setting
	 */
	public static function get_by_name($name) {
		$table = self::trait_get_database_table();
		$db = self::trait_get_database();
		$id = $db->getOne('SELECT id FROM ' . $table . ' WHERE name = ?', [ $name ]);
		if ($id === null) {
			throw new Exception('Not found');
		}
		return self::get_by_id($id);
	}

	/**
	 * Get all settings as an array
	 *
	 * @access public
	 * @return array $settings
	 */
	public static function get_as_array() {
		$settings = Setting::get_all();
		$settings_array = array();
		foreach ($settings as $setting) {
			$settings_array[$setting->name] = $setting->value;
		}
		return $settings_array;
	}
}