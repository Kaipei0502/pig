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
	    <link rel="stylesheet" href="silder.css" type="text/css">
	    <link rel="stylesheet" href="add.css" type="text/css">
	    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	</head>

	<body>
		<?php   
	    	include("header.php");
	    ?>

	    <!-- 新增電影 -->

	    <div class="add_head">
	    	<h2 class="line1">新增電影</h2>
	    </div>

	    <hr>

	    <form action="add_movie_check.php" enctype="multipart/form-data" method="post">
	    	
	    	<div class="add">
	    		
	    		<div class="line1">
					<h4 class="label1">海報上傳：</h4>

					<div class="Input_frame1">
						<label for="file-upload" class="custom-file-upload" >
							<input type="file" id="file-upload" name="file"  onchange="showFileName(this)">
						</label>
					</div>
				</div>

				<!-- 電影名稱 -->
				<div class="line1">
					<h4 class="label1">電影名稱：</h4>
					<input type="text" name="Movie_name" class="Input_frame1" placeholder="請輸入電影名稱">
				</div>

				<!-- 片長 -->
				<div class="line1">
					<h4 class="label1">片長：</h4>
					<input type="text" name="Movie_long" class="Input_frame1" placeholder="片長(單位: 分鐘)">
				</div>

				<!-- 導演 -->
				<div class="line1">
					<h4 class="label1">導演：</h4>
					<input type="text" name="Movie_director" class="Input_frame1" placeholder="請輸入導演名稱">
				</div>

				<!-- 演員 -->
				<div class="line1">
					<h4 class="label1">演員：</h4>
					<input type="text" name="Movie_actor" class="Input_frame2" placeholder="請輸入演員名稱">
				</div>

				<!-- 電影介紹 -->
				<div class="line1">
					<h4 class="label1">電影介紹：</h4>
					<input type="text" name="Movie_description" class="Input_frame2" placeholder="請輸入電影介紹">
				</div>

				<!-- 租借價格 -->
				<div class="line1">
					<h4 class="label1">租借價格：</h4>
					<input type="text" name="Movie_price" class="Input_frame1" placeholder="請輸入租借價格(數字)">
				</div>

				<!-- 上傳數量 -->
				<div class="line1">
					<h4 class="label1">上傳數量：</h4>				
					<input type="text" name="Upload_num" class="Input_frame1" placeholder="請輸入上傳數量(數字)">	
					<!-- 上傳數量要用另一網頁的後台計算 -->
				</div>

				<!-- 分級 -->
				<div class="line1">
					<h4 class="label1">分級：</h4>
					<input type="radio" id="Movie_level" name="Movie_level" value="普遍級(0+)"><p class="label2">普遍級0+</p>
					<input type="radio" id="Movie_level" name="Movie_level" value="保護級(6+)"><p class="label2">保護級6+</p>
					<input type="radio" id="Movie_level" name="Movie_level" value="輔導級(12+)"><p class="label2">輔導級12+</p>
					<input type="radio" id="Movie_level" name="Movie_level" value="輔導級(15+)"><p class="label2">輔導級15+</p>
					<input type="radio" id="Movie_level" name="Movie_level" value="限制級(18+)"><p class="label2">限制級18+</p>
				</div>

				<!-- 電影分類 -->
				<div class="line1">
					<h4 class="label1">電影分類：</h4>
					<?php
					$SQL="SELECT * FROM type";
					$link = mysqli_connect('localhost','root','','movieplatform');
					if(@$result = mysqli_query($link, $SQL)){
						while($row = mysqli_fetch_assoc($result)){
							echo "<input type='checkbox' name='Type_id[]' value=".$row['Type_id']." class='Input_frame1'><p class='label3'>".$row['Type_name']."</p>";
						}
					}
					?>
				</div>

				<input type="submit" value="上傳">
			</div>

	    </form>
		

	</body>
</html>
