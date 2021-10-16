function $cookie(name){
    switch(arguments.length){
        case 1:
            return getCookie(name);
            break;
        case 2:
            if(arguments[1] == null){
                removeCookie(name);
            }else{
                setCookie(name, arguments[1], {});
            }
            break;
        default:
            setCookie(name, arguments[1], arguments[2]);
            break;
    }
}

function setCookie(name, value, {expires, path, domain, secure}){
    var cookieStr = encodeURIComponent(name) + "=" + encodeURIComponent(value);
    if(expires){
        cookieStr += ";expires=" + afterOfDate(expires);
    }
    if(path){
        cookieStr += ";path" + path;
    }
    if(domain){
        cookieStr += ";domain" + domain;
    }
    if(secure){
        cookieStr += ";secure";
    }
    document.cookie = cookieStr;
}
function afterOfDate(n){
    var d = new Date();
    var day = d.getDate();
    d.setDate(n + day);
    return d;
}

function getCookie(name){
    var cookieStr = decodeURIComponent(document.cookie);
    var start = cookieStr.indexOf(name + "=");
    if(start == -1){
        return null;
    }else{
        var end = cookieStr.indexOf(";" + start);
        if(end == -1){
            end = cookieStr.length;
        }
        var str = cookieStr.substring(start, end);
        var arr = str.split("=");
        return arr[1];
    }
}

function removeCookie(name){
    document.cookie = encodeURIComponent(name) + "=;expires=" + new Date(0);
}