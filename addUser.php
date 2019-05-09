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
        <li class="active"><a href="addUser.php">信息录入</a></li>

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

        <h1 class="page-title">录入学生信息</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
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
                                           placeholder=" 学号必须是10位,示例:3017218140" name="number" id="number"
                                           class="input-xlarge">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="textarea">姓名</label>
                                <div class="controls">
                                    <input style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           name="name" class="input-xlarge">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="textarea">性别</label>
                                <div class="controls">
                                    <div class="inline" style="margin:5px 0px 0px 0px">
                                        男性：
                                        <input type="radio" name="sex" value="0"/>
                                        女性：
                                        <input type="radio" name="sex" value="1"/>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">入学年龄</label>
                                <div class="controls">
                                    <input name="enter_age"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">入学时间</label>
                                <div class="controls">
                                    <input style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           placeholder=" 填写入学的年份" name="enter_time"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">年级</label>
                                <div class="controls">
                                    <input placeholder=" 例如大一，填写1" name="grade"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="textarea">班级</label>
                                <div class="controls">
                                    <input name="class"
                                           style="width:280px; margin:0px 0px 0px 0px;height:25px;border-radius:5px;border:1px solid #DBDBDB;"
                                           class="input-xlarge">
                                </div>
                            </div>

                            <div class="pull-right">
                                <br>
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
    function add(number) {
        $.ajax({
            type: "POST",
            url: "/addStu.php",
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




