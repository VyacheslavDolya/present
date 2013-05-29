<?php
class JUserWP extends JUser{
  
	public static function getInstance($identifier = 0){
		$user = new JUserWP();
    $wpuser = wp_get_current_user();
    $data = $wpuser->data;
    $user->id = $data->ID;
    $user->name = $data->display_name;
    $user->username = $data->user_nicename;
    $user->_authLevels = array(1);
    $user->_authGroups = array(1);
		return $user;
	}
}
?>