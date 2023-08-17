<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    $num   = $_GET["num"];
    $page   = $_GET["page"];

    $con = mysqli_connect("localhost", "user1", "12345", "sample");
    $sql = "select * from communication where num = $num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];

	if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
		unlink($file_path);
    }

    $sql = "delete from communication where num = $num";
    mysqli_query($con, $sql);
    $point_up = 5;

    $sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] - $point_up;
    $sql = "update members set point=$new_point where id='$userid'";

	mysqli_query($con, $sql);
    $_SESSION["userpoint"] = $new_point;

    mysqli_close($con);


    echo "
	     <script>
	         location.href = 'communication_list.php?page=$page';
	     </script>
	   ";
?>

