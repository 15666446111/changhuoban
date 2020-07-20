<?php
namespace App\Admin\Controllers;

use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;
use App\Admin\Forms\Settings\Base;
use App\Http\Controllers\Controller;
use App\Admin\Forms\Settings\Withdraw;


class SettingController extends Controller
{
    public function index(Content $content)
    {

        $forms = [
            'base'          => Base::class,
            'withdraw'      => Withdraw::class,
            
 /*         'upload'        => Settings\Upload::class,
            'database' => Settings\Database::class,
            'develop'  => Settings\Develop::class,*/
        ];

        return $content->title('操盘方系统设置')->body(Tab::forms($forms));
    }
}