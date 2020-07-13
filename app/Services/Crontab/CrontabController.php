<?php
namespace App\Services\Crontab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Pmpos\PmposController;

/**
 * 
 */
class CrontabController extends Controller
{
	
	public function froMachineActive()
	{
		// 查询已开通、未激活、按冻结状态激活的机器列表
		$machineList = \App\Machine::where('open_state', 1)
									->where('active_state', 0)
									->where('policy_id', '>', 0)
									->where('policys.active_type', 1)
									->select();

		foreach ($machineList as $k => $v) {
			$pmpos = new PmposController($v->sn, $v->merchants->code);
			// $
		}
	}
}