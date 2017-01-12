<?php
/*
	FusionPBX
	Version: MPL 1.1

	The contents of this file are subject to the Mozilla Public License Version
	1.1 (the "License"); you may not use this file except in compliance with
	the License. You may obtain a copy of the License at
	http://www.mozilla.org/MPL/

	Software distributed under the License is distributed on an "AS IS" basis,
	WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
	for the specific language governing rights and limitations under the
	License.

	The Original Code is FusionPBX

	The Initial Developer of the Original Code is
	Mark J Crane <markjcrane@fusionpbx.com>
	Portions created by the Initial Developer are Copyright (C) 2008-2016
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Mark J Crane <markjcrane@fusionpbx.com>
*/

//process this only one time
if ($domains_processed == 1) {

	//define array of settings
		$x = 0;
		$array[$x]['default_setting_uuid'] = 'ce17d7af-650a-49c0-b3e4-3bb8c1dad566';
		$array[$x]['default_setting_category'] = 'ivr_menu';
		$array[$x]['default_setting_subcategory'] = 'option_add_rows';
		$array[$x]['default_setting_name'] = 'numeric';
		$array[$x]['default_setting_value'] = '5';
		$array[$x]['default_setting_enabled'] = 'true';
		$array[$x]['default_setting_description'] = '';
		$x++;
		$array[$x]['default_setting_uuid'] = '74376817-89de-49e1-bddd-868a8ebb49ec';
		$array[$x]['default_setting_category'] = 'ivr_menu';
		$array[$x]['default_setting_subcategory'] = 'option_edit_rows';
		$array[$x]['default_setting_name'] = 'numeric';
		$array[$x]['default_setting_value'] = '1';
		$array[$x]['default_setting_enabled'] = 'true';
		$array[$x]['default_setting_description'] = '';
		$x++;

	//get an array of the default settings
		$sql = "select * from v_default_settings ";
		$prep_statement = $db->prepare($sql);
		$prep_statement->execute();
		$default_settings = $prep_statement->fetchAll(PDO::FETCH_NAMED);
		unset ($prep_statement, $sql);

	//find the missing default settings
		$x = 0;
		foreach ($array as $setting) {
			$found = false;
			$missing[$x] = $setting;
			foreach ($default_settings as $row) {
				if (trim($row['default_setting_subcategory']) == trim($setting['default_setting_subcategory'])) {
					$found = true;
					//remove items from the array that were found
					unset($missing[$x]);
				}
			}
			$x++;
		}
		unset($array);

	//update the array structure
		if (is_array($missing)) {
			$array['default_settings'] = $missing;
			unset($missing);
		}

	//add the default settings
		if (is_array($array)) {
			$database = new database;
			$database->app_name = 'default_settings';
			$database->app_uuid = '2c2453c0-1bea-4475-9f44-4d969650de09';
			$database->save($array);
			$message = $database->message;
			unset($database);
		}

}

?>
