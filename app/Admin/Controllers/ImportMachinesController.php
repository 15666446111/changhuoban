<?php
namespace App\Admin\Controllers;

use App\Admin\Forms\ImportMachines;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;


class ImportMachinesController extends Controller
{
    public function index(Content $content)
    {

        $forms = [
            'basic'    => Settings\Basic::class,
            'site'     => Settings\Site::class,
            'upload'   => Settings\Upload::class,
            'database' => Settings\Database::class,
            'develop'  => Settings\Develop::class,
        ];

        return $content->title('导入终端')->body(/*Tab::forms($forms)*/ new ImportMachines());
    }
}