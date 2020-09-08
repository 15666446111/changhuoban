<?php

namespace App\Admin\Actions\Export;

use App\Model1\MoneyLog;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Encore\Admin\Grid\Exporters\AbstractExporter;


use Xls\Writer\Workbook;


class Export1MoneyLog extends AbstractExporter
{

    protected $head = [];
    
    protected $body = [];

    public function setAttr($head, $body)
    {
        $this->head = $head;

        $this->body = $body;
    }

    /**
     * @Author    Pudding
     * @DateTime  2020-08-27
     * @copyright [copyright]
     * @license   [license]
     * @version   [ 导出 ]
     * @param     Request     $request [description]
     * @return    [type]               [description]
     */
    public function export()
    {

        $workbook = new Workbook(storage_path('app/public/download/money.csv'));

        $worksheet = $workbook->addWorksheet('sheet1');

        $head = $this->head;
        
        $h = 0;

        foreach ($head as $key => $value) {
            $worksheet->write(0, $h, $value);
            $h ++;
        }

        $body = $this->body;

        $i = 1;

        $query = $this->getQuery();

        $list = $query->chunk(10000, function($list) use ($worksheet, &$i){

            foreach ($list as $key => $value) {

                $worksheet->write($i, 0, $value->id);
                $worksheet->write($i, 1, $value->sn);

                $i++;
            }

        });

        $workbook->close();

        dd("下载完成");
        
        header("Content-type:application/vnd.ms-excel");  //设置内容类型
        header("Content-Disposition:attachment;filename=".storage_path('app/public/download/money.csv'));  //文件下载
    }
}