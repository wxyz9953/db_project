<?php

class StudentController
{
    private $st;

    function __construct()
    {
        $this->st = new StudentModel();
    }

//    public function home()
//    {
//        $res = $this->st->getInfoById("3018218135");
//        Response::json($res);
//    }


    public function getList()
    {
        $res = DB::q("SELECT number, name, sex,enter_age,enter_time,grade,class FROM "
            . DB::t("student"))->fetchAll();
        Response::json($res);
    }

    public function getStuInfo($id)
    {
        $res = $this->st->getInfoById($id);
        $arr = ["a", "大一", "大二", "大三", "大四"];
        $res["sex"] = 1 ? "女" : "男";
        $res["grade"] = $arr[$res["grade"]];
        $res["class"] = $res["class"] . "班";
        $res["enter_age"] = $res["enter_age"] . "岁";
        $courseRes = $this->st->getCourseByIdWithGrade($id);
        Response::json([
            "stu_info" => $res,
            "course_info" => $courseRes
        ]);
    }

    public function addStuInfo()
    {
        $number = intval($_POST['number']);
        $name = htmlspecialchars($_POST['name']);
        $sex = intval($_POST['sex']);
        $enter_age = intval($_POST['enter_age']);
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
        Response::json($id);
    }

    public function putStuInfo($id)
    {
        $id = intval($id);
        $number = intval($_POST['number']);
        $name = htmlspecialchars($_POST['name']);
        $sex = intval($_POST['sex']);
        $enter_age = intval($_POST['enter_age']);
        $enter_time = intval($_POST['enter_time']);
        $grade = intval($_POST['grade']);
        $class = intval($_POST['class']);
        $res = DB::update(DB::t("student"), [
            'number' => $number,
            'name' => $name,
            'sex' => $sex,
            'enter_age' => $enter_age,
            'enter_time' => $enter_time,
            'grade' => $grade,
            'class' => $class
        ], $id);
        Response::json($res);
    }

    public function delStuInfo($id)
    {
        $id = intval($id);
        DB::q("DELETE FROM " . DB::t("student") . " WHERE id = :id", [':id' => $id]);
    }

    public function search()
    {
        $data = $_GET['data'];
        if (is_numeric($data)) {
            $res = $this->st->getInfoById($data);
        } else if (is_string($data)) {
            $res = $this->st->getInfoByName($data);
        }
        Response::json($res);
    }


}

?>