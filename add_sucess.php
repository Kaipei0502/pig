<?php
	session_start();
	if(@$_SESSION['login']!='yes'){
	    echo "<h1 class='noanswer'>請先登入，三秒後移動至登入畫面</h1>";
	    header('Refresh:3;url=login.php');
	}else if(@$_SESSION['level']==1){
	    echo "<h1 class='noanswer'>權限不足，三秒後離開</h1>";
	    header('Refresh:3;url=index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>新增電影</title>
	    <link rel="stylesheet" href="report.css" type="text/css">
	    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	</head>

	<body>
		<?php   
	    	include("header.php");
	    ?>

		<div class="add_head">
			<h1 class="line1">上傳成功!!!</h1>
		</div>

		<div class="line1">
			<hr>
			<br>
			<a href="./add_movie.php" class="Input_frame1">
				<h2 style="color: rgb(100,97,97);">新增電影</h2>
				</a><br>
			<a href="./add_movie_inventory.php" class="Input_frame1">
				<h2 style="color: rgb(100,97,97);">新增庫存</h2>
			</a><br>
			<a href="./index.php" class="Input_frame1">
				<h2 style="color: rgb(100,97,97);">回到首頁</h2>
			</a>
		</div>
	</body>
</html>