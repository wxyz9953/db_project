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
if ($class == 0 || $grade > 4 || $grade <= 0) {
    echo json_encode("参数错误");
    exit;
}
$id = DB::q("SELECT id FROM " . DB::t("student") . " WHERE number=:n", [':n' => $number])->fetch()['id'];
$res = DB::update(DB::t("student"), [
    'name' => $name,
    'sex' => $sex,
    'enter_age' => $enter_age,
    'enter_time' => $enter_time,
    'grade' => $grade,
    'class' => $class
], $id);

?>