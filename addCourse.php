<?php
require "DB.php";
$id = intval($_GET['id']);
$page = intval($_GET['page']) - 1;
$limit = 10;
$total = $page * $limit;
$courses = DB::q("SELECT c.number, c.name,c.teacher, c.credit,c.grade FROM " . DB::t("course") . " AS c WHERE c.grade <= (SELECT s.grade FROM "
    . DB::t("student") . " AS s WHERE s.number = :n) AND (ISNULL(cancel_date) OR cancel_date > :d) AND c.number NOT IN(SELECT course_id FROM " . DB::t("enroll") . " WHERE stu_id = :n)", [':n' => $id, ":d" => date("Y")])->fetchAll();
$count = count($courses);
$totalPage = ceil($count / 10) - 1;
$course = [];
for ($i = $page * 10; $i < $limit + $page * 10; $i++) {
    if ($i < $count) {
        $course[] = $courses[$i];
    }
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


    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-table"></i>课程</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="courses.php?page=1">课程列表</a></li>
        <li><a href="newCourse.php">信息录入</a></li>
    </ul>

</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">可选列表(第<?php echo $_GET['page'];
            echo "页"; ?>)</h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">学生</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <div class="btn-toolbar">

                <form class="form-inline pull-right" role="search" action="/search.php" method="get"
                      target="_blank">
                    <div class="form-group">
                        <input name="query" class="form-control mr-sm-2" type="text" placeholder="搜索...">
                        <button class="btn" type="submit"><i class="icon-search"></i> 搜索</button>
                    </div>

                </form>

                <a href="stuExcel.php">
                    <button class="btn"><i class="icon-download-alt"></i> 导出</button>
                </a>

            </div>
            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>课程编号</th>
                        <th>课程名称</th>
                        <th>授课教师</th>
                        <th>学分</th>
                        <!--                        <th>分数</th>-->
                        <th style="width: 26px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php if ($course) {
                        foreach ($course as $k) { ?>
                            <tr>
                                <td>
                                    <?php echo $k["number"] ?>
                                </td>
                                <td><?php echo $k["name"]; ?></td>
                                <td><?php echo $k["teacher"] ?></td>
                                <td><?php echo $k["credit"] ?></td>
                                <!--                            <td style="width: 100px;"></td>-->
                                <td>
                                    <a onclick="confirmCourse(<?php echo $k["number"] ?>,<?php echo $_GET['id']; ?>)"><i
                                                class="icon-ok"></i> </a>
                                </td>

                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>
                <div class="pagination pull-right">
                    <br>
                    <ul>
                        <li>
                            <a <?php if ($page == 0) echo "javascript:void(0);" ?>href="/addCourse.php?id=<?php echo $id ?>&page=<?php
                            echo $page ?>">上一页</a>
                        </li>
                        <li <?php if ($_GET['page'] == 1) echo "class=\"active\"" ?>><a
                                    href="/addCourse.php?id=<?php echo $id ?>&page=1">1</a>
                        </li>
                        <li <?php if ($_GET['page'] == 2) echo "class=\"active\"" ?>><a
                                <?php if ($page == $totalPage) echo "href = \"javascript:void(0);\"" ?>
                                    href="/addCourse.php?id=<?php echo $id ?>&page=2">2</a>
                        </li>
                        <li <?php if ($_GET['page'] == 3) echo "class=\"active\""; ?>><a
                                <?php if ($page == $totalPage) echo "href = \"javascript:void(0);\"" ?>
                                    href="/addCourse.php?id=<?php echo $id ?>&page=3">3</a>
                        </li>
                        <li><a href="">...</a></li>
                        <li>
                            <a <?php if ($page == $totalPage) echo "javascript:void(0);"; ?>href="/addCourse.php?id=<?php echo $id ?>&page=<?php $page += 1;
                            echo intval($_GET['page']) + 1 ?>">下一页</a>
                        </li>
                        <li>
                            <a href="/addCourse.php?id=<?php echo $id ?>&page=<?php
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
    function confirmCourse(code, sid) {
        $.ajax({
            url: "/addEnroll.php?id=" + code + "&sid=" + sid,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    alert("选课成功");
                    location.reload();
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
