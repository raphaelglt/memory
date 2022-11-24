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
let chatBody = document.querySelector('#chat-body');
loadMessage();
setInterval(loadMessage, 5000)

function loadMessage() {
    fetch('../../includes/loadMessage.php')
        .then((response) => {
            if (response.status) return response.json();
        })
        .then((json) => {
                if (json['messages'] && json['messages'].length>0) {
                    json['messages'].forEach(message =>  addelement(message, json['user_id']))
                } else {
                    showNoMessage();
                }    
                chatBody.scrollTop = chatBody.scrollHeight
            }

        );
        function showNoMessage() {
            const messageContainer = document.createElement('div');
            messageContainer.classList.add('no-message-container')

            const messageContent = document.createElement('p');
            messageContent.classList.add('no-message-text')
            messageContent.innerText = "Aucun messages ces dernières 24 heures";

            messageContainer.appendChild(messageContent)
            chatBody.appendChild(messageContainer)

        }    
    function addelement(message, user_id){
        if (user_id == message['message_user_id']) {
            const Divmessage = document.createElement("div");
            Divmessage.classList.add("my-message")

            const messageContent = document.createElement("div");
            messageContent.classList.add("message")

            //<img src="assets/images/elgato.jpeg" alt="Bot profil picture" id="bot-img-body" />


            const messageDetail = document.createElement(`p`);
            messageDetail.classList.add("message-detail");

            const messageValue = document.createElement("p");
            messageValue.classList.add("message-content")
            messageValue.classList.add("my-text")

            const messagedate = document.createElement("p");
            messagedate.classList.add("message-detail")

            messageDetail.textContent = "Moi";
            messageValue.textContent = message['message_value'];
            messagedate.textContent = message['message_datetime'];


            Divmessage.appendChild(messageContent)
            messageContent.appendChild(messageDetail);
            messageContent.appendChild(messageValue);
            messageContent.appendChild(messagedate);
            chatBody.appendChild(Divmessage)
        } else {
            const Divmessage = document.createElement("div");
            Divmessage.classList.add("bot-message")

            const messageImage = document.createElement("img");
            messageImage.setAttribute('src', "assets/images/elgato.jpeg")
            messageImage.setAttribute('alt', "Bot profil picture")
            messageImage.setAttribute('id', "bot-img-body")

            const messageContent = document.createElement("div");
            messageContent.classList.add("message")

            const messageDetail = document.createElement(`p`);
            messageDetail.classList.add("message-detail");

            const messageValue = document.createElement("p");
            messageValue.classList.add("message-content")
            messageValue.classList.add("bot-text")

            const messagedate = document.createElement("p");
            messagedate.classList.add("message-detail")

            messageDetail.textContent = message['user_pseudo'];
            messageValue.textContent = message['message_value'];
            messagedate.textContent = message['message_datetime'];

            messageContent.appendChild(messageDetail);
            messageContent.appendChild(messageValue);
            messageContent.appendChild(messagedate);
            Divmessage.appendChild(messageImage);
            Divmessage.appendChild(messageContent);
            chatBody.appendChild(Divmessage)
        }
        
    }
}


document.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
        sendMessage();
    }
});

let input = document.querySelector('#input')

function sendMessage() {
    if (input.value.length > 3) {
        const data = {
            input: input.value
        }
        fetch('includes/send_message.php', {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams(data)
        })
        .then((response) => {
            return response.text()
        })
        .then((text) => {
            loadMessage()
            input.value = "";
        })
    }    
}