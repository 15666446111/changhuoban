<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashController extends Controller
{

	/**
     * [$trade 该笔交易订单信息]
     * @var [type]
     */
    protected $trade;

    public function __construct(Trade $trade)
    {
    	$this->trade = $trade;
    }

    public function cash()
    {
    	/**
    	 * [$this->trade->trancode 交易码]
    	 * @var [冲正类交易]
    	 * 冲正类交易分润计算使用方法：
    	 * 1.根据当前交易订单的 交易日期、凭证号、商户号、终端号查询原交易
    	 * 2.计算出原交易的应发分润，减少用户余额并记录
    	 */
    	if ($this->trade->trancode == '020003' || $this->trade->trancode == 'T20003' ) {

    		$desc = substr($this->trade->sysRespDesc, 0, 18);
    		if ($desc == '原交易已冲正') {
    			return array('status' =>false, 'message' => '该交易为无效交易');
    		}

    		$originalTrade = \App\Trade::where('transDate', $this->trade->transDate)
    									->where('traceNo', $this->trade->traceNo)
    									->where('merchant_code', $this->trade->merchantId)
    									->where('termId', $this->trade->termId)
    									->first();
    		// 
    		if (empty($originalTrade)) {

    			return array('status' =>false, 'message' => '无原交易信息');
    			
    		} else {

    		}
    	}
    	// 2.判断是否为撤销类交易
    }
}
