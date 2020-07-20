<?php

namespace App\Observers;

use App\Withdraw;
use App\Services\Cj\RepayCjController;

class WithdrawObserver
{
    /**
     * @Author    Pudding
     * @DateTime  2020-07-18
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 提现observer]
     * @param     Withdraw    $withdraw [description]
     * @return    [type]                [description]
     */
    public function created(Withdraw $withdraw)
    {
    	// 如果提现类型的方式为自动审核。免审核
    	if($withdraw->pay_type == "2"){

    		$application = new RepayCjController($withdraw);

    		$result 	 = $application->auto_apply();

    		$withdraw->api_return_data = $withdraw->api_return_data."---".json_encode($result);

    		$withdraw->save();

    	}
    }
}
