let selectContainer = document.querySelector('#select-container');
let selectDifficulty = document.querySelector('#select-difficulty');
let selectTheme = document.querySelector('#select-theme');
let table = document.querySelector('#table');
let error = document.querySelector('#error-message');

let timer = document.querySelector('#timer');
let startTime = 0;
let elapsedTime = 0;
let currentTime = 0;
let paused = true;

[milliseconds,seconds,minutes,hours] = [0,0,0,0];

function onButton() {
    let difficultyValue = selectDifficulty.value;
    let themeValue = selectTheme.value;
    if (difficultyValue != "" && themeValue != "") {
        let elt = "";
        for (let x = 0; x<difficultyValue; x++) {
            elt += '<div class="row">';
            for (let y = 0; y<difficultyValue; y++) {
                elt += '<div class="cell"></div>';
            }
            elt += '</div>';
        }
        table.innerHTML = elt;
        selectContainer.style.display = "none";
        table.style.display = "block";

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let jsonResponse = JSON.parse(this.responseText);
                //console.log(jsonResponse);
                for (let elt of jsonResponse) {
                    console.log(elt['image_url']);
                }
            } else {
                console.log('Error')
                console.log("req : includes/get_theme_images.php?theme="+themeValue+"&size="+difficultyValue);
            }
        };
        xmlhttp.open("GET","includes/get_theme_images.php?theme="+themeValue+"&size="+difficultyValue,true);
        xmlhttp.responseType = "text";
        xmlhttp.send();

        if(paused){
            paused = false;
            startTime = Date.now() - elapsedTime;
            intervalId = setInterval(updateTime, 100);
        }
    } else {
        error.innerText = 'Veuillez renseigner les deux champs';
    }    
}

function updateTime(){
    milliseconds+=10;
    if(milliseconds == 100){
        milliseconds = 0;
        seconds++;
        if(seconds == 60){
            seconds = 0;
            minutes++;
        }
    }
    let m = minutes < 10 ? "0" + minutes : minutes;
    let s = seconds < 10 ? "0" + seconds : seconds;
    let ms = milliseconds < 10 ? "0" + milliseconds : milliseconds;
    // elapsedTime = Date.now() - startTime;
    // millisecs = Math.floor(elapsedTime % 100)
    // secs = Math.floor((elapsedTime / 1000) % 60);
    // mins = Math.floor((elapsedTime / (1000 * 60)) % 60);

    // millisecs = pad(millisecs);
    // secs = pad(secs);
    // mins = pad(mins);

    timer.textContent = `${m}:${s}:${ms}`;

    function pad(unit){
        return (("0") + unit).length > 2 ? unit : "0" + unit;
    }
}

//Mounir