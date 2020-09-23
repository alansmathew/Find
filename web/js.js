var flag=true
var deg=0
function startanimation(){
    deg+=180;
    if(flag){
        document.getElementById("back_of_input").style.transform = "translate(-50%, -50%) rotateY("+deg+"deg)";
        flag=false
    }
    else if ( flag==false){
        document.getElementById("back_of_input").style.transform = "translate(-50%, -50%) rotateY("+deg+"deg)";
        flag=true
    }
}