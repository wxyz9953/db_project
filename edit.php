<?php
require "DB.php";
$number = intval($_GET['id']);
$check = DB::q("SELECT id FROM " . DB::t("student") . " WHERE number=:n", [":n" => $number])->fetch();
if (!$check) {
    echo json_encode("参数错误");
    exit;
}
$name = htmlspecialchars($_POST['name']);
$sex = intval($_POST['sex']);
$enter_age = intval($_POST['enter_age']);
$enter_time = intval($_POST['enter_time']);
$grade = intval($_POST['grade']);
$class = intval($_POST['class']);
$res = DB::update(DB::t("student"), [
    'name' => $name,
    'sex' => $sex,
    'enter_age' => $enter_age,
    'enter_time' => $enter_time,
    'grade' => $grade,
    'class' => $class
], $number);

?>