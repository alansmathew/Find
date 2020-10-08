var flag=true
function startanimation(temp){
    if(flag && temp=='next'){
        document.getElementById("back_of_input").style.transform = " rotateY(180deg)";
        document.getElementsByClassName("click_button")[1].style.width = "109px";
        document.getElementsByClassName("click_button")[0].style.display = "inline";
        document.getElementsByClassName("click_button")[0].style.width = "107px";
        flag=false
    }
    else if (flag==false && temp =='back'){
        document.getElementById("back_of_input").style.transform = " rotateY(0deg)";
        document.getElementsByClassName("click_button")[1].style.width = "220px";
        document.getElementsByClassName("click_button")[0].style.display = "none";
        flag=true
    }
}

// var balls = document.getElementsByClassName("ball");
// document.onmousemove = function(){
//   var x = event.clientX * 100 / window.innerWidth + "%";
//   var y = event.clientY * 100 / window.innerHeight + "%";

//   for(var i=0;i<2;i++){
//     balls[i].style.left = x;
//     balls[i].style.top = y;
//     balls[i].style.transform = "translate(-"+x+",-"+y+")";
//   }
// }

// beer animation 
// document.querySelector('body').addEventListener('mousemove',eyeball);
// function eyeball(){

// }
 
// location animi 
function call(){
  st=true
  function strech(){
      if (st){
          document.getElementsByClassName('img')[0].style.cssText="transform-style: preserve-3d;transform: translate(-50%,-10%) rotateY(20deg);"
          st=false;
      }
      else{
          document.getElementsByClassName('img')[0].style.cssText="transform-style: preserve-3d;transform: translate(-50%,-10%) rotateY(0deg);"
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
    var total_increment = input.value.length * increment

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
