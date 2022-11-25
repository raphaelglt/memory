let parameters = {
    letters : false,
    uppercase : false,
    count : false,
    numbers : false,
    special : false
};

let strengthBar = document.getElementById("strength-bar");

function strengthChecker(){
    const password = document.getElementById("newpassw1").value;

    /*parameters.letters = (/^(?=.*[a-z]){,8}$/.test(password))?true:false;
    parameters.uppercase = (/[A-Z]+/.test(password))?true:false;
    parameters.count = (password.length > 8)?true:false;
    parameters.numbers = (/[0-9]+/.test(password))?true:false;
    parameters.special = (/[!\"$%&/()=?@~`\\.\';:+=^*_-]+/.test(password))?true:false;*/

    const weak = document.getElementById("weak");
    const medium = document.getElementById("medium");
    const strong = document.getElementById("strong");

    var reg1 = /^([a-z]){0,8}$/gm;
    var reg2 = /^(?=.*[0-9])(?=.*[a-z])(?=(.*[A-Z]){1,}).{8,}$/gm;
    var reg3 = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=(.*[!@#$%^&*()\-_+.]){1,}).{8,}$/gm;

    //let barLength = Object.values(parameters).filter(value=>value);

    //console.log(Object.values(parameters), barLength);
    console.log(reg1.test(password));

    if(reg1.test(password)){
        weak.style.background = 'red';

    }else if(reg2.test(password)){
        weak.style.background = 'yellow';
        medium.style.background = 'yellow';

    }else if(reg3.test(password)){
        weak.style.background = 'green';
        medium.style.background = 'green';
        strong.style.background = 'green';

    }
}
/*
function strengthChecker(){

    const password = document.getElementById("newpassw1").value;

    parameters.uppercase = (/[A-Z]+/.test(password))?true:false;
    parameters.lowercase = (/[a-z]+/.test(password))?true:false;
    parameters.numbers = (/[0-9]+/.test(password))?true:false;
    parameters.special = (/[!\"$%&/()=?@~`\\.\';:+=^*_-]+/.test(password))?true:false;

    const weak = document.getElementById("weak");
    const medium = document.getElementById("medium");
    const strong = document.getElementById("strong");

    let barLength = Object.values(parameters).filter(value=>value);

    console.log(Object.values(parameters), barLength);

    if((parameters.lowercase).length<8 && parameters.uppercase==false && parameters.numbers==false && parameters.special==false){
        weak.style.background = 'red';
    }
    else if(parameters.uppercase==true && (parameters.lowercase).length>=8 &&  parameters.numbers==true && parameters.special==false){
        weak.style.background = 'yellow';
        medium.style.background = 'yellow';
    }
    else if(parameters.uppercase == true && (parameters.lowercase).length >= 8 && parameters.numbers == true && parameters.special == true){
        weak.style.background = 'green';
        medium.style.background = 'green';
        strong.style.background = 'green';
    }
}*/