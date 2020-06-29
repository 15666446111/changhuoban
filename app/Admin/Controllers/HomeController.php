<?php

namespace App\Admin\Controllers;

use DB;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content->title('欢迎回家👏')->description('信息基础统计...')

                ->row(function (Row $row) {
                    $row->column(8, function (Column $column) {
                    $UserBox = new Box('代理增长统计', $this->usersGrowth()); 
                    $UserBox->removable();
                    $UserBox->collapsable();
                    $UserBox->style('info');
                    $UserBox->solid();
                    $UserBox->scrollable();
                    $column->append($UserBox);
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

            });
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-06-24
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 用户同期增长比 ]
     * @return    [type]      [description]
     */
    public function usersGrowth()
    {   
        // 获取当前时间
        $now = Carbon::now();

        // 获取当前天
        $day = $now->day;

        //
        $range = Carbon::now()->subDays( $day -1 )->toDateString();

        // 构建查询构造器
        //$user = \App\User::where()->
        $stats = \App\User::where('created_at', '>=', $range)->groupBy('date')->orderBy('date', 'DESC')
            //->remember(1440)
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ])
            ->toJSON();
        return view('admin.usersGrowth', compact('day'));
    }
}
