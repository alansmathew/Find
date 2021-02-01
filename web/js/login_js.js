var flag=true;
var b="nill";
var b2="nill";
var em=false;

function rem(id){
    document.getElementById('err').style.cssText='visibility:hidden';
    if(b=="red"){
        em=false;
        document.getElementById(id).style.cssText="border:none";
    }
}

function startanimation(temp){
    // if(document.getElementById('view1').value.trim()!="" &&flag && temp=='next'){

    if(document.getElementById('view1').value.trim()!="" &&flag && temp=='next'){
        document.getElementById("back_of_input").style.transform = "rotateY(180deg)";
        document.getElementsByClassName("click_button")[1].style.width = "109px";
        document.getElementsByClassName("click_button")[0].style.display = "inline";
        document.getElementsByClassName("click_button")[0].style.width = "107px";
        document.getElementsByClassName("click_button")[1].innerHTML="Login";

        document.getElementById("lefthand").style.cssText="visibility:visable;"
        document.getElementById("righthand").style.cssText="visibility:visable;"

        flag=false;
        
    }
    else if (flag==false && temp =='back'){
        document.getElementById('err').style.cssText='visibility:hidden';
        
        document.getElementById("back_of_input").style.transform = " rotateY(0deg)";
        document.getElementsByClassName("click_button")[1].style.width = "220px";
        document.getElementsByClassName("click_button")[0].style.display = "none";
        flag=true

        document.getElementsByClassName("click_button")[1].innerHTML="Next";
        document.getElementById("lefthand").style.cssText="visibility:hidden;";
        document.getElementById("righthand").style.cssText="visibility:hidden;";

        document.getElementsByClassName('ball')[0].style.cssText="visibility:visable;"
        document.getElementsByClassName('ball')[1].style.cssText="visibility:visable;"
    }
    else if(document.getElementById('view2').value.trim()==""){
        document.getElementById('view2').style.cssText="border:solid red .5px;";
        b2="red";
    }

    if(document.getElementById('view1').value.trim()==""){
        document.getElementById('view1').style.cssText="border:solid red .5px;";
        b="red";
    }
    if( document.getElementById('view2').value.trim()!="" && document.getElementById('view1').value.trim()!=""){
        document.getElementById('em').value = document.getElementById('view1').value;
        document.getElementById('pass').value = document.getElementById('view2').value;
        document.getElementById('lo').submit();
    }
}
function isMobile(){
    var match = window.matchMedia || window.msMatchMedia;
    if(match) {
        var mq = match("(pointer:coarse)");
        return mq.matches;
    }
    return false;
}

function call(){
    el= document.getElementById("mob");
    var type=isMobile();
    if (type!=false){
        el.click();
    }

  st=true
  function strech(){
      if (st){
          document.getElementsByClassName('img')[0].style.cssText="transform: translate(-50%,-10%) rotateY(20deg);"
          st=false;
      }
      else{
          document.getElementsByClassName('img')[0].style.cssText="transform: translate(-50%,-10%) rotateY(0deg);"
          st=true;
      }
      setTimeout(strech,5000);
  }
  strech();
}

var balls = document.getElementsByClassName("ball");
document.onmousemove = function()
{
  var x = event.clientX * 100 / window.innerWidth + "%";
  var y = event.clientY * 100 / window.innerHeight + "%";
  for(var i=0;i<2;i++)
  {
      balls[i].style.left = x;
      balls[i].style.top = y;
      balls[i].style.transform = "translate(-"+x+",-"+y+")";
  }
}

function eye_move(id){
    var input = document.getElementById(id);
    var increment = 100/30;
    var total_increment = input.value.length * increment;

    if (event.keyCode == 13) {
        event.preventDefault();
    }

    if(total_increment <= 100){
        var x= total_increment + "%";
        var y= 85 +'%';
        for(var i=0;i<2;i++)
      {
          balls[i].style.left = x;
          balls[i].style.top = y;
          balls[i].style.transform = "translate(-"+x+",-"+y+")";
      }
    }
}

function eyes(){
    document.getElementById("lefthand").style.cssText="visibility:visible;"
    document.getElementById("righthand").style.cssText="visibility:visible;"
    document.getElementsByClassName('ball')[0].style.cssText="visibility:hidden;"
    document.getElementsByClassName('ball')[1].style.cssText="visibility:hidden;"
    if(b2=="red"){
        document.getElementById("view2").style.cssText="border:none";
    }
    
}