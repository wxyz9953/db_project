<?php
require "DB.php";
$number = intval($_GET['id']);
$check = DB::q("SELECT id FROM " . DB::t("course") . " WHERE number=:n", [":n" => $number])->fetch();
if (!$check) {
    echo json_encode("参数错误");
    exit;
}
$name = htmlspecialchars($_POST['name']);
$teacher = htmlspecialchars($_POST['teacher']);
$credit = intval($_POST['credit']);
$grade = intval($_POST['grade']);
$cancel_date = $_POST['cancel_date'];
$res = DB::update(DB::t("course"), [
    'name' => $name,
    'teacher' => $teacher,
    'credit' => $credit,
    'grade' => $grade,
    'cancel_date' => $cancel_date
], $number);
?>