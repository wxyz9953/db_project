<?php

class CourseController
{
    private $c;
    private $st;

    function __construct()
    {
        $this->c = new CourseModel();
        $this->st = new StudentModel();
    }

    public function getCourseInfo($id)
    {
        $res = $this->c->getCourseInfoById(intval($id));
        Response::json($res);
    }

    public function addCourseInfo()
    {
        $number = intval($_POST['number']);
        $name = htmlspecialchars($_POST['name']);
        $teacher = htmlspecialchars($_POST['teacher']);
        $credit = intval($_POST['gredit']);
        $grade = intval($_POST['grade']);
        $res = DB::insert(DB::t('course'), [
            'number' => $number,
            'name' => $name,
            'teacher' => $teacher,
            'credit' => $credit,
            'grade' => $grade
        ]);
        Response::json($res);
    }

    public function putCourseInfo($id)
    {
        $id = intval($id);
        $number = intval($_POST['number']);
        $name = htmlspecialchars($_POST['name']);
        $teacher = htmlspecialchars($_POST['teacher']);
        $credit = intval($_POST['gredit']);
        $grade = intval($_POST['grade']);
        $date = intval($_POST['date']);
        $res = DB::update(DB::t("course"), [
            'number' => $number,
            'name' => $name,
            'teacher' => $teacher,
            'credit' => $credit,
            'grade' => $grade,
            'cancel_date' => $date
        ], $id);
        Response::json($res);
    }

    public function delCourseInfo($id)
    {
        $id = intval($id);
        DB::q("DELETE FROM " . DB::t("course") . " WHERE id = :id", [':id' => $id]);
    }

    public function addEnroll()
    {
        $stu_id = intval($_POST['stu_id']);
        $course_id = intval($_POST['course_id']);
        self::verify($stu_id, $course_id);
        $t = DB::insert(DB::t('enroll'), [
            'stu_id' => $stu_id,
            'course_id' => $course_id,
            'grade' => -1,
            'date' => date("Y")
        ]);
        Response::json($t);
    }

    public function putEnroll($id)
    {
        $id = intval($id);
        $stu_id = intval($_POST['stu_id']);
        $course_id = intval($_POST['course_id']);
        $grade = intval($_POST['grade']);
        $date = intval($_POST['date']);
        self::verify($stu_id, $course_id);
        $r = DB::update(DB::t("enroll"), [
            'stu_id' => $stu_id,
            'course_id' => $course_id,
            'grades' => $grade,
            'date' => $date
        ], $id);
        Response::json($r);
    }

    public function delEnroll($id)
    {
        $id = intval($id);
        DB::q("DELETE FROM " . DB::t("enroll") . " WHERE id = :id", [':id' => $id]);
    }

    public function search()
    {
        $data = $_GET['data'];
        if (is_numeric($data)) {
            $res = $this->c->getCourseInfoById($data);
        } else if (is_string($data)) {
            $res = $this->c->getCourseInfoByName($data);
        }
        Response::json($res);
    }

    public function dsearch()
    {
        $stu = $_GET['stu'];
        $course = $_GET['course'];
        //获得学生编号
        if (!is_numeric($stu)) {
            $stu = functions::split($stu);
            $stu = DB::q("SELECT number FROM " . DB::t("student") . " WHERE name LIKE (\"$stu\")")->fetchAll(PDO::FETCH_NUM);
        }
        //获得课程编号
        if (!is_numeric($course)) {
            $course = functions::split($course);
            $course = DB::q("SELECT number FROM " . DB::t("course") . " WHERE name LIKE (\"$course\")")->fetchAll(PDO::FETCH_NUM);
        }
        $stu = is_array($stu) ? $stu : [$stu];
        $course = is_array($course) ? $course : [$course];

        $stu_str = "(";
        foreach ($stu as $v) {
            $stu_str .= $v . ",";
        }
        $stu_str = rtrim($stu_str, ",") . ")";

        $course_str = "(";
        foreach ($course as $v) {
            $course_str .= $v . ",";
        }
        $course_str = rtrim($course_str, ",") . ")";

        $temp = DB::q("SELECT stu_id AS stu, course_id AS course, grades FROM " . DB::t("enroll") . " WHERE course_id IN $course_str AND stu_id IN $stu_str")->fetchAll();

        foreach ($temp as &$item) {
            $item['stu'] = $this->st->getInfoById($item['stu']);
            $item['course'] = $this->c->getCourseInfoById($item['course']);
        }
        unset($item);
        Response::json($temp);
    }


    private static function verify($stu_id, $course_id)
    {
        $res = DB::q("SELECT grade,cancel_date FROM " . DB::t('course') . " WHERE number = :c", [':c' => $course_id])->fetch();
        $stu = DB::q("SELECT grade FROM " . DB::t('student') . " WHERE number = :n", [':n' => $stu_id])->fetch();
        $grade = $res['grade'];
        $stuGrade = $stu['grade'];
        $cancel_date = $res['cancel_date'];
        $now = date("Y");
        if ($cancel_date < $now) {
            Response::json("该课程已被取消");
        }
        if ($stuGrade < $grade) {
            Response::json("该课程适合更高年级");
        }
    }

}

?>