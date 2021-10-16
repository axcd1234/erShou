function animate(obj, target, callback) {
    //先清除以前的定时器，只保留当前的一个定时器执行
    clearInterval(obj.timer);
    obj.timer = setInterval(function(){
        //使运动为缓冲
        var step = (target - obj.offsetLeft) / 10;
        // 解决到不了目标位置和回不到目标位置的问题
        step = step > 0 ? Math.ceil(step) : Math.floor(step);
        if(obj.offsetLeft == target){
            clearInterval(obj.timer);
            // 回调函数写到这里
            if(callback){
                callback();
            }
        }
        // 把每次加1这个步长值改为一个慢慢变小的值 。步长公式：（目标值 - 现在位置）/ 10
        obj.style.left = obj.offsetLeft + step + "px";
    }, 15);
}