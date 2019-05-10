<?php
require "vendor/autoload.php";
require "DB.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id = intval($_GET['id']);

function excel($title, $data)
{
    $id = intval($_GET['id']);
    $name = DB::q("SELECT name FROM " . DB::t("student") . " WHERE number=:n", [':n' => $id])->fetch()['name'];
    $path = __DIR__ . "/downloads/$id-$name" . "成绩表" . ".xlsx";
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

$title = ["课程编号", "学分", "分数", "课程名称"];
$res = DB::q("SELECT course_id, credit,grades, name FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") . " AS c ON e.course_id = c.number WHERE e.stu_id=:s", [":s" => $_GET['id']])->fetchAll(PDO::FETCH_NUM);

foreach ($res as &$i) {
    if ($i[2] == -1) {
        $i[2] = "成绩未出";
    }
}

unset($i);
excel($title, $res);
$name = DB::q("SELECT name FROM " . DB::t("student") . " WHERE number=:n", [':n' => $id])->fetch()['name'];
$file = fopen(__DIR__ . "/downloads/$id-$name" . "成绩表.xlsx", "r");
header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: " . filesize(__DIR__ . "/downloads/$id-$name" . "成绩表.xlsx"));
header("Content-Disposition: attachment; filename=" . "$id-$name" . "成绩表.xlsx");
echo fread($file, filesize(__DIR__ . "/downloads/$id-$name" . "成绩表.xlsx"));
fclose($file);
?>