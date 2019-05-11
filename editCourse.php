<?php
require "DB.php";
$number = @intval($_GET['id']);

$res = DB::q("SELECT number,name,teacher,credit, grade, cancel_date FROM " . DB::t("course") . " WHERE number = :number", [':number' => $number])->fetch();
if (!$res) {
    require "404.html";
    exit;
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
        <li class="active"><a href="courses.php?page=1">课程列表</a></li>
        <li><a href="newCourse.php">信息录入</a></li>
    </ul>

    <a href="#dashboard-menu3" class="nav-header" data-toggle="collapse"><i class="icon-group"></i>班级</a>
    <ul id="dashboard-menu3" class="nav nav-list collapse in">
        <li><a href="classes.php">班级信息</a></li>
    </ul>

</div>


<div class="content">

    <div class="header">

        <h1 class="page-title">修改课程信息</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li><a href="courses.php?page=1">课程</a> <span class="divider">/</span></li>
        <li>修改课程 <span class="divider">/</span></li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">


            <div class="well">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">课程信息</a></li>
                </ul>
                <div class="form-horizontal page-content">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">
                            <form id="form1" onsubmit="return false" action="#" method="post">
                                <label>课程名</label>
                                <textarea name="name" rows="1"
                                          class="input-xlarge"><?php echo $res["name"] ?></textarea>
                                <br>
                                <br>
                                <label>任课教师</label>
                                <textarea name="teacher" rows="1"
                                          class="input-xlarge"><?php echo $res["teacher"] ?></textarea>
                                <br>
                                <br>
                                <label>学分</label>
                                <textarea name="credit" rows="1"
                                          class="input-xlarge"><?php echo $res["credit"] ?></textarea>
                                <br>
                                <br>
                                <label>年级</label>
                                <textarea name="grade" rows="1"
                                          class="input-xlarge"><?php echo $res["grade"] ?></textarea>
                                <br>
                                <br>
                                <label>取消年份</label>
                                <textarea name="cancel_date" rows="1"
                                          class="input-xlarge"><?php echo $res["cancel_date"] ?></textarea>
                                <div class="btn-toolbar">
                                    <button class="btn btn-primary" onclick="edit(<?php echo $_GET['id'] ?>)"><i
                                                class="icon-save"></i> 保存
                                    </button>
                                    <div class="btn-group">
                                    </div>
                                </div>
                            </form>
                        </div>

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
<script type="text/javascript">
    function edit(number) {
        $.ajax({
            type: "POST",
            url: "/editCo.php?id=" + number,//url
            data: $('#form1').serialize(),
            dataType: "json",
            success: function (data) {
                if (data) {
                    alert(data);

                } else {
                    alert("修改成功");
                }
            },
            error: function () {
                alert("异常！");
            }
        });
    }
</script>
</body>
</html>


