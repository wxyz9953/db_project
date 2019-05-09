<?php
require "DB.php";
$number = @intval($_GET['id']);

$res = DB::q("SELECT name,sex,enter_age,enter_time, grade, class FROM " . DB::t("student") . " WHERE number = :number", [':number' => $number])->fetch();
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

        <h1 class="page-title">修改学生信息</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">


            <div class="well">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">学生信息</a></li>
                </ul>
                <div class="form-horizontal">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active in" id="home">
                            <form id="form1" onsubmit="return false" action="#" method="post">
                                <label>姓名</label>
                                <textarea name="name" rows="1"
                                          class="input-xlarge"><?php echo $res["name"] ?></textarea>
                                <br>
                                <br>
                                <label>性别</label>
                                男性：
                                <?php
                                if ($res['sex'] == 0) echo "<input type=\"radio\" checked=\"checked\" name=\"sex\" value=\"0\"/>";
                                else echo "<input type=\"radio\" name=\"sex\" value=\"0\"/>";
                                ?>

                                女性：
                                <?php
                                if ($res['sex'] == 1) echo "<input type=\"radio\" checked=\"checked\" name=\"sex\" value=\"1\"/>";
                                else echo "<input type=\"radio\" name=\"sex\" value=\"1\"/>";
                                ?>
                                <br>
                                <br>
                                <label>入学年龄</label>
                                <textarea name="enter_age" rows="1"
                                          class="input-xlarge"><?php echo $res["enter_age"] ?></textarea>
                                <br>
                                <br>
                                <label>入学时间</label>
                                <textarea name="enter_time" rows="1"
                                          class="input-xlarge"><?php echo $res["enter_time"] ?></textarea>
                                <br>
                                <br>
                                <label>年级</label>
                                <textarea name="grade" rows="1"
                                          class="input-xlarge"><?php echo $res["grade"] ?></textarea>
                                <br>
                                <br>
                                <label>班级</label>
                                <textarea name="class" rows="1"
                                          class="input-xlarge"><?php echo $res["class"] ?></textarea>
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
            url: "/edit.php?id=" + number,//url
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


