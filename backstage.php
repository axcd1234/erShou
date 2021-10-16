<?php
    header("Content-type:text/html;charset=utf-8");

    $responseData = array("code" => 0, "message" => "");

    $id = $_POST["id"];
    $num = $_POST["num"];

    $link = mysqli_connect("localhost", "root");

    if(!$link) {
        echo "连接数据库失败";
        $responseData["code"] = 4;
        $responseData["message"] = "数据库连接失败";
        echo json_encode($responseData);
        exit;
    }

    mysqli_set_charset($link, "utf8");

    mysqli_select_db($link, "data_table");

    $sql1 = "update cmi_table set num='{$num}' where id='{$id}'";

    $res1 = mysqli_query($link, $sql1);

    mysqli_close($link);
?>