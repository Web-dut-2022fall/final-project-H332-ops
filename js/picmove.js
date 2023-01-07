//获取所有元素
            let slider = document.querySelector(".slider")
            let lis = document.querySelectorAll(".slider li");
            let spanBtns = document.querySelectorAll(".btn span");
            let previous = document.querySelector(".previous");
            let next = document.querySelector(".next");
            let pic = document.querySelector(".pic");
            //设置元素的索引值 全局索引
            var index = 0;
            //图片数组的长度  4
            let len = lis.length - 1 ;
            //设置初始pic长度.
            pic.style.width = (len + 2)*parseInt(getStyle(lis[0],"width"))+ "px";
            //设置定时器
            let timer = null;
            // 圆形按钮点击事件 使用的是let变量,即不会发生先循环完毕,再执行事件
            for(let j = 0 ; j < len ; j++)
            {
                //spanBtns就是存圆形按钮元素的数组.  index是全局的一个值,用来作为索引值.
                spanBtns[j].onclick = function(){
                    index = j; 
                    //这里使用了一个封装的移动函数. 
                    //第一个参数值是需要改变的元素,第二个是属性
                    //第三个是步长. 第四个是目标位置. 第五个参数是回调函数.
                    move(pic,"left",20,-index*lis[0].offsetWidth,function(){
                        setBtn();
                    });
                }
            }
            function setBtn(){
                if(index >= len)
                {
                    index = 0;
                    pic.style.left = 0;
                }
                for(var i = 0 ; i < len ; i++)
                {
                    spanBtns[i].className = "";
                }
                spanBtns[index].className = "bg";
            }
            //onNext
            function Next(){
                index ++;
                if(index > len)
                {
                    index = 0;
                }
                //                   - 移动单张图片的宽度 * index   回调函数
                move(pic,"left",20,-index * lis[0].offsetWidth,setBtn);
            }
            function Pre(){
                //全局的索引值 减1 
                index --;
                if(index < 0 )
                {
                    index = len - 1;
                    pic.style.left = -len * lis[0].offsetWidth + "px";
                    
                }
                //没有使用回调函数 是为了做一个返回去的效果.
                move(pic,"left",20,-index * lis[0].offsetWidth);
                //按钮背景跟随
                setBtn();
            }
            //绑定点击事件
            previous.onclick = Pre;
            next.onclick = Next;
            
            slider.onmouseover = function(){
                clearInterval(timer);
            }
            slider.onmouseout = function(){
                autoPlay();
            }
            //自动轮播
            function autoPlay(){
                timer = setInterval(function(){
                    Next();
                },3000);
            }
            setBtn();
            autoPlay();
/*
    封装move函数
    
    ele 要传递的元素
    
    attr 属性 --- 字符串
    
    speed  速度  正负值
    
    target 目标值（结束位置）
    
    callback 回调函数 --- 当这个函数执行完毕后，再去调用它
*/
function move(ele, attr, speed, target, callback){
   //获取当前的位置
   //从左往右进行移动 --- current<target speed
   //从右往左进行移动 --- current>target -speed
   var current = parseInt(getStyle(ele, attr));
   //   810 > 800
   if(current>target){
       speed = -speed;
   }
   
   //定时器累加问题 --- 先清除再开启
   clearInterval(ele.timer);

   ele.timer = setInterval(function(){
       //获取元素的现在位置
       var begin = parseInt(getStyle(ele, attr));
       //步长
       var step = begin + speed;
       
       //判断当step>800, 让step = 800
       //从左往右进行移动 --- speed>0 正值
       //从右往左进行移动 --- speed<0 负值
       //   -10              0            10           超过800直接变成  800
       if(speed<0 && step<target || speed>0 && step>target){
           step = target;
       }
       
       //赋值元素
       ele.style[attr] = step + "px";
       
       //让元素到达目标值时停止 800px
       if(step == target){
           clearInterval(ele.timer);
           //当move函数执行完毕后, 就执行它了
           //当条件都满足时才执行callback回调函数
           callback && callback();
       }

   },30)
}

//获取元素的方式 --- 注意点:如果在IE浏览器下, 要指定默认的值, 如果不指定获取的是auto
function getStyle(obj, name){
   if(window.getComputedStyle){
       return getComputedStyle(obj, null)[name];
   }else{
       return obj.currentStyle[name];
   }
}