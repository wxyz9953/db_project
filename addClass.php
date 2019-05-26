<?php
require "DB.php";
$number = intval($_POST['number']);
$name = $_POST['name'];
$teacher = $_POST['teacher'];
$credit = intval($_POST['credit']);
$grade = intval($_POST['grade']);
@$cancel_date = intval($_POST['cancel_date']);
$res = DB::q("SELECT id FROM " . DB::t("course") . " WHERE number=:n", [':n' => $number])->fetch();
if (strlen($number) != 7 || $res || $credit <= 0 || $grade <= 0 || $grade > 4) {
    echo json_encode("参数错误");
    exit;
}

DB::insert(DB::t("course"), [
    'number' => $number,
    'name' => $name,
    'teacher' => $teacher,
    'credit' => $credit,
    'grade' => $grade,
    'cancel_date' => $cancel_date
]);

?>