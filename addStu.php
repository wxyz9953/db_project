<?php
require "DB.php";
$number = intval($_POST['number']);
$res = DB::q("SELECT id FROM " . DB::t("student") . " WHERE number=:n", [':n' => $number])->fetch();
if (strlen($number) != 10 || $res) {
    echo json_encode("参数错误");
    exit;
}
$name = htmlspecialchars($_POST['name']);
$sex = intval($_POST['sex']);
if ($sex != 0 && $sex != 1) {
    echo json_encode("参数错误");
    exit;
}
$enter_age = intval($_POST['enter_age']);
if ($enter_age < 10 || $enter_age > 50) {
    echo json_encode("参数错误");
    exit;
}
$enter_time = intval($_POST['enter_time']);
$grade = intval($_POST['grade']);
$class = intval($_POST['class']);
$id = DB::insert(DB::t("student"), [
    'number' => $number,
    'name' => $name,
    'sex' => $sex,
    'enter_age' => $enter_age,
    'enter_time' => $enter_time,
    'grade' => $grade,
    'class' => $class
]);

?>
