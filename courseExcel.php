<?php
require "vendor/autoload.php";
require "DB.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function excel($title, $data)
{

    $path = __DIR__ . '/downloads/courses.xlsx';
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

$title = ["课程编号", "课程名称", "任课老师", "学分", "适合年级", "取消年份"];
$res = DB::q("SELECT number,name,teacher,credit,grade,cancel_date FROM " . DB::t("course"))->fetchAll(PDO::FETCH_NUM);
foreach ($res as &$i) {
    $a = ["", "大一", "大二", "大三", "大四"];
    $i[4] = $a[$i[4]];
}
unset($i);
excel($title, $res);
$file = fopen(__DIR__ . '/downloads/courses.xlsx', "r");
header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: " . filesize(__DIR__ . '/downloads/courses.xlsx'));
header("Content-Disposition: attachment; filename=" . 'courses.xlsx');
echo fread($file, filesize(__DIR__ . '/downloads/courses.xlsx'));
fclose($file);
?>