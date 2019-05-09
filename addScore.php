<?php
require "DB.php";
$id = intval($_GET['id']);
$score = intval($_GET['score']);
$sid = intval($_GET['sid']);
$check = DB::q("SELECT id FROM " . DB::t("enroll") . " WHERE stu_id=:s AND course_id=:c", [':s' => $sid, ':c' => $id])->fetch();
if (!$check || $score > 100) {
    echo json_encode("参数错误");
    exit;
}
DB::q("UPDATE " . DB::t("enroll") . " SET grades=:s WHERE stu_id = :i AND course_id=:c", [':s' => $score, ':i' => $sid, ':c' => $id]);
?>