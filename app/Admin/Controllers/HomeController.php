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
                    $UserBox1 = new Box('机具类型统计', $this->typeOfJJ()); 
                    $UserBox1->removable();
                    $UserBox1->collapsable();
                    $UserBox1->style('info');
                    $UserBox1->solid();
                    $UserBox1->scrollable();
                    $column->append($UserBox1);
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

        // 当前月的第一天
        $range = Carbon::now()->subDays( $day - 1 )->toDateString();
        
        // 获取当前月
        $month = Carbon::now()->month;

        // 构建查询构造器
        $currentData = \App\User::where('created_at', '>=', $range)->groupBy('date')->orderBy('date', 'DESC')->get([ 
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ]);

        $arrs = array();

        $arrs['month'] = $month;

        // 循环这个月从1号到现在的数据    
        for($d=1; $d<= $day; $d++){

            $currentDate = $currentData;


            $arrs['current'][] = array('day' => $d, 'count' => 0); 
        }

        return view('admin.usersGrowth', compact('day', 'month', 'arrs'));
    }


    /**
     * @Author    Pudding
     * @DateTime  2020-07-13
     * @copyright [copyright]
     * @license   [license]
     * @version   [机具类型统计]
     * @return    [type]      [description]
     */
    public function typeOfJJ()
    {
        return view('admin.typeOfJJ');
    }
}
