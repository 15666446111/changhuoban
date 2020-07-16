<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter; 

class MoneyLogExporter extends ExcelExporter
{
    protected $fileName = '分润信息.xlsx';

    protected $columns = [
        'id'      => 'ID',
    ];

    // 执行这个方法
    public function export()
    {
        dd($this->applyFilter(false));
    }
}