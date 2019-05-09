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
        <li class="active"><a href="index.php">主页</a></li>
        <li><a href="users.php?page=1">学生列表</a></li>
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
        <div class="stats">
            <p class="stat"><span class="number">53</span>tickets</p>
            <p class="stat"><span class="number">27</span>tasks</p>
            <p class="stat"><span class="number">15</span>waiting</p>
        </div>

        <h1 class="page-title">学生管理系统</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">概述</li>
    </ul>
    <div class="container-fluid">
        <div class="row-fluid">


            <div class="row-fluid">


                <div class="block">
                    <a href="#page-stats" class="block-heading" data-toggle="collapse">概述</a>
                    <div id="page-stats" class="block-body collapse in">

                        <div class="stat-widget-container">
                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="title">
                                        <?php
                                        $res = DB::q("SELECT COUNT(*) AS count FROM " . DB::t("student"))->fetch();
                                        echo $res['count'];
                                        ?>
                                    </p>
                                    <p class="detail">学生总数</p>
                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="title">
                                        <?php
                                        $res = DB::q("SELECT COUNT(*) FROM " . DB::t("course"))->fetch();
                                        echo $res['COUNT(*)'];
                                        ?>
                                    </p>
                                    <p class="detail">课程总数</p>
                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="title">
                                        <?php
                                        $res = DB::q("SELECT SUM(count) AS sum FROM (SELECT COUNT(DISTINCT class) as count FROM ".DB::t("student")." GROUP BY grade) AS a ")->fetch();
                                        echo $res['sum'];
                                        ?>
                                    </p>
                                    <p class="detail">班级总数</p>
                                </div>
                            </div>

                            <div class="stat-widget">
                                <div class="stat-button">
                                    <p class="title">4</p>
                                    <p class="detail">年级总数</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="block span6">
                    <a href="#tablewidget" class="block-heading" data-toggle="collapse">学生</a>
                    <div id="tablewidget" class="block-body collapse in">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                                <th>年级</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = DB::q("SELECT number, name, grade FROM " . DB::t("student") . " ORDER BY grade ASC LIMIT 0,5")->fetchAll();
                            $arr = ["", "一", "二", "三", "四"];
                            foreach ($res as $v) { ?>
                                <tr>
                                    <td><?php echo $v["number"] ?></td>
                                    <td><?php echo $v["name"] ?></td>
                                    <td><?php echo "大" . $arr[$v["grade"]]; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <p><a href="users.php?page=1">更多...</a></p>
                    </div>
                </div>
                <div class="block span6">
                    <a href="#table1widget" class="block-heading" data-toggle="collapse">课程</a>
                    <div id="table1widget" class="block-body collapse in">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>课程编号</th>
                                <th>课程名</th>
                                <th>任课教师</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = DB::q("SELECT number, name, teacher FROM " . DB::t("course") . " LIMIT 0,5")->fetchAll();
                            foreach ($res as $t) { ?>
                                <tr>
                                    <td><?php echo $t["number"] ?></td>
                                    <td><?php echo $t["name"] ?></td>
                                    <td><?php echo $t["teacher"] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <p><a href="courses.php?page=1">更多...</a></p>
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

</body>
</html>


