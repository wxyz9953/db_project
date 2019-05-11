<?php
require "DB.php";
$id = intval($_GET['id']);
$type = $_GET['type'];
if ($type == "stu") {
    $stuInfo = DB::q("SELECT number, name, grade, class FROM " . DB::t("student") . " WHERE number = :i", [":i" => $id])->fetch();
//大于 小于等于
    $count = DB::q("SELECT count(case when grades=100 then 1 end),
                            count(case when grades between 89 and 99 then 1 end),
                            count(case when grades between 79 and 89 then 1 end),
                            count(case when grades between 69 and 79 then 1 end),
                            count(case when grades between 59 and 69 then 1 end),
                            count(case when grades between 0 and 59 then 1 end) 
                            FROM enroll WHERE stu_id = :id", [':id' => $id])
        ->fetch(PDO::FETCH_NUM);
    $count = array_reverse($count);
    $weight = DB::q("SELECT e.grades, c.grade FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") . " AS c ON e.course_id = c.number WHERE e.stu_id=:i AND e.grades >-1", [':i' => $id])->fetchAll();
    $wscore = 0;
    $we = 0;
    foreach ($weight as $w) {
        $wscore += $w["grades"] * $w['grade'];
        $we += $w['grade'];
    }
    if ($we) {
        $wscore /= $we;
    } else {
        $wscore = 0;
    }

    $avg = DB::q("SELECT AVG(grades) AS avg FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['avg'];
    $max = DB::q("SELECT MAX(grades) AS max FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['max'];
    $min = DB::q("SELECT MIN(grades) AS min FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['min'];
} else if ($type == "course") {
    $courseInfo = DB::q("SELECT name,teacher,credit,grade,cancel_date FROM " . DB::t("course") . " WHERE number=:i", [':i' => $id])->fetch();
    $count = DB::q("SELECT count(case when grades=100 then 1 end),
                            count(case when grades between 89 and 99 then 1 end),
                            count(case when grades between 79 and 89 then 1 end),
                            count(case when grades between 69 and 79 then 1 end),
                            count(case when grades between 59 and 69 then 1 end),
                            count(case when grades between 0 and 59 then 1 end) 
                            FROM enroll WHERE course_id = :id", [':id' => $id])
        ->fetch(PDO::FETCH_NUM);
    $count = array_reverse($count);
    $res = DB::q("SELECT AVG(grades) as a FROM " . DB::t("enroll") . " WHERE course_id=:c AND grades > -1", [':c' => $id])->fetch();
    $avg = $res["a"];
    $res = DB::q("SELECT COUNT(*) as a FROM " . DB::t("enroll") . " WHERE course_id=:c AND grades = -1", [':c' => $id])->fetch();
    $num = $res["a"];
    $max = DB::q("SELECT MAX(grades) AS max FROM " . DB::t("enroll") . " WHERE course_id=:s AND grades>-1", [':s' => $id])->fetch()['max'];
    $min = DB::q("SELECT MIN(grades) AS min FROM " . DB::t("enroll") . " WHERE course_id=:s AND grades>-1", [':s' => $id])->fetch()['min'];
} else {
    require "404.html";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<?php require "head.php" ?>


<body class="">
<!--<![endif]-->


<?php require "bar.php" ?>
<div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-user"></i>学生</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="index.php">主页</a></li>
        <li><a href="users.php?page=1">学生列表</a></li>
        <li><a href="addUser.php">信息录入</a></li>
        <!--        <li><a href="quick.php">成绩快速录入</a></li>-->

    </ul>


    <a href="#dashboard-menu1" class="nav-header" data-toggle="collapse"><i class="icon-table"></i>课程</a>
    <ul id="dashboard-menu1" class="nav nav-list collapse in">
        <li><a href="courses.php?page=1">课程列表</a></li>
        <li><a href="newCourse.php">信息录入</a></li>
    </ul>

    <a href="#dashboard-menu3" class="nav-header" data-toggle="collapse"><i class="icon-group"></i>班级</a>
    <ul id="dashboard-menu3" class="nav nav-list collapse in">
        <li><a href="classes.php">班级信息</a></li>
    </ul>


</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">成绩分析</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active"><?php if ($type == "stu") echo "学生"; else if ($type == "course") echo "课程"; ?></li>
    </ul>

    <div class="container-fluid">

        <div class="row-fluid">
            <?php if ($type == "stu") { ?>
                <div class="block">
                    <a href="#page-stats" class="block-heading" data-toggle="collapse">学生信息</a>
                    <div id="page-stats" class="block-body collapse in">

                        <div class="stat-widget-container">
                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">学号</p>
                                    <p class="detail">
                                        <?php
                                        echo $stuInfo['number'];
                                        ?>
                                    </p>

                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">姓名</p>
                                    <p class="detail">
                                        <?php
                                        echo $stuInfo['name'];
                                        ?>
                                    </p>

                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">年级</p>
                                    <p class="detail">
                                        <?php
                                        echo $stuInfo['grade'] . '年级';
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">班级</p>
                                    <p class="detail">
                                        <?php
                                        echo $stuInfo['class'] . "班";
                                        ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($type == "course") { ?>
                <div class="block">
                    <a href="#page-stats" class="block-heading" data-toggle="collapse">课程信息</a>
                    <div id="page-stats" class="block-body collapse in">

                        <div class="stat-widget-container">
                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">课程名称</p>
                                    <p class="detail">
                                        <?php
                                        echo $courseInfo['name'];
                                        ?>
                                    </p>

                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">授课教师</p>
                                    <p class="detail">
                                        <?php
                                        echo $courseInfo['teacher'];
                                        ?>
                                    </p>

                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">学分</p>
                                    <p class="detail">
                                        <?php
                                        echo $courseInfo['credit'];
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="detail">适合年级</p>
                                    <p class="detail">
                                        <?php
                                        $arr = ["", "大一", "大二", "大三", "大四"];
                                        echo $arr[$courseInfo['grade']];
                                        ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row-fluid">
                <div class="block span6">
                    <a href="#tablewidget" class="block-heading" data-toggle="collapse">成绩分布</a>
                    <div id="tablewidget" class="block-body collapse in">
                        <div id=<?php if ($type == "stu") echo "container"; else echo "container1"; ?> class="pull-left"
                             style=" width: 600px;height: 300px;"></div>
                    </div>
                </div>
                <?php if ($type == 'stu') { ?>
                    <div class="block span6">
                        <a href="#tablewidget1" class="block-heading" data-toggle="collapse">成绩概述</a>
                        <div id="tablewidget1" class="block-body collapse in">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>加权成绩</td>
                                    <td><?php echo round($wscore, 3) ?></td>
                                </tr>
                                <tr>
                                    <td>平均成绩</td>
                                    <td><?php echo round($avg, 3) ?></td>
                                </tr>
                                <tr>
                                    <td>最高分数</td>
                                    <td><?php echo $max ?></td>
                                </tr>
                                <tr>
                                    <td>最低分数</td>
                                    <td><?php echo $min ?></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($type == 'course') { ?>
                    <div class="block span6">
                        <a href="#tablewidget1" class="block-heading" data-toggle="collapse">成绩概述</a>
                        <div id="tablewidget1" class="block-body collapse in">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>平均成绩</td>
                                    <td><?php echo round($avg, 3) ?></td>
                                </tr>
                                <tr>
                                    <td>选课人数(成绩未出)</td>
                                    <td><?php echo $num ?></td>
                                </tr>
                                <tr>
                                    <td>最高分数</td>
                                    <td><?php echo $max ?></td>
                                </tr>
                                <tr>
                                    <td>最低分数</td>
                                    <td><?php echo $min ?></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php require "footer.php" ?>
        </div>
    </div>


    <script src=" lib/bootstrap/js/bootstrap.js"></script>
    <script
            type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function () {
            $('.demo-cancel-click').click(function () {
                return false;
            });
        });
    </script>


    <script type="text/javascript" src="echarts.common.min.js"></script>
    <script type="text/javascript">
        var dom = document.getElementById("<?php if ($type == "stu") echo "container"; else {
            echo "container1";
        }?>");
        var myChart = echarts.init(dom);
        var app = {};
        option = null;
        app.title = '柱状图分数划分';
        var namedate = ['不及格', '60~69', '70~79', '80~89', '90~99', '满分'];
        var numdate = <?php echo json_encode($count);?>;
        var colorlist = [];
        numdate.forEach(element => {
            colorlist.push(["#386ffd", "#74b3ff"])
            // if (element < 3) {
            //     colorlist.push(["#fc7095", "#fa8466"])
            // } else if (element >= 3 && element < 6) {
            //     colorlist.push(["#386ffd", "#74b3ff"])
            // } else {
            //     colorlist.push(["#1aa8ce", "#49d3c6"])
            // }
        });
        option = {

            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: namedate,
                    axisTick: {
                        alignWithLabel: true
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#4dd1c4",
                            width: 1
                        }
                    },
                    axisLabel: {
                        show: true,
                        textStyle: {
                            color: '#999'
                        }
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLabel: {
                        formatter: '{value} ',
                        show: true,
                        textStyle: {
                            color: '#999'
                        }
                    },
                    axisLine: {
                        lineStyle: {
                            color: "#4dd1c4",
                            width: 1
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            type: 'dashed',
                            color: '#ddd'
                        }
                    }

                }
            ],
            series: [
                {
                    name: '科目数',
                    type: 'bar',
                    barWidth: '60%',
                    data: numdate,
                    itemStyle: {
                        normal: {
                            // color: new echarts.graphic.LinearGradient(
                            //     0, 0, 0, 1,
                            //     [
                            //         {offset: 1, color: 'red'},
                            //         {offset: 0, color: 'orange'}
                            //     ]
                            // )
                            color: function (params) {
                                // var colorList = colorlist;
                                // return colorList[params.dataIndex];
                                var colorList = colorlist

                                var index = params.dataIndex;
                                // if(params.dataIndex >= colorList.length){
                                //         index=params.dataIndex-colorList.length;
                                // }
                                return new echarts.graphic.LinearGradient(0, 0, 0, 1,
                                    [
                                        {offset: 1, color: colorList[index][0]},
                                        {offset: 0, color: colorList[index][1]}
                                    ]);


                            }
                        }
                    }
                }
            ]
        };
        ;
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    </script>
</body>
</html>
