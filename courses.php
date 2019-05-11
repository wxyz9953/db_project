<?php
require "DB.php";
@$query = $_GET['query'];
if (is_string($query)) {
    $str = split($query);
    $res = DB::q("SELECT number,name,teacher,credit,grade,cancel_date FROM "
        . DB::t("course") . " WHERE name LIKE(\"$str\")")->fetchAll();
} else if (is_numeric($query)) {
    $res = DB::q("SELECT number,name,teacher,credit,grade,cancel_date FROM "
        . DB::t("course") . " WHERE number=:n", [':n' => $query])->fetchAll();

} else {
    $page = intval($_GET['page']) - 1;
    if ($page < 0) {
        require "404.html";
        exit;
    }
    $limit = 10;
    $total = $page * $limit;
    $res = DB::q("SELECT number, name, teacher,credit,grade,cancel_date FROM "
        . DB::t("course") . " LIMIT $total, $limit")->fetchAll();
}

$arr = ["", "一", "二", "三", "四"];


$count = DB::q("SELECT COUNT(*) FROM " . DB::t("course"))->fetch()['COUNT(*)'];
$totalPage = ceil($count / 10) - 1;
foreach ($res as &$v) {
    $v['grade'] = '大' . $arr[$v['grade']];
    if (!$v['cancel_date']) {
        $v['cancel_date'] = "未取消";
    }
}
unset($v);
function split($query)
{
    $array = array();
    for ($i = 0; $i < mb_strlen($query, 'utf-8'); $i++) {
        $array[] = mb_substr($query, $i, 1, 'utf-8');
    }
    $str = "%";
    for ($i = 0; $i < count($array); $i++) {
        $str .= $array[$i] . '%';
    }
    return $str;
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

        <h1 class="page-title"><?php @$p = $_GET['page'];
            if ($p) echo "课程列表(第" . $p . "页)"; else echo "搜索结果"; ?></h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">课程</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">
            <?php if (!$query) { ?>
                <div class="btn-toolbar">

                    <form class="form-inline pull-right" role="search" action="/courses.php" method="get">
                        <div class="form-group">
                            <input name="query" class="form-control mr-sm-2" type="text" placeholder="搜索...">
                            <button class="btn" type="submit"><i class="icon-search"></i> 搜索</button>
                        </div>

                    </form>

                    <a href="newCourse.php">
                        <button class="btn btn-primary"><i class="icon-plus"></i> 创建</button>
                    </a>
                    <a href="courseExcel.php">
                        <button class="btn"><i class="icon-download-alt"></i> 导出</button>
                    </a>

                </div>
            <?php } ?>
            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>课程编号</th>
                        <th>课程名</th>
                        <th>任课老师</th>
                        <th>学分</th>
                        <th>适合年级</th>
                        <th>取消年份</th>
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
                                <a href="courseInfo.php?id=<?php echo $k['number'] ?>&page=1"><?php echo $k["name"]; ?></a>
                            </td>
                            <td><?php echo $k["teacher"] ?></td>
                            <td><?php echo $k["credit"] ?></td>
                            <td><?php echo $k["grade"] ?></td>
                            <td><?php echo $k["cancel_date"] ?></td>
                            <td>
                                <a href="/editCourse.php?id=<?php echo $k['number'] ?>"><i class="icon-pencil"></i></a>
                                <a href="#myModal" role="button" data-toggle="modal"
                                   onclick="test(<?php echo $k["number"] ?>)"><i class="icon-remove"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if (!$query) { ?>
                    <div class="pagination pull-right">
                        <br>
                        <ul>
                            <li>
                                <a <?php if ($page == 0) echo "javascript:void(0);" ?>href="/courses.php?page=<?php
                                echo $page ?>">上一页</a>
                            </li>
                            <li <?php if ($_GET['page'] == 1) echo "class=\"active\"" ?>><a
                                        href="/courses.php?page=1">1</a>
                            </li>
                            <li <?php if ($_GET['page'] == 2) echo "class=\"active\"" ?>><a
                                        href="/courses.php?page=2">2</a>
                            </li>
                            <li <?php if ($_GET['page'] == 3) echo "class=\"active\"" ?>><a
                                        href="/courses.php?page=3">3</a>
                            </li>
                            <li><a href="">...</a></li>
                            <li>
                                <a <?php if ($page == $totalPage) echo "javascript:void(0);"; ?>href="/courses.php?page=<?php $page += 1;
                                echo intval($_GET['page']) + 1 ?>">下一页</a>
                            </li>
                            <li>
                                <a href="/courses.php?page=<?php
                                echo $totalPage + 1 ?>">尾页</a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>


            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">提示信息</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>你确定要删除该课程吗？</p>
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
            url: "/delCourse.php?id=" + code,
            type: 'get',
            error: function () {
                alert("删除失败");
            },
            success: function () {
                alert("删除成功");
                window.location.reload();
            },
        });
    }


</script>

</body>
</html>