var nam=false
var email=false
var password=false
var i = -1;
var p = -1; 
var txt = 'Your name is ';
var speed = 40;
var page="signin";


function typeWriter() {
    if (i < txt.length) {
        var data= document.createTextNode(txt.charAt(i));
        document.getElementsByClassName('typewriter')[0].appendChild(data);
        i++;
        setTimeout(typeWriter, speed);
    }
    else if(p==0){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("id", "name");
        x.setAttribute("onkeypress", "check_enter(event,'name','false')");
        x.setAttribute("onblur", "check_enter(event,'name','true')");
        x.setAttribute("onclick", "change_color('name')");
        document.getElementsByClassName('typewriter')[0].appendChild(x);
        document.getElementById('name').focus();
    }
    else if(p==1){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "text");
        x.setAttribute("id", "email");
        x.setAttribute("onkeypress", "check_enter(event,'email','false')");
        x.setAttribute("onblur", "check_enter(event,'email','true')");
        x.setAttribute("onclick", "change_color('email')");
        document.getElementsByClassName('typewriter')[0].appendChild(x);
        document.getElementById('email').focus();
    }
    else if(p==2){
        var x = document.createElement("INPUT");
        x.setAttribute("type", "password");
        x.setAttribute("id", "password");
        x.setAttribute("onkeypress", "check_enter(event,'password','false')");
        x.setAttribute("onblur", "check_enter(event,'password','true')");
        x.setAttribute("onclick", "change_color('password')");
        document.getElementsByClassName('typewriter')[0].appendChild(x);
        document.getElementById('password').focus();
    }
}

function check_enter(event,id,flag) {
    if (event.keyCode == 13 || flag=='true'){
        field=document.getElementById(id)
        var len = field.value.length;
        if(validate(id)){
            if(nam && password && email){
                document.getElementById('create_account').style.cssText="visibility:visible;opacity:1;";
            }
            field.style.cssText="transition: width 1s;width:"+len+"ch;border-bottom: solid 2px rgba(42, 42, 42, 0.467);";
            typeWriter();
        }
        else if (validate(id)==false){
            field.style.cssText="border-bottom: solid 2px rgb(236, 70, 70);";
        }
        else{
            if(nam && password && email){
                document.getElementById('create_account').style.cssText="visibility:visible;opacity:1;";
            }
            field.style.cssText="transition: width 1s;width:"+len+"ch;border-bottom: solid 2px rgba(42, 42, 42, 0.467);";
        }
    }    
}

function validate(id){
    if(id=='name'){
        document.getElementById('create_account').style.cssText="visibility:hidden;opacity:0;transition-delay: 0s;";
        patt=/^([a-zA-Z\. ]{2,})+$/;
        var value = document.getElementById(id).value ;
        if(value.trim()=="" || !value.match(patt)){ nam=false ; return false }
        else if (txt.length < 14){
            txt+=" and you would like to sign up with the email address ";
            i--;
            p++;
            nam=true
            return true ; 
        }
        else{nam=true}
    }
    if(id=='email'){
        document.getElementById('create_account').style.cssText="visibility:hidden;opacity:0;transition-delay: 0s;";
        patt=/^([A-Za-z0-9\.]{4,30})+@[a-z.]+\.+[a-z]+$/;
        var value = document.getElementById(id).value ;
        if(value.trim()=="" || !value.match(patt)){ email=false ;return false }
        else if (txt.length < 68){
            document.getElementsByClassName('typewriter')[0].appendChild(document.createElement("br"));
            document.getElementsByClassName('typewriter')[0].appendChild(document.createElement("br"));
            txt+="Create a strong password with a mix of some letter, symbol and numbers ";
            i--;
            p++;
            email=true
            return true ; 
        }
        else{email=true}
    }
    if(id=='password'){
        document.getElementById('create_account').style.cssText="visibility:hidden;opacity:0;transition-delay: 0s;";
        patt=/^(?=.*[!@#$%^&*(),.?":\[\]{}|<>\ ])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        var value = document.getElementById(id).value ;
        if(value.trim()=="" || !value.match(patt)){ password=false; return false }
        else if (txt.length < 140){
            document.getElementsByClassName('typewriter')[0].appendChild(document.createElement("br"))
            txt+="Great, you are all set.";
            i--;
            p++;
            password=true
            return true ; 
        }
        else{password=true;}
    }
}

function change_color(id){
    document.getElementById(id).style.cssText="border-bottom: solid 2px rgba(42, 42, 42, 0.767);"
}

function change_page(){
    if(page=='signin'){
        // sign up page 
        document.getElementById('a').innerHTML="Sign up";
        document.getElementById('b').innerHTML='Get started with few clicks and enjoy all our services for free all over the world.';
        document.getElementById('c').innerHTML='Have an account ?';
        document.getElementById('d').innerHTML='Sign in';
        document.getElementById('login_page').style.cssText='visibility:hidden; opacity: 0;';
        document.getElementById('reg_page').style.cssText='visibility:visible; opacity: 1;';
        
        p=0;
        i=0;
        nam=false
        email=false
        password=false

        txt = 'Your name is ';
        document.getElementsByClassName('typewriter')[0].innerHTML="";
        document.getElementById('create_account').style.cssText="visibility:hidden;opacity:0; transition-delay: 0s;"
        // document.getElementsByClassName('right_inside_conatiner')[1].removeChild(document.getElementsByClassName('typewriter')[0]);
        // alert('yes')
        // var div=document.createElement(div)
        // div.setAttribute('class','typewriter');
        // document.getElementsByClassName('right_inside_conatiner')[1].appendChild(div);
        
        page='signup';
        typeWriter();
    }
    else{
        // sign in page 
        document.getElementById('a').innerHTML="Sign in";
        document.getElementById('b').innerHTML='To keep connected with us, please login with your unique credentials. <br><br> If this device is not connected and you like to make it secure, register this device after Signing in.';
        document.getElementById('c').innerHTML='Not yet an user ?';
        document.getElementById('d').innerHTML='Sign up';
        document.getElementById('login_page').style.cssText='visibility:visible; opacity: 1;';
        document.getElementById('reg_page').style.cssText='visibility:hidden; opacity: 0;';
        page='signin';
        call();
    }
}