<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/login.css">
<script type="text/javascript" src="./js/login.js"></script>
</head>
<body> 
	<header>
    	<?php include "header.php";?>
    </header>
	<section id="main">
        <div id="main_content">
      		<div id="login_box">
	    		<div id="login_title">
		    		<span>로그인</span>
	    		</div>
	    		<div id="login_form">
          		<form  name="login_form" method="post" action="login.php">		       	
                  	<ul>
                    <li><input type="text" name="id" placeholder="  아이디" ></li>
                    <li><input type="password" id="pass" name="pass" placeholder="  비밀번호" ></li> <!-- pass -->
                  	</ul>
                  	<div id="login_btn">
                      <button class="button" type="button" onclick="check_input()">Log In</button>
                  	</div>		       	
           		</form>
        		</div> <!-- login_form -->
                <div class="links" style="text-align: center;">
                        아직 회원이 아니신가요? <a href="member_form.php">회원가입</a>
                </div> 
    		</div> <!-- login_box -->
        </div> <!-- main_content -->
	</section> 
	<footer>
    	<?php include "footer.php";?>
    </footer>
</body>
</html>

