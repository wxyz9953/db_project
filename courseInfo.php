<?php
require "DB.php";
$id = intval($_GET["id"]);
$course = DB::q("SELECT name,teacher,credit,grade,cancel_date FROM " . DB::t("course") . " WHERE number=:n", [':n' => $id])->fetch();
$students = DB::q("SELECT e.id,s.number,s.name,s.grade,s.class,e.grades FROM " . DB::t("enroll") . " AS e LEFT JOIN " . DB::t("student") . " AS s ON e.stu_id=s.number WHERE e.course_id=:n", [':n' => $id])->fetchAll();
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

        <h1 class="page-title"><?php
            echo "选课信息";
            ?></h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">学生</li>
    </ul>

    <div class="container-fluid">
        <div class="row-fluid">

            <!--            -->
            <div class="block">
                <a href="#page-stats" class="block-heading" data-toggle="collapse">课程信息</a>
                <div id="page-stats" class="block-body collapse in">

                    <div class="stat-widget-container">
                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="detail">课程名称</p>
                                <p class="detail">
                                    <?php
                                    echo $course['name'];
                                    ?>
                                </p>

                            </div>
                        </div>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="detail">授课教师</p>
                                <p class="detail">
                                    <?php
                                    echo $course['teacher'];
                                    ?>
                                </p>

                            </div>
                        </div>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="detail">学分</p>
                                <p class="detail">
                                    <?php
                                    echo $course['credit'];
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="detail">适合年级</p>
                                <p class="detail">
                                    <?php
                                    $arr = ["", "大一", "大二", "大三", "大四"];
                                    echo $arr[$course['grade']];
                                    ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <a href="courseInfoExcel.php?id=<?php echo $_GET['id']; ?>">
                <button class="btn"><i class="icon-download-alt"></i> 导出</button>
            </a>

            <a href="analysis.php?id=<?php echo $_GET['id']; ?>&type=course">
                <button class="btn"><i class="icon-bar-chart"></i> 成绩分析</button>
            </a>

        </div>
        <div class="well">
            <table class="table">
                <thead>
                <tr>
                    <th>学号</th>
                    <th>姓名</th>
                    <th>年级</th>
                    <th>班级</th>
                    <th>分数</th>

<!--                    <th style="width: 26px;"></th>-->
                </tr>
                </thead>
                <tbody>

                <?php foreach ($students as $k) { ?>
                    <tr>
                        <td>
                            <?php echo $k["number"] ?>
                        </td>
                        <td>
                            <a href="stuInfo.php?id=<?php echo $k['number'] ?>&page=1"><?php echo $k["name"]; ?></a>
                        </td>

                        <td><?php $arr = ["", "大一", "大二", "大三", "大四"];
                            echo $arr[$k['grade']]; ?></td>
                        <td><?php echo $k['class'];
                            echo "班"; ?></td>
                        <td><?php if ($k['grades'] == -1) {
                                echo "未出";
                            } else {
                                echo $k["grades"];
                            }
                            ?>
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


        <?php require "footer.php" ?>

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
