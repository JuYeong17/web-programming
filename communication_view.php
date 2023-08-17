<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/communication.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<?php
    if (!$userid)
    {
        echo("<script>
                alert('로그인 후 이용할 수 있습니다!');
                history.go(-1);
                </script>
            ");
        exit;
    }
?>
<section id="mainlist">
	<div id="main_img_bar">
    </div>
   	<div id="communication_box">
	    <h3 class="title">
			Communication
		</h3>
<?php
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
	
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from communication where num=$num";
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

	$hit_session_name = $num."c_hit";
	$logged_in_user = isset($_SESSION["id"]) ? $_SESSION["id"] : null; 
	if (!isset($_SESSION[$hit_session_name]) && $logged_in_user !== $id) {
		$new_hit = $hit + 1;
		$sql = "update communication set hit=$new_hit where num=$num";  
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
			           	}
				?>
				<?=$content?>
			</li>		
	    </ul>
		<form method="POST" action="comment.php">
    	<input type="hidden" name="num" value="<?=$num?>">
    	<input type="hidden" name="page" value="<?=$page?>">
    	<textarea name="comment_content" placeholder="댓글을 작성해주세요"></textarea>
    	<button type="submit">댓글 작성</button>
		</form>
	<?php
	// 한 페이지에 표시할 댓글 수
	$commentsPerPage = 5;

	// 현재 페이지 번호 가져오기
	if (isset($_GET['page'])) {
    	$currentPage = $_GET['page'];
	} else {
    	$currentPage = 1;
	}

	// 댓글 총 개수 가져오기
	$sqlCount = "SELECT COUNT(*) AS total FROM communication_comments WHERE parent_num=$num";
	$resultCount = mysqli_query($con, $sqlCount);
	$rowCount = mysqli_fetch_assoc($resultCount);
	$totalComments = $rowCount['total'];


	// 페이지 수 계산	
	$totalPages = ceil($totalComments / $commentsPerPage);

	// 현재 페이지에 해당하는 댓글 가져오기
	$start = ($currentPage - 1) * $commentsPerPage;
	$sql = "SELECT * FROM communication_comments WHERE parent_num=$num ORDER BY comment_regist_day DESC LIMIT $start, $commentsPerPage";
	$result = mysqli_query($con, $sql);
	$comment_count = mysqli_num_rows($result);

	if (isset($_GET['delete_comment'])) {
		$delete_comment_id = $_GET['delete_comment'];
		
		// 해당 댓글이 존재하는지 확인
		$check_sql = "SELECT * FROM communication_comments WHERE id='$delete_comment_id' AND parent_num=$num";
		$check_result = mysqli_query($con, $check_sql);
		
		if (mysqli_num_rows($check_result) > 0) {
			// 댓글 삭제 쿼리 실행
			$delete_sql = "DELETE FROM communication_comments WHERE id='$delete_comment_id' AND parent_num=$num";
			$delete_result = mysqli_query($con, $delete_sql);
			
			if ($delete_result) {
				echo "<script>location.href='communication_view.php?num=$num&page=$page';</script>";
			} else {
				// 댓글 삭제 실패 시
				echo "<script>history.back();</script>";
			}
		}
	}
	
	if ($comment_count > 0) {
	echo '<div class="comments-container">';
	while ($row = mysqli_fetch_array($result)) {
    	$comment_id = $row["id"];
    	$comment_name = $row["name"];
    	$comment_regist_day = $row["comment_regist_day"];
    	$comment_content = $row["comment_content"];

    	// 댓글 내용을 HTML로 표시
    	echo '<div class="comment">';
    	echo '<p class="comment-name"><strong>'.$comment_name.'</strong></p>';
    	echo '<span class="comment-content">'.$comment_content.'</span>';
    	echo '<span class="comment-date">'.$comment_regist_day.'</span>';
		if ($userlevel == 1) {
			echo '<a href="communication_view.php?num='.$num.'&page='.$page.'&delete_comment='.$comment_id.'" class="comment-delete">삭제</a>';
		}
		elseif ($_SESSION["userid"] === $comment_id) {
			echo '<a href="communication_view.php?num='.$num.'&page='.$page.'&delete_comment='.$comment_id.'" class="comment-delete">삭제</a>';
		}

    	echo '</div>';
	}
}

	else{
		echo '<div class="comments-container2">';
}


	// 이전 페이지와 다음 페이지 링크 표시
	if ($totalPages > 1) {
    	echo '<div class="pagination">';
    	if ($currentPage > 1) {
        	$prevPage = $currentPage - 1;
        	echo '<a href="communication_view.php?num='.$num.'&page='.$prevPage.'">◀ 이전</a>';
			
    	}
    	if ($currentPage < $totalPages) {
        	$nextPage = $currentPage + 1;
        	echo '<a href="communication_view.php?num='.$num.'&page='.$nextPage.'"> 다음 ▶</a>';
    	}
    	echo '</div>';
	}
	echo '</div>';

	?>

	    <ul class="buttons">
				<li><button onclick="location.href='communication_list.php?page=<?=$page?>'">목록</button></li>
				<?php 
					if ($userlevel == 1) {
					// 레벨이 1인 경우, 모든 사용자에게 수정과 삭제 버튼을 표시
				?>
				<li><button onclick="location.href='communication_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='communication_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<?php
					} elseif ($userid == $id) {
					// 레벨이 1이 아니고, 로그인한 사용자의 ID와 글 작성자의 ID가 동일한 경우에만 수정과 삭제 버튼을 표시
				?>
				<li><button onclick="location.href='communication_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='communication_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<?php
						}
				?>
				<li><button onclick="location.href='communication_form.php'">글쓰기</button></li>
		</ul>
	</div> <!-- communication_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
