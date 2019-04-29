<?php

class StudentModel
{
    public function getInfoById($id)
    {
        $res = DB::q("SELECT id, number, name, sex, enter_age, grade, class FROM "
            . DB::t("student") . " WHERE number = :id", [':id' => $id])->fetch();
        return $res;
    }

    public function getInfoByName($name)
    {
        $name = functions::split($name);
        $res = DB::q("SELECT id, number, name, sex, enter_age, grade, class FROM "
            . DB::t("student") . " WHERE name LIKE ( \"$name\" )")->fetch();
        return $res;
    }


    public function getCourseById($id)
    {
        $res = DB::q("SELECT c.id, c.number, c.name, c.teacher, c.credit, c.cancel_date FROM "
            . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") .
            " AS c ON e.course_id = c.number WHERE e.stu_id = :number", [':number' => $id])->fetchAll();
        return $res;
    }

    public function getCourseByIdWithGrade($id)
    {
        $res = DB::q("SELECT c.id, c.number, c.name, c.teacher, c.credit, c.cancel_date, e.grades FROM "
            . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") .
            " AS c ON e.course_id = c.number WHERE e.stu_id = :number", [':number' => $id])->fetchAll();
        return $res;
    }


}