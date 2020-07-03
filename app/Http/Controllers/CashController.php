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

    /**
     * [$entryStatus 入账类型，1增加，-1减少]
     * @var [type]
     */
    protected $entryType = 1;

    /**
     * [$feeType 手续费计算类型]
     * @var [type]
     */
    protected $feeType;

    /**
     * [$cardType 交易卡类型，借记卡/贷记卡]
     * @var [type]
     */
    protected $cardType;

    /**
     * [$tranCode 交易码]
     * @var [type]
     */
    protected $tranCode;

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
    	if ($this->trade->trancode == '020003' || $this->trade->trancode == 'T20003') {

    		// 查询对应的原交易
    		$originalTrade = \App\Trade::where('transDate', $this->trade->transDate)
    									->where('traceNo', $this->trade->traceNo)
    									->where('merchant_code', $this->trade->merchantId)
    									->where('termId', $this->trade->termId)
    									->first();

    		if (empty($originalTrade)) {

    			return array('status' =>false, 'message' => '无原交易信息');

    		} else {

    			$this->feeType = $originalTrade->fee_type;
    			$this->cardType = $originalTrade->cardType;
    			$this->tranCode = $originalTrade->tranCode;

    		}
    	}

    	/**
    	 * [$this->trade->trancode 交易码]
    	 * @var [撤销类交易]
    	 * 撤销类交易分润计算使用方法：
    	 * 1.根据当前交易订单的 原交易日期、原交易订单号查询原交易
    	 * 2.计算出原交易的应发分润，减少用户余额并记录
    	 */
    	if ($this->trade->trancode == '020002') {
    		
    		$revokeOriginalTrade = \App\Trade::where('transDate', $this->trade->originalTranDate)
    										->where('rrn', $this->trade->originalRrn)
    										->first();
    	}
    }
}
