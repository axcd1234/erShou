function $ajax({method = "get", url, data, success, error}){
    // 1、创建axjx对象
    var xhr = null;
    try{
        xhr = new XMLHttpRequest(); // IE8以下不兼容
    }catch(error){
        xhr = new ActiveXObject("Microsoft.XMLHTTP"); // 兼容IE8以下
    }

    if(data){
        data = querystring(data);
    }

    if(method == "get" && data){
        url += "?" + data;
    }
    // open方法：表示创建HTTP请求
    xhr.open(method, url, true);

    // send方法表示发送http请求给服务器
    if(method == "get"){
        xhr.send(); // GET方式，不需要填写参数
    }else {
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        xhr.send(data); // post方式需要把参数填上去
    }

    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                if(success){
                    success(xhr.responseText);
                }
            }else {
                if(error){
                    error("Error：" + xhr.status);
                }
            }
        }
    }
}

function querystring(obj){
    var str = "";
    for(var attr in obj){
        str += attr + "=" + obj[attr] + "&";
    }
    return str.substring(0, str.length - 1);
}