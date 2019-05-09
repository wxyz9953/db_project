<?php
require "DB.php";
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

$id = intval($_GET['id']);
$stuInfo = DB::q("SELECT number, name, grade, class FROM " . DB::t("student") . " WHERE number = :i", [":i" => $id])->fetch();


@$query = $_GET['query'];
if ($query) {
    if (is_numeric($query)) {
        $res = DB::q("SELECT e.id,course_id, credit,grades, name FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") . " AS c ON e.course_id = c.number WHERE e.stu_id=:s AND e.course_id=:c", [":s" => $id, ":c" => $query])->fetchAll();
    } else if (is_string($query)) {
        $str = split($query);
        $res = DB::q("SELECT e.id,course_id, credit,grades, name FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") . " AS c ON e.course_id = c.number WHERE e.stu_id=:s AND c.name LIKE(\"$str\")", [":s" => $id])->fetchAll();
    }

} else {
    $page = intval($_GET['page']) - 1;
    $limit = 10;
    $total = $page * $limit;
    $res = DB::q("SELECT e.id,course_id, credit,grades, name FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("course") . " AS c ON e.course_id = c.number WHERE e.stu_id=:s LIMIT $total,$limit ", [":s" => $id])->fetchAll();
    $count = DB::q("SELECT COUNT(*) FROM " . DB::t("enroll") . " WHERE stu_id = :id", [':id' => $id])->fetch()['COUNT(*)'];
    $totalPage = ceil($count / 10) - 1;
    if ($page < 0) {
        require "404.html";
        exit;
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


    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-user"></i>课程</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="courses.php?page=1">课程列表</a></li>
        <li><a href="newCourse.php">信息录入</a></li>
    </ul>

</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">查询结果</h1>
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

            <!--            -->
            <?php if (!$query) { ?>
                <div class="btn-toolbar">

                    <div class="form-inline pull-right">
                        <div class="form-group">
                            <input id="query" class="form-control mr-sm-2" type="text" placeholder="搜索...">
                            <button class="btn" onclick="search(<?php echo $id ?>)"><i class="icon-search"></i> 搜索
                            </button>
                        </div>

                    </div>

                    <a href="addCourse.php?id=<?php echo $id; ?>&page=1">
                        <button class="btn btn-primary"><i class="icon-plus"></i> 创建</button>
                    </a>
                    <a href="stuInfoExcel.php?id=<?php echo $_GET['id']; ?>">
                        <button class="btn"><i class="icon-download-alt"></i> 导出</button>
                    </a>

                    <a href="analysis.php?id=<?php echo $_GET['id']; ?>">
                        <button class="btn"><i class="icon-bar-chart"></i> 成绩分析</button>
                    </a>

                </div>
            <?php } ?>
            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>课程编号</th>
                        <th>课程名称</th>
                        <th>分数</th>

                        <th style="width: 26px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($res as $k) { ?>
                        <tr>
                            <td>
                                <?php echo $k["course_id"] ?>
                            </td>
                            <td>
                                <a href="courseInfo.php?id=<?php echo $k['course_id'] ?>"><?php echo $k["name"]; ?></a>
                            </td>

                            <td><?php if ($k["grades"] == -1) {
                                    echo "成绩未出";
                                } else echo $k["grades"] ?></td>
                            <td>
                                <a href="#edit" role="button" data-toggle="modal"
                                   onclick="test(<?php echo $k['course_id'] ?>)">
                                    <i class="icon-pencil"></i></a>
                                <a href="#myModal" role="button" data-toggle="modal"
                                   onclick="test(<?php echo $k['id'] ?>)"><i class="icon-remove"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">提示信息</h3>
                </div>
                <div class="modal-body">
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>你确定要删除该选课记录吗？</p>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    <button class="btn btn-danger" data-dismiss="modal" onclick="del(number)">删除</button>
                </div>
            </div>

            <div class="modal small hide fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">录入成绩</h3>
                </div>
                <div class="modal-body">
                    <input id="score" name="score" type="text" width="100px">
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                    <button class="btn btn-info" data-dismiss="modal" onclick="addScore(number)">确定</button>
                </div>
            </div>

            <?php if (!$query) { ?>
                <div class="pagination">
                    <ul>
                        <li>
                            <a <?php if ($page == 0) {
                                echo "javascript:void(0);";
                            } ?>href="/stuInfo.php?id=<?php echo $id ?>&page=<?php
                            echo $page ?>">上一页</a>
                        </li>
                        <li>
                            <a href="<?php if ($totalPage >= 0) echo "/stuInfo.php?id=$id&page=1"; else echo "javascript:void(0);" ?>">1</a>
                        </li>
                        <li>
                            <a href="<?php if ($totalPage >= 1) echo "/stuInfo.php?id=$id&page=2"; else echo "javascript:void(0);" ?>">2</a>
                        </li>
                        <li>
                            <a href="<?php if ($totalPage >= 2) echo "/stuInfo.php?id=$id&page=3"; else echo "javascript:void(0);" ?>">3</a>
                        </li>
                        <li><a href="">...</a></li>
                        <li>
                            <a <?php if ($_GET['page'] - 1 == $totalPage) echo "javascript:void(0);" ?>href="/stuInfo.php?id=<?php echo $id ?>&page=<?php $page += 1;
                            echo intval($_GET['page']) + 1 ?>">下一页</a>
                        </li>
                        <li>
                            <a href="/stuInfo.php?id=<?php echo $id ?>&page=<?php
                            echo $totalPage + 1 ?>">尾页</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>

            <?php require "footer.php" ?>

        </div>
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


<script
        language="javascript">
    function test(code) {
        number = code;
    }
</script>


<script language="javascript">
    function del(code) {
        $.ajax({
            url: "/delEnroll.php?id=" + code,
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

<script language="javascript">
    function addScore(code) {
        var value = document.getElementById("score").value;
        $.ajax({
            url: "/addScore.php?id=" + code + "&score=" + value + "&sid=" +<?php echo $_GET['id'];?>,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data) {
                    alert(data);
                } else {
                    alert("录入成功");
                    window.location.reload();
                }

            },
            error: function () {
                alert("失败");
            },

        });
    }
</script>
<script language="javascript">
    function search(code) {
        var value = document.getElementById("query").value;
        location.href = "/stuInfo.php?id=<?php echo $id?>&query=" + value;
    }
</script>
</body>
</html>
