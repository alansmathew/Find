{/* <form id="phppage" action="hereGoesThePhp"> <!-- here enter the php -->
    <input Required type="text" name="" id="fullname" placeholder="Fullname" onblur="full_name(this.id)">
    <input Required type="email" name="" id="email" placeholder="Email" onblur="email_id(this.id)">
    <input type="text" name="" id="phone" placeholder="Phone number" onblur="phone_no(this.id)">
    <input Required type="password" name="" id="password" placeholder="Password" onblur="pass(this.id)">
    <input Required type="password" name="" id="con_password" placeholder="Confirm Password" onblur="con_pass(this.id)">
    <button onclick="val('phppage')">Submit</button> <!-- should be button and onclick form id  -->
</form> */}


// search and delete field not necessory 

var name_val=false;
var email=false;
var passw=false;
var con_passw=false;
var ph=false;



// dont change this !!!! 
var passone_field;

function full_name(id){
    elem=document.getElementById(id);
    patt=/^([a-zA-Z\. ]{3,})+$/;
    if(elem.value.trim()=="" || !elem.value.match(patt))
    {   
        name_val=false;
        elem.value="";
        elem.placeholder="invalid name";
        elem.style.cssText="border: 1px solid red";
    }
    else{
        name_val=true;
        elem.style.cssText="border:none";
    }
}


function email_id(id){
    elem=document.getElementById(id);
    patt=/^([A-Za-z0-9\.]{4,30})+@[a-z.]+\.+[a-z]+$/;
    if(elem.value.trim()=="" || !elem.value.match(patt))
    {   
        email=false;
        elem.value="";
        elem.placeholder="invalid email";
        elem.style.cssText="border: 1px solid red";
    }
    else{
        email=true;
        elem.style.cssText="border:none";
    }
}


function pass(id){
    elem=document.getElementById(id);
    passone_field=elem;
    patt=/^(?=.*[!@#$%^&*(),.?":{}|<>\ ])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if(elem.value.trim()=="" || !elem.value.match(patt))
    {   
        passw=false;
        elem.value="";
        elem.placeholder="ex: !Abcdef8";
        elem.style.cssText="border: 1px solid red";
    }
    else{
        passw=true;
        elem.style.cssText="border:none";
    }
} 
function con_pass(id){
    try{
        elem=document.getElementById(id);
        if(elem.value.trim()=="" || elem.value != passone_field.value)
        {
            con_passw=false;
            elem.value="";
            elem.placeholder="No match";
            elem.style.cssText="border: 1px solid red";
        }
        else{
            con_passw=true;
            elem.style.cssText="border:none";
        }
    }
    catch{
        alert("Enter password field first");
        con_passw=false;
        elem.value="";
    } 
}

function phone_no(id){ 
    elem=document.getElementById(id);
    patt=/^([6-9]{1})+([0-9]{9})$/;
    if(elem.value.trim()=="" || !elem.value.match(patt))
    {   
        ph=false;
        elem.value="";
        elem.placeholder="invalid number";
        elem.style.cssText="border: 1px solid red";
    }
    else{
        ph=true;
        elem.style.cssText="border:none";
    }
}

function val(id){
    if(name_val && email && passw && con_passw &&ph){
        document.getElementById(id).submit;
    }
}
