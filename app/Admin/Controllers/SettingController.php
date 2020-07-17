<?php
namespace App\Admin\Controllers;

use App\Admin\Forms\Settings\Withdraw;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;


class SettingController extends Controller
{
    public function index(Content $content)
    {

        $forms = [
            'withdraw'      => Withdraw::class,
/*             'site'          => Settings\Site::class,
            'upload'        => Settings\Upload::class,
            'database' => Settings\Database::class,
            'develop'  => Settings\Develop::class,*/
        ];

        return $content->title('操盘方系统设置')->body(Tab::forms($forms));
    }
}