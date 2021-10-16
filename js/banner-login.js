window.onload = function(){
    var ul = document.getElementById("ul");
    var prev = document.getElementById("prev");
    var next = document.getElementById("next");
    var timer = null;

    ul.innerHTML += ul.innerHTML;
    timer = setInterval(function(){
        startMove(ul, {left: ul.offsetLeft - 391}, function(){
            if(ul.offsetLeft <= -ul.offsetWidth / 2){
                ul.style.left = "0px";
            }
        });
    }, 3000);

    next.onclick = function(){
        if(ul.offsetLeft <= -ul.offsetWidth / 2){
            ul.style.left = "0px";
        }else{
            startMove(ul, {left: ul.offsetLeft - 391});
        } 
    }
    next.onmousemove = function(){
        clearInterval(timer);
    }
    next.onmouseout = function(){
        timer = setInterval(function(){
            startMove(ul, {left: ul.offsetLeft - 391}, function(){
                if(ul.offsetLeft <= -ul.offsetWidth / 2){
                    ul.style.left = "0px";
                }
            });
        }, 3000);
    }

    // 登录后显示用户名
    var oDeng = document.getElementById("deng");
    var oZhu = document.getElementById("deng-after");
    var oQuit = document.getElementById("quit");
    var oUser = document.getElementById("user-name");

    var username = $cookie("username");
    if(username){
        oDeng.style.display = "none";
        oZhu.style.display = "block";
        oUser.innerHTML = username;
    }

    oQuit.onclick = function(){
        oDeng.style.display = "block";
        oZhu.style.display = "none";
        $cookie("username", null);
    }
}

function startMove(node, cssObj, complete){
    clearInterval(node.timer);
    node.timer = setInterval(function(){
        var isEnd = true; // 假设所有动画都到了目的值
        for(var attr in cssObj){
            var iTarget = cssObj[attr];
            //计算速度
            var iCur = null;
            if(attr == "opacity"){
                iCur = parseInt(parseFloat(getStyle(node, "opacity")) * 100);
            }else{
                iCur = parseInt(getStyle(node, attr));
            }

            var speed = (iTarget - iCur) / 8;
            speed = speed > 0 ? Math.ceil(speed) : Math.floor(speed);

            if(attr == "opacity"){
                iCur += speed;
                node.style.opacity = iCur / 100;
                node.style.opacity = "alpha(opacity=" + iCur + ")";
            }else{
                node.style[attr] = iCur + speed + "px";
            }

            if(iCur != iTarget){
                isEnd = false;
            }
        }

        if(isEnd){
            clearInterval(node.timer);
            if(complete){
                complete.call(node);
            }
        }
    }, 30);
}

//获取当前有效样式
function getStyle(node, cssStr){
    return node.currentStyle ? node.currentStyle[cssStr] : getComputedStyle(node)[cssStr];
}