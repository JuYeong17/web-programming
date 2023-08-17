<meta charset="utf-8">
<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";

    if ( !$userid )
    {
        echo("
                    <script>
                    alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }

    $subject = $_POST["subject"];
    $content = $_POST["content"];

	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$upload_dir = './data/';

	$upfile2_name	 = $_FILES["upfile2"]["name"];
	$upfile2_tmp_name = $_FILES["upfile2"]["tmp_name"];
	$upfile2_type     = $_FILES["upfile2"]["type"];
	$upfile2_size     = $_FILES["upfile2"]["size"];
	$upfile2_error    = $_FILES["upfile2"]["error"];
   
  
	if ($upfile2_name && !$upfile2_error)
	{
		$file2 = explode(".", $upfile2_name);
		$file2_name = $file2[0];
		$file2_ext  = $file2[1];

		$new_file2_name = date("Y_m_d_H_i_s");
		$new_file2_name = $new_file2_name;
		$copied_file2_name = $new_file2_name.".".$file2_ext;      
		$uploaded_file2 = $upload_dir.$copied_file2_name;
        

		if( $upfile2_size  > 5000000 ) {
				echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다! 파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
				");
				exit;
		}

		if (!move_uploaded_file($upfile2_tmp_name, $uploaded_file2) )
		{
				echo("
					<script>
					alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
					history.go(-1)
					</script>
				");
				exit;
		}
	}
	else 
	{
		$upfile2_name      = "";
		$upfile2_type      = "";
		$copied_file2_name = "";
	}
	
	$con = mysqli_connect("localhost", "user1", "12345", "sample");

	$sql = "insert into autumnwinter (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
	$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
	$sql .= "'$upfile2_name', '$upfile2_type', '$copied_file2_name')";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행

	// 포인트 부여하기
  	$point_up = 10;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;
	
	$sql = "update members set point=$new_point where id='$userid'";
	mysqli_query($con, $sql);
    $_SESSION["userpoint"] = $new_point;
	mysqli_close($con);                // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'autumnwinter_list.php';
	   </script>
	";
?>

  
