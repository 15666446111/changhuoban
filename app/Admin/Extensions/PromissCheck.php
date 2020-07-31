<?php

namespace App\Admin\Extensions;

use Encore\Admin\Facades\Admin;

class PromissCheck
{


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-31
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 判断当前登陆的管理员是否是超级管理员 ]
	 * @return    boolean     [ true or false ]
	 */
	public static function isAdministortar()
	{
		return Admin::user()->operate == 'All' ? true : false;
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-31
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 是否是联盟模式 ]
	 * @return    boolean     [description]
	 */
	public static function isUnion()
	{
		if(Admin::user()->operate == 'All') return false;

		$Setting = \App\AdminSetting::where('operate_number', Admin::user()->operate)->first();

		if(empty($Setting)) return false;

		if($Setting->type == 1 && $Setting->pattern == 1) return true;

		else return false;
	}


	/**
	 * @Author    Pudding
	 * @DateTime  2020-07-31
	 * @copyright [copyright]
	 * @license   [license]
	 * @version   [ 是否是工具模式 ]
	 * @return    boolean     [description]
	 */
	public static function isTool()
	{
		if(Admin::user()->operate == 'All') return false;

		$Setting = \App\AdminSetting::where('operate_number', Admin::user()->operate)->first();

		if(empty($Setting)) return false;

		if($Setting->type == 1 && $Setting->pattern == 2) return true;

		else return false;
	}
}