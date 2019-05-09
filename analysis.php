<?php
require "DB.php";
$id = intval($_GET['id']);
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
$wscore /= $we;

$avg = DB::q("SELECT AVG(grades) AS avg FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['avg'];
$max = DB::q("SELECT MAX(grades) AS max FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['max'];
$min = DB::q("SELECT MIN(grades) AS min FROM " . DB::t("enroll") . " WHERE stu_id=:s AND grades>-1", [':s' => $id])->fetch()['min'];
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
        <li class="active"><a href="users.php?page=1">学生列表</a></li>
        <li><a href="addUser.php">信息录入</a></li>

    </ul>

    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>Account<span
                class="label label-info">+3</span></a>
    <ul id="accounts-menu" class="nav nav-list collapse">
        <li><a href="sign-in.html">Sign In</a></li>
        <li><a href="sign-up.html">Sign Up</a></li>
        <li><a href="reset-password.html">Reset Password</a></li>
    </ul>

    <a href="#error-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>Error
        Pages <i class="icon-chevron-up"></i></a>
    <ul id="error-menu" class="nav nav-list collapse">
        <li><a href="403.html">403 page</a></li>
        <li><a href="404.html">404 page</a></li>
        <li><a href="500.html">500 page</a></li>
        <li><a href="503.html">503 page</a></li>
    </ul>

    <a href="#legal-menu" class="nav-header" data-toggle="collapse"><i class="icon-legal"></i>Legal</a>
    <ul id="legal-menu" class="nav nav-list collapse">
        <li><a href="privacy-policy.html">Privacy Policy</a></li>
        <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
    </ul>

    <a href="help.html" class="nav-header"><i class="icon-question-sign"></i>Help</a>
    <a href="faq.html" class="nav-header"><i class="icon-comment"></i>Faq</a>
</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">成绩分析</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">学生</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <!--            -->
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
            <div class="row-fluid">
                <div class="block span6">
                    <a href="#tablewidget" class="block-heading" data-toggle="collapse">成绩分布</a>
                    <div id="tablewidget" class="block-body collapse in">
                        <div id="container" class="pull-left" style=" width: 600px;height: 300px;"></div>
                    </div>
                </div>
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
                                <td><?php echo round($avg, 6) ?></td>
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
        var dom = document.getElementById("container");
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
