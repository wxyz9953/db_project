<?php
require "DB.php";


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


    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-table"></i>课程</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="courses.php?page=1">课程列表</a></li>
        <li class="active"><a href="newCourse.php">信息录入</a></li>
    </ul>

</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">录入课程信息</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li><a href="courses.php?page=1">课程</a> <span class="divider">/</span></li>
        <li class="active">信息录入</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <div class="form-horizontal">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="home">
                        <br>
                        <form id="form1" onsubmit="return false" action="#" method="post">
                            <div class="control-group">
                                <label class="control-label" for="textarea">学号</label>
                                <div class="controls">
                                    <input style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           placeholder=" 课程编号必须是7位,示例:1000000" name="number" id="number"
                                           class="input-xlarge">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="textarea">课程名称</label>
                                <div class="controls">
                                    <input style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           name="name" class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">任课教师</label>
                                <div class="controls">
                                    <input name="teacher"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">学分</label>
                                <div class="controls">
                                    <input style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           name="credit"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">适合年级</label>
                                <div class="controls">
                                    <input placeholder=" 例如大一，填写1" name="grade"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">取消年份</label>
                                <div class="controls">
                                    <input placeholder=" 若没有取消计划可不填" name="cancel_date"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="pull-right">
                                <button class="btn btn-primary" onclick="add()" style="margin: 0px 0px 0px -950px;"><i
                                            class="icon-save"></i> 录入
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>


        </div>
        <?php require "footer.php" ?>
    </div>
</div>

<script>
    function add() {
        $.ajax({
            type: "POST",
            url: "/addClass.php",
            data: $('#form1').serialize(),
            dataType: "json",
            success: function (data) {
                if (data) {
                    alert(data);
                } else {
                    alert("成功");
                }

            },
            error: function () {
                alert("异常！");
            }
        });
    }
</script>

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
    $(function () {
        $("#number").bind('input propertychange', function () {
            $("#result").html($(this).val().length + ' 位');
        });
    });
</script>

</body>
</html>




