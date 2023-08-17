<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>Youth Is A Travel</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/autumnwinter.css">
<script>
  function check_input() {
      if (!document.autumnwinter_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.autumnwinter_form.subject.focus();
          return;
      }
      if (!document.autumnwinter_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.autumnwinter_form.content.focus();
          return;
      }
      document.autumnwinter_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section id="mainlist">
   	<div id="autumnwinter_box">
	    <h3 id="sprint_title">
	    		여행 후기를 남겨주세요!
		</h3>
	    <form  name="autumnwinter_form" method="post" action="autumnwinter_insert.php" enctype="multipart/form-data">
	    	 <ul id="autumnwinter_form">
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
	    		<li id="text_file">
			        <span class="col1"> 첨부 파일</span>
			        <span class="col2"><input type="file" name="upfile2"></span>
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">완료</button></li>
				<li><button type="button" onclick="location.href='autumnwinter_list.php'">목록</button></li>
			</ul>
	    </form>
	</div> <!-- autumnwinter_box -->
</section> 
<footer>
    	<?php include "footer.php";?>
    </footer>
</body>
</html>
