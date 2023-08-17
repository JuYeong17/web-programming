<?php
    session_start();
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
    else $userid = "";
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";
?>		
        <div id="top">
                <a href="index.php"><img src="./img/log.png" width=170 height=70></a>
            <ul id="top_menu">  
<?php
    if(!$userid) {
?>                
                <li><a href="member_form.php">회원가입</a> </li>
                <li> | </li>
                <li><a href="login_form.php">로그인</a></li>
<?php
    } else {
                $logged = $username."(".$userid.")님[Point:".$userpoint."]";
?>
                <li><?=$logged?> </li>
                <li> | </li>
                <li><a href="logout.php">로그아웃</a> </li>
                <li> | </li>
                <li><a href="member_modify_form.php">정보수정</a></li>
                <li> | </li>
                <li><a href="message_form.php">쪽지</a></li>
<?php
    }
?>
<?php
    if($userlevel==1) {
?>
                <li> | </li>
                <li><a href="admin.php">관리자모드</a></li>
<?php
    }
?>
            </ul>
        </div>
        <div id="menu_bar">
            <ul>  
                <li><a href="index.php">HOME</a></li>
                <li><a href="springsummer_list.php">봄/여름</a></li>                                
                <li><a href="autumnwinter_list.php">가을/겨울</a></li>
                <li><a href="communication_list.php">Communication</a></li>
                <li><a href="mynotice_list.php">My Notice</a></li>

            </ul>
        </div>