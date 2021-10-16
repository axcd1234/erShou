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

    $sq6 = "create table cmi_table 
    (
    id int(10) not null auto_increment primary key,
    name varchar(60),
    price float(50),
    num float(50),
    sum float(50),
    profit float(50)
    )default charset=utf8";

    mysqli_query($link, $sql2);
    mysqli_query($link, $sq6);

    $sq7 = "insert into cmi_table values
    ('', '迷你风扇', '30', '10', '300', '30'), 
    ('', '短袖', '89', '10', '890', '89'),
    ('', '短裤', '49', '10', '490', '49'),
    ('', '华为荣耀9x', '999', '10', '9990', '999'),
    ('', '老北京布鞋', '9.9', '10', '99', '9.9'),
    ('', '枕头', '29', '10', '290', '29'),
    ('', '猪肉脯', '24', '10', '240', '24'),
    ('', '华为Freebuds4i', '479', '10', '4790', '479'),
    ('', '荣耀V20手机壳', '20', '10', '20', '20'),
    ('', '折叠伞', '50', '10', '500', '50'),
    ('', '毛巾', '10', '10', '100', '10'),
    ('', '荣耀V20手机', '1399', '10', '13990', '1399')";
    mysqli_query($link, $sq7);

    $pw = md5(md5(md5("aaa123")."xxx")."yyy");
    $sql3 = "insert into users values ('1','admin','{$pw}','0')";
    mysqli_query($link, $sql3);

    $str = md5(md5(md5($password)."xxx")."yyy");

    $sql = "select * from users where username='{$username}' and password='{$str}'";
    $sql1 = "select username from users where username='admin'";
    $sql2 = "select password from users where username='admin'";

    $res = mysqli_query($link, $sql);
    $res1 = mysqli_query($link, $sql1);
    $res2 = mysqli_query($link, $sql2);

    // 取出一行数据
    $row = mysqli_fetch_assoc($res);
    $row1 = mysqli_fetch_assoc($res1);
    $row2 = mysqli_fetch_assoc($res2);
    foreach($row1 as $k => $v){
        $aa = $v;
    }
    foreach($row2 as $k => $v){
        $bb = $v;
    }
    if($username == $aa && $str == $bb){
        $responseData["code"] = 6;
        $responseData["message"] = "管理员登录成功";
        echo json_encode($responseData);
        exit;
    }

    if(!$row){
        $responseData["code"] = 4;
        $responseData["message"] = "用户名或密码错误";
        echo json_encode($responseData);
        exit;
    }else{
        $responseData["code"] = 5;
        $responseData["message"] = "登录成功";
        echo json_encode($responseData);
    }

    mysqli_close($link);
?>