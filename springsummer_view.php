<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/springsummer.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section id="mainlist">
   	<div id="springsummer_box">
	    <h3 class="title">
			생생한 여행 후기!
		</h3>
		<?php

	if (isset($_GET["page"])) {
		$page = $_GET["page"];
	} else {
		$page = 1;
	}

	$num  = $_GET["num"];

	$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from springsummer where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$file_name    = $row["file_name"];
	$file_type    = $row["file_type"];
	$file_copied  = $row["file_copied"];
	$hit          = $row["hit"];

	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);

	$hit_session_name = $num."ss_hit";
	$logged_in_user = isset($_SESSION["id"]) ? $_SESSION["id"] : null; 
	if (!isset($_SESSION[$hit_session_name]) && $logged_in_user !== $id) {
		$new_hit = $hit + 1;
		$sql = "update springsummer set hit=$new_hit where num=$num";  
		mysqli_query($con, $sql);
		$_SESSION[$hit_session_name] = true;
	}
	
?>
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>
			</li>
			<li class="view_img">
				<?php
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);
						echo '<img src="' . $file_path . '" alt="이미지">';
						 echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		 <a href='springsummer_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			           	}
				?>
				 <div class="content">
                    <?=$content?>
                 </div>
                </li>
	    </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='springsummer_list.php?page=<?=$page?>'">목록</button></li>
				<?php 
					if ($userlevel == 1) {
					// 레벨이 1인 경우, 모든 사용자에게 수정과 삭제 버튼을 표시
				?>
				<li><button onclick="location.href='springsummer_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='springsummer_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<?php
					} elseif ($userid == $id) {
					// 레벨이 1이 아니고, 로그인한 사용자의 ID와 글 작성자의 ID가 동일한 경우에만 수정과 삭제 버튼을 표시
				?>
				<li><button onclick="location.href='springsummer_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='springsummer_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<?php
						}
				?>
				<li><button onclick="location.href='springsummer_form.php'">글쓰기</button></li>
		</ul>
	</div> <!-- springsummer_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
