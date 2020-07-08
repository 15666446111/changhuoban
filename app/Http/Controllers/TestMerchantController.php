<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Pmpos\PmposController;

class TestMerchantController extends Controller
{
    
    /**
     * 接口推送的商户信息
     * @var [type]
     */
    protected $regContent;


    /**
     * 机具信息
     * @var [type]
     */
    protected $machine;



    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($regContent)
    {
        
        $this->regContent = $regContent;

        $this->machine = \App\Machine::where('sn', $this->regContent->termSn)->first();

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function index()
    {

        /**
         * 检查机器sn是否入库
         * @var [type]
         */
        if ( empty($this->machine) || !$this->machine) {
            $this->regContent->remark = '该机器还未入库';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器sn是否发货
         * @var [type]
         */
        if (empty($this->machine->user_id)) {
            $this->regContent->remark = '该机器还未发货';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘信息是否存在
         * @var [type]
         */
        if (empty($this->machine->operate)) {
            $this->regContent->remark = '未查询到机器归属操盘信息';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器归属操盘方和畅捷后台是否一致
         * @var [type]
         */
        $systemMerchant = \App\AdminSetting::where('operate_number', $this->machine->operate)->value('system_merchant');
        if ($systemMerchant != $this->regContent->config_agent_id) {
            $this->regContent->remark = '该机器归属操盘信息有误';
            $this->regContent->save();
            return false;
        }

        /**
         * 检查机器是否在畅捷一级后台
         * @var [type]
         */
        if ($this->regContent->config_agent_id != $this->regContent->agentId) {
            $this->regContent->remark = '该机器不在您的畅捷一级后台';
            $this->regContent->save();
            return false;
        }

        /**
         * 更新商户和机具绑定状态
         * @var [type]
         */
        try {
            $merchant = \App\Merchant::where('code', $this->regContent->merchantId)->first();

            if (!$merchant || empty($merchant)) {
                
                ## 商户不存在时，添加商户信息
                $merchant = \App\Merchant::create([
                    'user_id'       => $this->machine->user_id,
                    'code'          => $this->regContent->merchantId,
                    'operate'       => $this->machine->operate
                ]);

            }
             // 当前机器未绑定商户时，更新绑定状态
            if ($this->machine->bind_status == 0 || empty($this->machine->merchant_id)) {

                \App\Machine::where('sn', $this->regContent->termSn)->update([
                    'merchant_id'       => $merchant->id,
                    'bind_status'       => 1,
                    'bind_time'			=> date('Y-m-d H:i:s', time())
                ]);
            } else {
                // 判断当前机器绑定商户和推送信息是否一致，信息不一致时，更新商户信息
                if ($this->machine->merchants->code != $this->regContent->merchantId) {

                    // 更新商户信息
                    \App\Machine::where('sn', $this->regContent->termSn)->update([
                        'merchant_id'       => $merchant->id
                    ]);

                    // 更新绑定记录的解绑状态
                    \App\MerchantsBindLog::where('sn', $this->regContent->termSn)
                                        ->where('bind_state', 1)
                                        ->update(['bind_state' => 0]);
                }
            }

            // 添加绑定记录
            \App\MerchantsBindLog::create([
                'merchant_code'     => $this->regContent->merchantId,
                'sn'                => $this->regContent->termSn
            ]);

        } catch (\Exception $e) {
            $this->regContent->remark .= '商户绑定:' . json_encode($e->getMessage());
            $this->regContent->save();
            return false;
        }

        /**
         * 如果机器是按冻结金额激活，并且冻结金额大于0时，发起冻结
         */
        if ($this->machine->policys->active_type == 1 && $this->machine->policys->active_price > 0) {

            try {

                // 短信模板编号
                $simCharge = \App\AdminShort::where('id', $this->machine->policys->short_id)->value('number');

                // 发起冻结
                $pmpos = new PmposController($this->regContent->merchantId, $this->regContent->termSn);

                $data = $pmpos->feeFrozen($simCharge, $this->machine->policys->active_price, 0);

                $returnData = json_decode($data['return_data']);

                // 添加冻结记录
                \App\MerchantsFrozenLog::create([
                    'merchant_code'     => $this->regContent->merchantId,
                    'sn'                => $this->regContent->termSn,
                    'type'              => 1,
                    'frozen_money'      => $this->machine->policys->active_price,
                    'state'             => $returnData->code == '00' ? 1 : 0,
                    'return_data'       => $data['return_data'],
                    'send_data'         => $data['send_data']
                ]);

            } catch (\Exception $e) {

                $this->regContent->remark .= '服务费冻结:' . json_encode($e->getMessage());
                $this->regContent->save();
                return false;

            }
        } else {

        	$this->regContent->remark .= '服务费冻结:active_type' . $this->machine->policys->active_type . 'active_price' . $this->machine->policys->active_price;
            $this->regContent->save();
            return false;

        }
    }
}
