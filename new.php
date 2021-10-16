<?php
    header("Content-type:text/html;charset=utf-8");

    $responseData = array("code" => 0, "message" => "");

    $new1 = $_POST["new1"];
    $new2 = $_POST["new2"];
    $new3 = $_POST["new3"];
    $new4 = $_POST["new4"];
    $sum = $new3 * $new4;
    $profit = $sum * 0.1;

    if(!$new1){
        $responseData["code"] = 1;
        $responseData["message"] = "商品ID不能为空";
        echo json_encode($responseData);
        exit;
    }
    if(!$new2){
        $responseData["code"] = 2;
        $responseData["message"] = "商品名称不能为空";
        echo json_encode($responseData);
        exit;
    }
    if(!$new3){
        $responseData["code"] = 3;
        $responseData["message"] = "商品单价不能为空";
        echo json_encode($responseData);
        exit;
    }
    if(!$new4){
        $responseData["code"] = 4
        $responseData["message"] = "商品数量不能为空";
        echo json_encode($responseData);
        exit;
    }

    $link = mysqli_connect("localhost", "root");

    if(!$link) {
        echo "连接数据库失败";
        $responseData["code"] = 5;
        $responseData["message"] = "数据库连接失败";
        echo json_encode($responseData);
        exit;
    }

    mysqli_set_charset($link, "utf8");

    mysqli_select_db($link, "data_table");

    $sql = "insert into cmi_table values('{$new1}', '{$new2}', '{$new3}', '{$new4}', '{$sum}', '{$profit}')";

    mysqli_query($link, $sql);

    mysqli_close($link);
?>