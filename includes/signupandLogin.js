window.removeEventListener("resize", resizeHandler);
window.removeEventListener("load", loadHandler);

const signUpForm = document.querySelector("#signupForm");
let symbolPattern = /[\W_]/;
let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;



function displayX(inp)  {
    if(inp.indexOf("✓") !== -1) {
        inp = inp.replace("✓", "x");
    } else if (inp.indexOf("x") !== -1) {}
    else {
        inp += " x";
    }
    return inp;
}
function displayTick(inp) {
    if(inp.indexOf("x") !== -1) {
        inp = inp.replace("x", "✓");
    } else if (inp.indexOf("✓") !== -1) {}
    else  {
        inp += " ✓";
    }
    return inp;
}

function buttonCheck() {
    let button = document.querySelector("#submit");
    let divSpan = document.querySelector(".messages");
    let spans = divSpan.querySelectorAll("span");
  
    let tmp = 0;
    for (let i = 0; i < spans.length; i++) {
      let computedStyle = getComputedStyle(spans[i]);
      let color = computedStyle.color.toLowerCase(); // Convert the color to lowercase
  
      if (color === "rgb(0, 128, 0)" || color === "green") {
        tmp++;
      }
    }
  
    if (tmp === spans.length) {
      button.className = "activeBtn";
    } else {
      button.className = "inActiveBtn";
    }
  }
function validateName() {
    let name = signUpForm["name"].value.trim();
    let nameSpan = document.querySelector("#name");
    if(name == "" || symbolPattern.test(name)){
        nameSpan.style.color = "red";
        nameSpan.innerText = displayX(nameSpan.innerText);
        buttonCheck();
        return false;
    } else {
        nameSpan.style.color = "green";
        nameSpan.innerText = displayTick(nameSpan.innerText);
    }
    buttonCheck();
    return true;
}
function validateEmail() {
    let email = signUpForm["email"].value.trim();
    let emailSpan = document.querySelector("#email");
    if(email == "" || !emailPattern.test(email)){
        emailSpan.style.color = "red";
        emailSpan.innerText = displayX(emailSpan.innerText);
        buttonCheck();
        return false;
    } else {
        emailSpan.style.color = "green";
        emailSpan.innerText = displayTick(emailSpan.innerText);
    }
    buttonCheck();
    return true;
}
function validateUsername() {
    let username = signUpForm["uid"].value.trim();
    let usernameSpan = document.querySelector("#username");
    if(username == "" || symbolPattern.test(username)) {
        usernameSpan.style.color = "red";
        usernameSpan.innerText = displayX(usernameSpan.innerText);
        buttonCheck();
        return false;
    } else {
        usernameSpan.style.color = "green";
        usernameSpan.innerText = displayTick(usernameSpan.innerText);
    }
    buttonCheck();
    return true;
}

function validatePwd() {
    let pwd = signUpForm["pwd"].value.trim();
    let pwdSpan = document.querySelector("#pwd");
    if (pwd.length<8 || !/[A-Z]/.test(pwd) || !/[a-z]/.test(pwd) || !/[0-9]/.test(pwd)) {
        pwdSpan.style.color = "red";
        pwdSpan.innerText = displayX(pwdSpan.innerText);
        buttonCheck();
        return false;
    } else {
        pwdSpan.style.color = "green";
        pwdSpan.innerText = displayTick(pwd.innerText);
    }
    buttonCheck();
    return true;
}

function validatePwdRepeat() {
    let pwd = signUpForm["pwd"].value.trim();
    let pwdRepeat = signUpForm["pwdrepeat"].value.trim();
    let pwdRepeatSpan = document.querySelector("#pwdRepeat");
    
    if(pwd !== pwdRepeat || pwdRepeat == ""){
        pwdRepeatSpan.style.color = "red";
        pwdRepeatSpan.innerText = displayX(pwdRepeatSpan.innerText);
        buttonCheck();
        return false;
    } else {
        pwdRepeatSpan.style.color = "green";
        pwdRepeatSpan.innerText = displayTick(pwdRepeatSpan.innerText);
    }
    buttonCheck();
    return true;
}

function validateForm() {
    if(validateName() && validateEmail() && validateUsername() && validatePwd() && validatePwdRepeat()){
        return true;
    }
    alert("შეავსე ფორმა სწორად");
    return false;
}
