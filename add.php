<?php 
        
      if($_POST['names']){
            $host="localhost";
            $user = "root";
            $password = "11111";
            $dbname = "test";
             $id = mysqli_connect($host,$user,$password,$dbname);
             mysqli_query($id,"set names utf-8");
             mysqli_select_db($id,$dbname);
             $names = $_POST["names"];
             $qq = $_POST["qq"];
             $email = $_POST["email"];
             $messages = $_POST["messages"];
             $sql = "insert into message(names,qq,email,messages) values('$names','$qq','$email','$messages')";
             mysqli_query($id,$sql);
 
             if($result = mysqli_query($id,"select * from message;")){//查询数据库中users中所有内容，并将结果存在$result中
                 
                 if($row = mysqli_fetch_array($result)){//获取内容存在数组中
                    echo "";
					echo "<script language='javascript'>";
					echo "alert('留言成功，我们会尽快回复~感谢您的留言！即将返回主页！');";
					echo "window.location.href='main.html';";
					echo "</script>"; 
                }
 
             }else{
                 echo "添加失败";
             }
        }
         
     ?>