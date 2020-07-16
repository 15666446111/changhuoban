<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TeamController extends Controller
{	
	/**
	 * @version  [<首页伙伴管理接口>]
	 * @author   Pudding   
	 * @DateTime 2020-04-08T17:17:40+0800
	 * @param    Request
	 * @return   [返回直接下级信息 以及所有下级的人数]
	 */
    public function index(Request $request)
    {
    	try{
            // 获取直接下级信息
            $list = \App\User::where('parent', $request->user->id)
                        ->select(['id', 'avatar', 'nickname','phone', 'created_at'])->orderBy('created_at', 'desc')->get();

            // 获取总下级人数
            $Arr = \App\UserRelation::where('parents', 'like', "%_".$request->user->id."_%")->pluck('id')->toArray();

            return response()->json(['success'=>
                    [
                        'message' => '获取成功!', 
                        'data' => [
                            'list'      =>  $list,
                            'count'     =>  count($list),
                            'AllCount'  =>  count($Arr),
                        ]
                    ]
            ]);

    	} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,请联系客服']]);

        }
    }


    /**
     * [data  APP栏位 团队 页面数据统计信息]
     * @author Pudding
     * @DateTime 2020-04-11T13:57:37+0800
     * @param    Request                  $request [description]
     * @return   [type]                            [description]
     */
    public function data(Request $request)
    {
        /*try{*/

            /**
             * @version [<vector>] [<获得团队日数据 , 日交易数据 >]
             */
            $model      = new StatisticController($request->user, 'day');
            // 日交易数据
            $DayTrade   = number_format(($model->getTradeSum() / 100), 2, ".", "," );
            // 日激活数据
            $DayActive  = $model->getMachineCount();
            // 日商户个数
            $DayMerchant = $model->getNewAddMerchant();
            // 日收益数据
            $DayIncome  = number_format(($model->getCashSum() / 100), 2, ".", "," );
            // 日伙伴个数
            $DayTeam    = $model->getNewAddTeamCount();



            /**
             * @version [<vector>] [<获得团队月数据 , 月交易数据 >]
             */
            $MonthModel = new StatisticController($request->user, 'month');
            // 月交易数据
            $MonthTrade = number_format(($MonthModel->getTradeSum() / 100), 2, ".", "," );
            // 日激活数据
            $MonthActive= $MonthModel->getMachineCount();
            // 日商户个数
            $MonthMerchant = $MonthModel->getNewAddMerchant();
            // 日收益数据
            $MonthIncome= number_format(($MonthModel->getCashSum() / 100), 2, ".", "," );
            // 日伙伴个数
            $MonthTeam  = $MonthModel->getNewAddTeamCount();



            /**
             * @version [<vector>] [<获得团队总数据 , 总交易数据 >]
             */
            $CountModel = new StatisticController($request->user, 'all');
            // 月交易数据
            $CountTrade = number_format(($CountModel->getTradeSum() / 100), 2, ".", "," );
            // 日激活数据
            $CountActive= $CountModel->getMachineCount();
            // 日商户个数
            $CountMerchant = $CountModel->getNewAddMerchant();
            // 日收益数据
            $CountIncome= number_format(($CountModel->getCashSum() / 100), 2, ".", "," );
            // 日伙伴个数
            $CountTeam  = $CountModel->getNewAddTeamCount();


            return response()->json(['success'=>
                    [
                        'message' => '获取成功!', 
                        'data' => [
                            
                            'day'   =>  [
                                'trade'     =>  $DayTrade,
                                'active'    =>  $DayActive,
                                'merchant'  =>  $DayMerchant,
                                'income'    =>  $DayIncome,
                                'team'      =>  $DayTeam,
                            ],

                            'month' =>  [
                                'trade'     =>  $MonthTrade,
                                'active'    =>  $MonthActive,
                                'merchant'  =>  $MonthMerchant,
                                'income'    =>  $MonthIncome,
                                'team'      =>  $MonthTeam
                            ],

                            'all'   =>  [
                                'trade'     =>  $CountTrade,
                                'active'    =>  $CountActive,
                                'merchant'  =>  $CountMerchant,
                                'income'    =>  $CountIncome,
                                'team'      =>  $CountTeam
                            ]
                        ]
                    ]
            ]);


        /*} catch (\Exception $e) {

            return response()->json(['error'=>['message' => '系统错误,联系客服!']]);

        }*/
    }
}
