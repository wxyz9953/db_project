<?php
require "vendor/autoload.php";
require "DB.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function excel($title, $data)
{
    //$title [0]=>xxxx
    //       [1]=>xxxx
    //$data  [0]=>[0]xxxx
    //            [1]xxxx
    //            [2]xxxx
    //       [1]=>[0]xxxx
    //            [1]xxxx
    //            [2]xxxx

    $path = __DIR__ . '\downloads\students.xlsx';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getColumnDimension('A')->setWidth(15);
    for ($i = ord('A'); $i < ord('A') + count($title); $i++) {
        $sheet->setCellValue(chr($i) . 1, $title[$i - ord('A')]);
    }
    for ($i = 2; $i < 2 + count($data); $i++) {
        for ($j = ord('A'); $j < ord('A') + count($data[$i - 2]); $j++) {
            $sheet->setCellValue(chr($j) . $i, $data[$i - 2][$j - ord('A')]);
        }
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save($path);
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
}

$title = ["学号", "姓名", "性别", "入学年龄", "入学日期", "年级", "班级"];
$res = DB::q("SELECT number,name,sex,enter_age,enter_time,grade,class FROM " . DB::t("student"))->fetchAll(PDO::FETCH_NUM);
foreach ($res as &$i) {
    $a = ["男", "女"];
    $i[2] = $a[$i[2]];
}
excel($title, $res);
$file = fopen(__DIR__ . '\downloads\students.xlsx', "r");
header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: " . filesize(__DIR__ . '\downloads\students.xlsx'));
header("Content-Disposition: attachment; filename=" . 'students.xlsx');
echo fread($file, filesize(__DIR__ . '\downloads\students.xlsx'));
fclose($file);
?>