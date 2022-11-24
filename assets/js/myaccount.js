let parameters = {
    letters : false,
    count : false,
    numbers : false,
    special : false
};

let strengthBar = document.getElementById("strength-bar");

function strengthChecker(){
    const password = document.getElementById("newpassw1").value;


    parameters.uppercase = (/[A-Z]+/.test(password))?true:false;
    parameters.lowercase = (/[a-z]+/.test(password))?true:false;
    //parameters.count = (password.length > 8)?true:false;
    parameters.numbers = (/[0-9]+/.test(password))?true:false;
    parameters.special = (/[!\"$%&/()=?@~`\\.\';:+=^*_-]+/.test(password))?true:false;

    const weak = document.getElementById("weak");
    const medium = document.getElementById("medium");
    const strong = document.getElementById("strong");

    if((parameters.lowercase < 8) && (parameters.uppercase == false) && (parameters.numbers == false) && (parameters.special == false)){
        weak.style.background = 'red';

    }
    if((parameters.uppercase == true) && (parameters.lowercase >= 8) && (parameters.numbers == true) && (parameters.special == false)){
        weak.style.background = 'yellow';
        medium.style.background = 'yellow';

    }
    if(parameters.uppercase == true && parameters.lowercase >= 8 && parameters.numbers == true && parameters.special == true){
        weak.style.background = 'green';
        medium.style.background = 'green';
        strong.style.background = 'green';
    }
}

  