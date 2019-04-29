<?php

class GradeController
{
    private $c;

    function __construct()
    {
        $this->c = new CourseModel();
    }

    public function getAvg()
    {
        $type = $_GET['type'];
        $data = intval($_GET['data']);
        if ($type === "student") {
            $res = DB::q("SELECT AVG(grades) AS avg FROM " . DB::t("enroll") . " WHERE grades > -1 AND stu_id = :i", [":i" => $data]);
        }
        if ($type === "course") {
            $res = DB::q("SELECT AVG(grades) AS avg FROM " . DB::t("enroll") . " WHERE grades > -1 AND course_id = :i", [":i" => $data]);
        }
        if ($type === "class") {
            //某班各科平均成绩
            $grade = substr($data, 0, 4);
            $class = substr($data, 4, 2);
            $class = substr($class, 0, 1) == 0 ? substr($class, 1, 2) : $class;
            $stu = DB::q("SELECT number FROM " . DB::t("student") . " WHERE enter_age = :e AND class = :c", [":e" => $grade, ":c" => $class])->fetchAll(PDO::FETCH_NUM);
            $str = "(";
            foreach ($stu as $v) {
                $str .= $v . ",";
            }
            $str = rtrim($str, ",") . ")";
            $res = DB::q("SELECT course_id AS course, avg(grades) AS avg FROM " . DB::t("enroll") . " WHERE grades > -1 AND stu_id IN $str GROUP BY course_id")->fetchAll();
            foreach ($res as &$item) {
                $item["course"] = $this->c->getCourseInfoById($item['course']);
            }
            unset($item);
        }

        Response::json($res);
    }

    public function getdis()
    {

        $course = intval($_GET['course']);
        $res = [];
        $res["不及格"] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades >-1 AND grades < 60", [':c' => $course])->fetch()['COUNT(*)'];
        $res['60-69'] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades >=60 AND grades < 70", [':c' => $course])->fetch()['COUNT(*)'];
        $res["70-79"] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades >=70 AND grades < 80", [':c' => $course])->fetch()['COUNT(*)'];
        $res["80-89"] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades >=80 AND grades < 90", [':c' => $course])->fetch()['COUNT(*)'];
        $res["90-99"] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades >=90 AND grades < 100", [':c' => $course])->fetch()['COUNT(*)'];
        $res["100"] = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE course_id = :c AND grades =100", [':c' => $course])->fetch()['COUNT(*)'];
        Response::json($res);
    }
}

?>