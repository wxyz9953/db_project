<?php
require "vendor/autoload.php";
require "DB.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id = intval($_GET['id']);
$course = DB::q("SELECT name,teacher,credit,grade,cancel_date FROM " . DB::t("course") . " WHERE number=:n", [':n' => $id])->fetch();
$students = DB::q("SELECT s.number,s.name,s.grade,s.class,e.grades FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("student") . " AS s ON e.stu_id=s.number WHERE e.course_id=:n", [':n' => $id])->fetchAll(PDO::FETCH_NUM);
function excel($title, $data, $course)
{

    $path = __DIR__ . '/downloads/' . $course["name"] . '选课信息.xlsx';
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

$title = ["学号", "姓名", "年级", "班级", "分数"];
foreach ($students as &$i) {
    if ($i[4] == -1) {
        $i[4] = "成绩未出";
    }
}
unset($i);
excel($title, $students, $course);
$file = fopen(__DIR__ . '/downloads/' . $course["name"] . '选课信息.xlsx', "r");
header("Content-type: application/octet-stream");
header("Accept-Ranges: bytes");
header("Accept-Length: " . filesize(__DIR__ . '/downloads/' . $course["name"] . '选课信息.xlsx'));
header("Content-Disposition: attachment; filename=" . $course["name"] . '选课信息.xlsx');
echo fread($file, filesize(__DIR__ . '/downloads/' . $course["name"] . '选课信息.xlsx'));
fclose($file);
?>