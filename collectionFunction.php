<?php
    @session_start();
    if(isset($_POST['movieid'])){
        $movieid = $_POST['movieid'];
        $userid=$_SESSION['id'];//使用者id
        $TF=$_POST['TF'];
        $link = mysqli_connect('localhost','root','','movieplatform');
        if($TF=='true'){//有紀錄，移除
            removecollection($movieid,$userid,$link);
        }else{//沒紀錄，增加
            addcollection($movieid,$userid,$link);
        }    
    }
    function addcollection($movieid,$userid,$link){
        $sql="INSERT INTO collection(Movie_id,User_id) VALUES($movieid,$userid)";     
        mysqli_query($link, $sql);
    }
    
    function removecollection($movieid,$userid,$link){
        $sql="DELETE FROM collection WHERE Movie_id=$movieid && User_id=$userid";
        mysqli_query($link, $sql);
    }
?> 