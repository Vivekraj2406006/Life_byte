const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
})

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
}) 
const password1= document.querySelector("#password1");
const password2= document.querySelector("#password2");

var shbutton = document.querySelector(".shpass");
var shbutton1 = document.querySelector("#shpass1");
var shbutton2 = document.querySelector("#shpass2");



function shpassf1(){
    if(password1.type=="password" ){
        password1.type="text";
        shbutton1.textContent="Hide Password";
        shbutton2.textContent="Hide Password";

    }
    else{
        password1.type="password";
        shbutton1.textContent="Show Password";
        shbutton2.textContent="Show Password";

    }

}

function shpassf2(){
    if(password2.type=="password" ){
        password2.type="text";
        shbutton1.textContent="Hide Password";
        shbutton2.textContent="Hide Password";

    }
    else{
        password2.type="password";
        shbutton1.textContent="Show Password";
        shbutton2.textContent="Show Password";

    }

}