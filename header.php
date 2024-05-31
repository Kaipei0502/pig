        <div class="headtitle">
            <!-- ***** Logo Start ***** -->
            <a href="index.php">
                <img class="logo" src="logo.png" alt="">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul>
                <li>
                    <!-- ***** Search Start ***** -->
                    <form id="search" action="search.php" method="get">
                        <i class=" fa fa-search"></i>
                        <input type="text" placeholder="搜尋" id='searchText' name="search" size="15">
                    </form>
                    <!-- ***** Search End ***** -->
                </li>
                <li><a href="index.php" class="active">首頁</a></li>
                <li><a href="collection.php">收藏</a></li>
                <?php
                @session_start();
                if(isset($_SESSION['login'])){//是否有登入
                    $user=$_SESSION['id'];
                    $sql="SELECT User_name FROM user WHERE User_id="."'$user'";
                    $link = mysqli_connect('localhost','root','','movieplatform');
                    if(@$result = mysqli_query($link, $sql)){
                        $user=mysqli_fetch_assoc($result);
                        echo "<li><a class='logined' href='information.php'>Hi,".$user['User_name']."</a></li>";
                    }
                }else{
                    echo "<li><a href='login.php'>登入</a></li>";
                }
                ?>
            </ul>
            <!-- ***** Menu End ***** -->   
        </div>
