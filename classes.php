<?php
require "DB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>学生管理系统 </title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height: 300px;
            width: 800px;
            margin: 0px auto;
            margin-top: 1em;
        }

        .brand {
            font-family: georgia, serif;
        }

        .brand .first {
            color: #ccc;
            font-style: italic;
        }

        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
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
        <li class="active"><a href="classes.php">班级信息</a></li>
    </ul>
</div>


<div class="content">

    <div class="header">
        <h1 class="page-title">班级信息</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">班级</li>
    </ul>
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="row-fluid">
                <div class="block span6">
                    <a href="#tablewidget" class="block-heading" data-toggle="collapse">大一</a>
                    <div id="tablewidget" class="block-body collapse in">
                        <div id="container"
                             style=" width: 600px;height: 300px;"></div>
                        <table class="table">
                            <tbody>
                            <?php
                            $res = DB::q("SELECT class, COUNT(*) AS count FROM (SELECT id,class FROM student WHERE grade=1) AS t GROUP BY t.class")->fetchAll();
                            $g1 = [];
                            for ($i = 1; $i <= 10; $i++) {
                                $tmp = DB::q("SELECT avg(grades) AS a FROM student AS s LEFT JOIN enroll AS e ON s.number = e.stu_id WHERE grade=1 AND class=$i AND grades<>-1")->fetch()["a"];
                                if (!$tmp) {
                                    $g1[] = 0;
                                } else {
                                    $g1[] = $tmp;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="block span6">
                    <a href="#table1widget" class="block-heading" data-toggle="collapse">大二</a>
                    <div id="table1widget" class="block-body collapse in">
                        <div id="container1"
                             style=" width: 600px;height: 300px;"></div>
                        <table class="table">
                            <tbody>
                            <?php
                            $res = DB::q("SELECT class, COUNT(*) AS count FROM (SELECT id,class FROM student WHERE grade=2) AS t GROUP BY t.class")->fetchAll();
                            $g2 = [];
                            for ($i = 1; $i <= 10; $i++) {
                                $t = DB::q("SELECT avg(grades) AS a FROM student AS s LEFT JOIN enroll AS e ON s.number = e.stu_id WHERE grade=2 AND class=$i AND grades<>-1")->fetch()["a"];
                                if ($t) {
                                    $g2[] = $t;
                                } else {
                                    $g2[] = 0;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="block span6">
                    <a href="#tablewidget3" class="block-heading" data-toggle="collapse">大三</a>
                    <div id="tablewidget3" class="block-body collapse in">
                        <div id="container2"
                             style=" width: 600px;height: 300px;"></div>
                        <table class="table">
                            <tbody>
                            <?php
                            $res = DB::q("SELECT class, COUNT(*) AS count FROM (SELECT id,class FROM student WHERE grade=3) AS t GROUP BY t.class")->fetchAll();
                            $g3 = [];
                            for ($i = 1; $i <= 10; $i++) {
                                $p = DB::q("SELECT avg(grades) AS a FROM student AS s LEFT JOIN enroll AS e ON s.number = e.stu_id WHERE grade=3 AND class=$i AND grades<>-1")->fetch()["a"];
                                if ($p) {
                                    $g3[] = $p;
                                } else {
                                    $g3[] = 0;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="block span6">
                    <a href="#table1widget4" class="block-heading" data-toggle="collapse">大四</a>
                    <div id="table1widget4" class="block-body collapse in">
                        <div id="container3"
                             style=" width: 600px;height: 300px;"></div>
                        <table class="table">
                            <tbody>
                            <?php
                            $res = DB::q("SELECT class, COUNT(*) AS count FROM (SELECT id,class FROM student WHERE grade=4) AS t GROUP BY t.class")->fetchAll();
                            $g4 = [];
                            for ($i = 1; $i <= 10; $i++) {
                                $o = DB::q("SELECT avg(grades) AS a FROM student AS s LEFT JOIN enroll AS e ON s.number = e.stu_id WHERE grade=4 AND class=$i AND grades<>-1")->fetch()["a"];
                                if ($o) {
                                    $g4[] = $o;
                                } else {
                                    $g4[] = 0;
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php require "footer.php" ?>

        </div>
    </div>
</div>


<script src="lib/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript">
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
    var namedate = ['1班', '2班', '3班', '4班', '5班', '6班', '7班', '8班', '9班', '10班'];
    var numdate = <?php echo json_encode($g1);?>;
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
                name: '平均分',
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
<script type="text/javascript">
    var dom = document.getElementById("container1");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = '柱状图分数划分';
    var namedate = ['1班', '2班', '3班', '4班', '5班', '6班', '7班', '8班', '9班', '10班'];
    var numdate = <?php echo json_encode($g2);?>;
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
                name: '平均分',
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
<script type="text/javascript">
    var dom = document.getElementById("container2");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = '柱状图分数划分';
    var namedate = ['1班', '2班', '3班', '4班', '5班', '6班', '7班', '8班', '9班', '10班'];
    var numdate = <?php echo json_encode($g3);?>;
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
                name: '平均分',
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

<script type="text/javascript">
    var dom = document.getElementById("container3");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = '柱状图分数划分';
    var namedate = ['1班', '2班', '3班', '4班', '5班', '6班', '7班', '8班', '9班', '10班'];
    var numdate = <?php echo json_encode($g4);?>;
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
                name: '平均分',
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


