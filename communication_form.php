<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/communication.css">
<script>
  function check_input() {
      if (!document.communication_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.communication_form.subject.focus();
          return;
      }
      if (!document.communication_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.communication_form.content.focus();
          return;
      }
      document.communication_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section id="main">
   	<div id="communication_box">
	    <h3 id="communication_title">
	    		소통하기
		</h3>
	    <form  name="communication_form" method="post" action="communication_insert.php" enctype="multipart/form-data">
	    	 <ul id="communication_form">
				<li>
					<span class="col1">이름 : </span>
					<span class="col2"><?=$username?></span>
				</li>		
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"></textarea>
	    			</span>
	    		</li>
	    		<li>
			        <span class="col1"> 첨부 파일</span>
			        <span class="col2"><input type="file" name="upfile"></span>
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">완료</button></li>
				<li><button type="button" onclick="location.href='communication_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- communication_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
