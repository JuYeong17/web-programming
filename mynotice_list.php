<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/mynotice.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<?php
    if (!$userid)
    {
        echo("<script>
                alert('로그인 후 이용해주세요!');
                history.go(-1);
                </script>
            ");
        exit;
    }
?>
<?php

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$con = mysqli_connect("localhost", "user1", "12345", "sample");

// springsummer 게시판에서 로그인된 사용자가 작성한 글 조회
$springsummer_sql = "SELECT * FROM springsummer WHERE id='$userid' ORDER BY regist_day DESC, num DESC";
$springsummer_result = mysqli_query($con, $springsummer_sql);
$springsummer_total_record = mysqli_num_rows($springsummer_result); // 전체 글 수

// autumnwinter 게시판에서 로그인된 사용자가 작성한 글 조회
$autumnwinter_sql = "SELECT * FROM autumnwinter WHERE id='$userid' ORDER BY regist_day DESC, num DESC";
$autumnwinter_result = mysqli_query($con, $autumnwinter_sql);
$autumnwinter_total_record = mysqli_num_rows($autumnwinter_result); // 전체 글 수

$total_record = $springsummer_total_record + $autumnwinter_total_record;

mysqli_close($con);
?>

<section id="mainlist">
    <div class="container">
        <h3 class="heading">
             MY Notice
        </h3>
        <div class="box-container">
        <?php
            $scale = 6; // 한 페이지에 표시할 글 수

            if ($total_record % $scale == 0)     
                $total_page = floor($total_record/$scale);      
            else
                $total_page = floor($total_record/$scale) + 1;
            
            $start = ($page - 1) * $scale;      
            $number = $total_record - $start;

            // 배열에 글 데이터 저장
            $notice_list = array();
            $row["board"] = "";

            // springsummer 게시판 데이터 저장
            while ($springsummer_row = mysqli_fetch_array($springsummer_result)) {
                $springsummer_row["board"] = "springsummer";
                $notice_list[] = $springsummer_row;
            }

            // autumnwinter 게시판 데이터 저장
            while ($autumnwinter_row = mysqli_fetch_array($autumnwinter_result)) {
                $autumnwinter_row["board"] = "autumnwinter";
                $notice_list[] = $autumnwinter_row;
            }

            // 글 데이터를 시간 순서에 따라 정렬
            function sortByDate($a, $b) {
                return strtotime($b['regist_day']) - strtotime($a['regist_day']);
            }

            usort($notice_list, 'sortByDate');

            // 페이지에 해당하는 글 목록 출력
            $start_index = ($page - 1) * $scale;
            $end_index = min($start_index + $scale, $total_record);

            for ($i = $start_index; $i < $end_index; $i++) {
                $row = $notice_list[$i];
                $num = $row["num"];
                $subject = $row["subject"];
                $name = $row["name"];
                $regist_day = $row["regist_day"];
                $hit = $row["hit"];
                $file_copied = $row["file_copied"];
        ?>

            <div class="box">
                <?php
                if (!empty($file_copied)) {
                    $real_name = $file_copied;
                    $file_path = "./data/" . $real_name;
                    echo '<img src="' . $file_path . '" alt="이미지">';
                } else {
                    echo '<img src="./img/Nophoto.png" alt="대체 이미지">';
                }
                ?>
                <a href="<?php echo $row['board'] == 'springsummer' ? 'springsummer_view.php' : 'autumnwinter_view.php'; ?>?num=<?=$num?>"><?=$subject?></a>
                <span><?=$name?></span>
                <span><?=$regist_day?></span>
                <span class="hit"><?=$hit?></span>
            </div>
        <?php
            
            }

            if ($total_record == 0) {
                echo "<h1 style='font-size: 30px; '>작성한 글이 없습니다.</h1>";
            }
        ?>
        </div>

        <div id="page_num">
            <ul>
            <?php
                if ($total_page >= 2 && $page >= 2) {
                    $new_page = $page - 1;
                    echo "<li><a href='mynotice_list.php?page=$new_page'>◀ 이전</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                for ($i = 1; $i <= $total_page; $i++) {
                    if ($page == $i) {
                        echo "<li><b> $i </b></li>";
                    } else {
                        echo "<li><a href='mynotice_list.php?page=$i'> $i </a></li>";
                    }
                }

                if ($total_page >= 2 && $page != $total_page) {
                    $new_page = $page + 1;
                    echo "<li> <a href='mynotice_list.php?page=$new_page'>다음 ▶</a> </li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
            </ul>
        </div>
    </div>
</section>

<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
