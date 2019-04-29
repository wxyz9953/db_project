<?php

use NoahBuscher\Macaw\Macaw;

//Macaw::get('/', "StudentController@home");


Macaw::get("student/search", "StudentController@search");//查询 query=查询参数(姓名或学号)
//只返回基本信息，点进去之后根据学号去请求student/(:num)
Macaw::get("student/(:num)", "StudentController@getStuInfo");//根据学号获得学生信息及其所选课程情况（包括成绩）
Macaw::post("student", "StudentController@addStuInfo");//增加学生信息
Macaw::put("student/(:num)", "StudentController@putStuInfo");//修改学生信息,学号可以修改
Macaw::delete("student/(:num)", "StudentController@delStuInfo");//根据学号删除学生信息

Macaw::get("course/grade", "CourseController@dsearch");//接受两个参数1、学生（编号或姓名）2、课程(名称或编号)
//返回成绩
Macaw::get("course/search", "CourseController@search");//查询 查询参数（课程或编号）
//只返回基本信息，点进去之后可以查看选课情况
Macaw::get("course/(:num)", "CourseController@getCourseInfo");//查看课程信息及其选课情况
Macaw::post("course", "CourseController@addCourseInfo");//新建课程
Macaw::put("course/(:num)", "CourseController@putCourseInfo");//修改课程,课程号可以修改
Macaw::delete("course/(:num)", "CourseController@delCourseInfo");//删除课程

Macaw::post("enroll", "CourseController@addEnroll");//增加选课信息
Macaw::put("enroll/(:num)", "CourseController@putEnroll");//修改选课信息
Macaw::delete("enroll/(:num)", "CourseController@delEnroll");//删除选课信息

Macaw::get("average", "gradeController@getAvg");//传参数 例type=class&data=1
Macaw::get("distribution", "gradeController@getdis");//传参数 course=??   class=201705


Macaw::dispatch();
?>