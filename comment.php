<?php
session_start();

// 필요한 데이터베이스 연결 정보와 설정을 추가하세요
$con = mysqli_connect("localhost", "user1", "12345", "sample");

// 사용자 입력 데이터 가져오기
$num = $_POST["num"];
$page = $_POST["page"];
$comment_content = $_POST["comment_content"];

// 데이터베이스에 댓글 저장하기
// INSERT 쿼리 실행 및 데이터 바인딩
$sql = "INSERT INTO communication_comments (parent_num, id, name, comment_content, comment_regist_day)
        VALUES ('$num', '{$_SESSION["userid"]}', '{$_SESSION["username"]}', '$comment_content', NOW())";
$result = mysqli_query($con, $sql);

if ($result) {
    // 댓글 저장 성공 시
    echo "<script>location.href='communication_view.php?num=$num&page=$page';</script>";
} else {
    // 댓글 저장 실패 시
    echo "<script>history.back();</script>";
}

mysqli_close($con);
?>