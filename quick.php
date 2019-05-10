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

@$query = $_GET['query'];
$page = $_GET['page'] - 1;

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
<!--        <li class="active"><a href="quick.php">成绩快速录入</a></li>-->

    </ul>


    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-table"></i>课程</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="courses.php?page=1">课程列表</a></li>
        <li><a href="newCourse.php">信息录入</a></li>
    </ul>

</div>

<div class="content">

    <div class="header">

        <h1 class="page-title">
            成绩录入
        </h1>
    </div>

    <ul class="breadcrumb">
        <li><a href="index.php">主页</a> <span class="divider">/</span></li>
        <li class="active">成绩录入</li>
    </ul>

    <div class="form-inline">
        <div class="form-group">
            <input id="query" class="form-control mr-sm-2" type="text" placeholder="搜索...">
            <button class="btn" onclick="search(<?php echo $id ?>)"><i class="icon-search"></i> 搜索
            </button>
        </div>

    </div>

    <?php if ($query) { ?>
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