<?php
require "DB.php";
$temp = null;
$page = intval($_GET['page']) - 1;
if ($page < 0) {
    require "404.html";
    exit;
}
$arr = ["", "一", "二", "三", "四"];
$limit = 10;
$total = $page * $limit;
$res = DB::q("SELECT number, name, sex,enter_age,enter_time,grade,class FROM "
    . DB::t("student") . " LIMIT $total, $limit")->fetchAll();
$count = DB::q("SELECT COUNT(*) FROM " . DB::t("student"))->fetch()['COUNT(*)'];
$totalPage = ceil($count / 10) - 1;
foreach ($res as &$v) {
    $v['sex'] == 1 ? $v['sex'] = "女" : $v['sex'] = "男";
    $v['grade'] = '大' . $arr[$v['grade']];
    $v['class'] = $v['class'] . "班";
}
unset($v);
@$type = $_GET['type'];
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

        <h1 class="page-title">学生列表(第<?php echo $_GET['page'];
            echo "页"; ?>)</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">学生</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <?php if ($type == "edit") {
                $info = DB::q("SELECT name, sex, enter_age,enter_time,grade,class FROM " . DB::t("student") . " where number=:n", [':n' => $_GET['id']])->fetch();
                ?>
                <div class="block">
                    <a href="#page-stats" class="block-heading" data-toggle="collapse">修改学生信息</a>
                    <div id="page-stats" class="block-body collapse in">
                        <br>
                        <form class="form-inline">
                            姓名：
                            <input type="text" name="name" class="input-xxlarge" value="<?php echo $info["name"] ?>">
                            &nbsp;&nbsp;
                            密码：
                            <input type="password" class="input-xxlarge" placeholder="Password">
                            <br>
                            <br>
                            姓名：
                            <input type="text" class="input-xlarge" placeholder="Email">
                            密码：
                            <input type="password" class="input-xlarge" placeholder="Password">
                            <button type="submit" class="btn pull-right">Sign in</button>
                        </form>

                    </div>
                </div>
            <?php } ?>

            <div class="btn-toolbar">

                <form class="form-inline pull-right" role="search" action="/search.php" method="get">
                    <div class="form-group">
                        <input name="query" class="form-control mr-sm-2" type="text" placeholder="搜索...">
                        <button class="btn" type="submit"><i class="icon-search"></i> 搜索</button>
                    </div>

                </form>

                <a href="addUser.php">
                    <button class="btn btn-primary"><i class="icon-plus"></i> 创建</button>
                </a>
                <a href="stuExcel.php">
                    <button class="btn"><i class="icon-download-alt"></i> 导出</button>
                </a>

            </div>
            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>学号</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>入学年龄</th>
                        <th>入学日期</th>
                        <th>年级</th>
                        <th>班级</th>
                        <th style="width: 26px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($res as $k) { ?>
                        <tr>
                            <td>
                                <?php echo $k["number"] ?>
                            </td>
                            <td>
                                <a href="stuInfo.php?id=<?php echo $k['number'] ?>&page=1"><?php echo $k["name"]; ?></a>
                            </td>
                            <td><?php echo $k["sex"] ?></td>
                            <td><?php echo $k["enter_age"] ?></td>
                            <td><?php echo $k["enter_time"] ?></td>
                            <td><?php echo $k["grade"] ?></td>
                            <td><?php echo $k["class"] ?></td>
                            <td>
                                <a href="/user.php?id=<?php echo $k['number'] ?>"><i
                                            class="icon-pencil"></i></a>
                                <a href="#myModal" role="button" data-toggle="modal"
                                   onclick="test(<?php echo $k["number"] ?>)"><i class="icon-remove"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="pagination pull-right">
                    <br>
                    <ul>
                        <li>
                            <a <?php if ($page == 0) echo "javascript:void(0);" ?>href="/users.php?page=<?php
                            echo $page ?>">上一页</a>
                        </li>
                        <li <?php if ($_GET['page'] == 1) echo "class=\"active\"" ?>><a href="/users.php?page=1">1</a>
                        </li>
                        <li <?php if ($_GET['page'] == 2) echo "class=\"active\"" ?>><a href="/users.php?page=2">2</a>
                        </li>
                        <li <?php if ($_GET['page'] == 3) echo "class=\"active\"" ?>><a href="/users.php?page=3">3</a>
                        </li>
                        <li><a href="">...</a></li>
                        <li>
                            <a <?php if ($page == $totalPage) echo "javascript:void(0);"; ?>href="/users.php?page=<?php $page += 1;
                            echo intval($_GET['page']) + 1 ?>">下一页</a>
                        </li>
                        <li>
                            <a href="/users.php?page=<?php
                            echo $totalPage + 1 ?>">尾页</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">提示信息</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>你确定要删除该学生吗？</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    <button class="btn btn-danger" data-dismiss="modal" onclick="del(number)">删除</button>
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


<script language="javascript">
    function test(code) {
        number = code;
    }
</script>


<script language="javascript">
    function del(code) {
        $.ajax({
            url: "/delStu.php?id=" + code,
            type: 'get',
            error: function () {
                alert("删除失败");
            },
            success: function () {
                window.location.reload();
            },
        });
    }


</script>

</body>
</html>