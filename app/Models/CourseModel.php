<?php

class CourseModel
{
    public function getCourseInfoById($id)
    {
        $res = DB::q("SELECT id, number, name, teacher, credit, grade, cancel_date FROM " . DB::t("course") .
            " WHERE number = :n", [':n' => $id])->fetch();
        return $res;
    }

    public function getCourseInfoByName($name)
    {
        $name = functions::split($name);
        $res = DB::q("SELECT id, number, name, teacher, credit, grade, cancel_date FROM " . DB::t("course") .
            " WHERE name LIKE (\"$name\")")->fetch();
        return $res;
    }


}

?>