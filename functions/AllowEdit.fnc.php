<?php

function AllowEdit($modname=false)
{	global $_ROSARIO;

	if(User('PROFILE')=='admin')
	{
		if(!$modname && isset($_ROSARIO['allow_edit']))
			return $_ROSARIO['allow_edit'];

		if(!$modname)
			$modname = $_REQUEST['modname'];

		if(($modname=='Students/Student.php' || $modname=='Users/User.php') && $_REQUEST['category_id'])
			$modname = $modname.'&category_id='.$_REQUEST['category_id'];

		if(empty($_ROSARIO['AllowEdit']))
		{
			if(User('PROFILE_ID'))
				$_ROSARIO['AllowEdit'] = DBGet(DBQuery("SELECT MODNAME FROM PROFILE_EXCEPTIONS WHERE PROFILE_ID='".User('PROFILE_ID')."' AND CAN_EDIT='Y'"),array(),array('MODNAME'));
			else
				$_ROSARIO['AllowEdit'] = DBGet(DBQuery("SELECT MODNAME FROM STAFF_EXCEPTIONS WHERE USER_ID='".User('STAFF_ID')."' AND CAN_EDIT='Y'"),array(),array('MODNAME'));
		}

		if(!$_ROSARIO['AllowEdit'])
			$_ROSARIO['AllowEdit'] = array(true);

		if(!empty($_ROSARIO['AllowEdit'][$modname]))
			return true;
		else
			return false;
	}
	else
		return $_ROSARIO['allow_edit'];
}

function AllowUse($modname=false)
{	global $_ROSARIO;

	if(!$modname)
		$modname = $_REQUEST['modname'];

	if(($modname=='Students/Student.php' || $modname=='Users/User.php') && isset($_REQUEST['category_id']))
		$modname = $modname.'&category_id='.$_REQUEST['category_id'];

	if(!isset($_ROSARIO['AllowUse']))
	{
		if(User('PROFILE_ID')!='')
			$_ROSARIO['AllowUse'] = DBGet(DBQuery("SELECT MODNAME FROM PROFILE_EXCEPTIONS WHERE PROFILE_ID='".User('PROFILE_ID')."' AND CAN_USE='Y'"),array(),array('MODNAME'));
		else
			$_ROSARIO['AllowUse'] = DBGet(DBQuery("SELECT MODNAME FROM STAFF_EXCEPTIONS WHERE USER_ID='".User('STAFF_ID')."' AND CAN_USE='Y'"),array(),array('MODNAME'));
	}

	if(!$_ROSARIO['AllowUse'])
		$_ROSARIO['AllowUse'] = array(true);

	if(count($_ROSARIO['AllowUse'][$modname]))
		return true;
	else
		return false;
}
?>