<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/autumnwinter.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section id="mainlist">
    <div class="container">
	    <h3 class="heading">
            가을 풍경, 겨울 이야기
		</h3>
<div class="box-container">
<?php
	if (isset($_GET["page"]))
		$page = $_GET["page"];
	else
		$page = 1;

	$con = mysqli_connect("localhost", "user1", "12345", "sample");
	$sql = "select * from autumnwinter order by hit desc, num desc";
	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 6;

	// 전체 페이지 수($total_page) 계산 
	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      

	$number = $total_record - $start;

   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)
   {
      mysqli_data_seek($result, $i);
      // 가져올 레코드로 위치(포인터) 이동
      $row = mysqli_fetch_array($result);
  
      // 하나의 레코드 가져오기
	  $num         = $row["num"];
	  $id          = $row["id"];
	  $name        = $row["name"];
	  $subject     = $row["subject"];
      $regist_day  = $row["regist_day"];
      $hit         = $row["hit"];
      $file_copied  = $row["file_copied"];

?>
      <div class="box">
         <?php
         if (!empty($file_copied)) {
            $real_name = $file_copied;
            $file_path = "./data/".$real_name;
            echo '<img src="' . $file_path . '" alt="이미지">';
        } else {
            echo '<img src="./img/Nophoto.png" alt="대체 이미지">';
        }
        ?>
          <a href="autumnwinter_view.php?num=<?=$num?>&page=<?=$page?>"><?=$subject?></a>
          <span><?=$name?></span>
          <span><?=$regist_day?></span>
          <span class="hit"><?=$hit?></span>
      </div>

<?php
   	   $number--;
   }
   mysqli_close($con);

?>
</div>
</div>

			<ul id="page_num"> 	
<?php
	if ($total_page>=2 && $page >= 2)	
	{
		$new_page = $page-1;
		echo "<li><a href='autumnwinter_list.php?page=$new_page'>◀ 이전</a> </li>";
	}		
	else 
		echo "<li>&nbsp;</li>";

   	// 게시판 목록 하단에 페이지 링크 번호 출력
   	for ($i=1; $i<=$total_page; $i++)
   	{
		if ($page == $i)     // 현재 페이지 번호 링크 안함
		{
			echo "<li><b> $i </b></li>";
		}
		else
		{
			echo "<li><a href='autumnwinter_list.php?page=$i'> $i </a><li>";
		}
   	}
   	if ($total_page>=2 && $page != $total_page)		
   	{
		$new_page = $page+1;	
		echo "<li> <a href='autumnwinter_list.php?page=$new_page'>다음 ▶</a> </li>";
	}
	else 
		echo "<li>&nbsp;</li>";
?>
			</ul> <!-- page -->	    	
			<ul class="viewbuttons">
				<li><button onclick="location.href='autumnwinter_list.php'">목록</button></li>
				<li>
<?php 
    if($userid) {
?>
					<button onclick="location.href='autumnwinter_form.php'">글쓰기</button>
<?php
	} else {
?>
					<a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
<?php
	}
?>
				</li>
			</ul>
	<!-- </div> autumnwinter_box -->
</section> 
<footer>
    	<?php include "footer.php";?>
    </footer>

</body>
</html>
