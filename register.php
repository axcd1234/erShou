<?php
    header("Content-type:text/html;charset=utf-8");

    $responseData = array("code" => 0, "message" => "");

    $username = $_POST["username"];
    $password = $_POST["password"];
    $addTime = $_POST["addTime"];

    if(!$username) {
        $responseData["code"] = 1;
        $responseData["message"] = "用户名不能为空";
        echo json_encode($responseData);
        exit;
    }
    if(!$password) {
        $responseData["code"] = 2;
        $responseData["message"] = "密码不能为空";
        echo json_encode($responseData);
        exit;
    }

    $link = mysqli_connect("localhost", "root");

    if(!$link) {
        echo "连接数据库失败";
        $responseData["code"] = 3;
        $responseData["message"] = "数据库连接失败";
        echo json_encode($responseData);
        exit;
    }

    mysqli_set_charset($link, "utf8");

    mysqli_select_db($link, "data_table");

    if(mysqli_select_db($link, "data_table") == false){
        mysqli_query($link, "CREATE DATABASE data_table");
    }
    mysqli_select_db($link, "data_table");
    $sql2 = "create table users 
    (
    id int(10) not null auto_increment primary key,
    username varchar(30),
    password varchar(50),
    create_time bigint(20)
    )default charset=utf8";
    mysqli_query($link, $sql2);

    $pw = md5(md5(md5("aaa123")."xxx")."yyy");
    $sql3 = "insert into users values ('1','admin','{$pw}','0')";
    mysqli_query($link, $sql3);

    $sql = "select * from users where username='{$username}'";

    $res = mysqli_query($link, $sql);

    // 取出一行数据
    $row = mysqli_fetch_assoc($res);
    if($row){
        // 表示用户名重名
        $responseData["code"] = 4;
        $responseData["message"] = "用户名已存在";
        echo json_encode($responseData);
        exit;
    }

    $str = md5(md5(md5($password)."xxx")."yyy");

    // 不重复把数据插入数据库中
    $sql1 = "insert into users(username,password,create_time) values('{$username}','{$str}',{$addTime})";
    
    $res = mysqli_query($link, $sql1);
    if(!$res) {
        $responseData["code"] = 5;
        $responseData["message"] = "注册失败";
        echo json_encode($responseData);
    }else {
        $responseData["message"] = "注册成功";
        echo json_encode($responseData);
    }

    mysqli_close($link);
?>