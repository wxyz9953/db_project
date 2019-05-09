<?php
require "DB.php";
$sid = intval($_GET['sid']);
$number = intval($_GET['id']);
$check = DB::q("SELECT id FROM " . DB::t("enroll") . " WHERE stu_id = :s AND course_id=:c", [':s' => $sid, ':c' => $number])->fetchAll();
if ($check) {
    echo json_encode("不能重复选课");
    exit;
}
DB::insert(DB::t("enroll"),
    ['stu_id' => $sid,
        'course_id' => $number,
        'grades' => -1,
        'date' => date("Y")
    ]);

?>