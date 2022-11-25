//prend tous les élémenyts du dom nécessaire
let selectContainer = document.querySelector('#select-container');
let selectDifficulty = document.querySelector('#select-difficulty');
let selectTheme = document.querySelector('#select-theme');
let table = document.querySelector('#table');
let error = document.querySelector('#error-message');
let pageContainer = document.querySelector('#page-container');
let popUp = document.querySelector('#pop-up');
let result = document.querySelector('#result');

//pour enlever la pop-up quand elle sera activée
pageContainer.addEventListener('click', () => {
    popUp.style.display = 'none';
    pageContainer.style.opacity = "1";
})

//options du timer
let timer = document.querySelector('#timer');
let startTime = 0;
let elapsedTime = 0;
let currentTime = 0;
let paused = true;

//minutes secondes et millisecondes
let m;
let s;
let ms;

[milliseconds,seconds,minutes,hours] = [0,0,0,0];

//données pour le tableau
const images = [];
const pairs = []
const state = {
    cards: [],
    canPlay: true,
    returnedCards: 0,
    lastCard: {},
};

//handle le click pour start le jeu
function onButton() {
    //prend la valeur de la difficulté (nombre de case) et le theme
    let difficultyValue = selectDifficulty.value;
    let themeValue = selectTheme.value;
    if (difficultyValue != "" && themeValue != "") {
        //requête ajax pour chercher les images
        fetch("includes/get_theme_images.php?theme="+themeValue+"&size="+difficultyValue)
            .then((response) => {
                if (response.status == 200) return response.json();
            })
            .then((json) => {
                console.log(json);
                if (json['images']) {
                    for (let elt of json['images']) {
                        images.push({
                            'url': elt['image_url'],
                            'alreadyUsed': false,
                        });
                    }
                    startGame();
                } else {
                    console.log(json['error'])
                }
            })
                
        //génère la table puis commence le timer
        generateTable(difficultyValue)
        startTimer()
    } else {
        error.innerText = 'Veuillez renseigner les deux champs';
    }    
}


function startGame() {
    state.cards = shuffleCards(images);
    const cards = document.querySelectorAll(".cell");
    for (let i = 0; i < cards.length; i++) {
        cards[i].addEventListener("click", () => handleCardClick(i, cards[i]));
        cards[i].lastChild.lastChild.src = state.cards[i];
    }
}

function shuffleCards(array) {
    const copy = [...array];
    const result = []
    let i = (copy.length)*2;
    while (i > 0) {
        const cardIndex = Math.floor(Math.random() * copy.length); // 0 et la longueur du tableau (non-comprise)
        const card = copy[cardIndex]['url'];
        result.push(card);
        if (copy[cardIndex]['alreadyUsed']) {
            copy.splice(cardIndex, 1)[0];
        } else {
            copy[cardIndex]['alreadyUsed'] = true;
        }
        i--;
    }
    return result;
}

function handleCardClick(index, elt) {
    if (state.canPlay && !isUnflippable(elt)) {
        state.canPlay = false;
        elt.classList.toggle('flipCard');
        isUnflippable(elt)
        setTimeout(()=>handleFlip(index, elt), 1250)
    }
}

function handleFlip(index, elt) {
    state.returnedCards++;
    if (state.returnedCards >= 2) {
        if (!isPair(state.lastCard, elt)) {
            elt.classList.remove('flipCard');
            state.lastCard.elt.classList.remove('flipCard');
        }
        state.returnedCards = 0;
    } 
    state.canPlay=true
    state.lastCard.elt = elt;
    state.lastCard.index = index;
}

function isUnflippable(elt) {
    if (elt.hasAttribute('unflippable')) return true;
}

/**
 * 
 * @param {Element} prevElt 
 * @param {Element} elt 
 * @returns {boolean}
 * check si les deux element sont paires
 */
function isPair(prevElt, elt) {
    if (prevElt.elt.lastChild.lastChild.src === elt.lastChild.lastChild.src) {
        prevElt.elt.setAttribute('unflippable', "");
        elt.setAttribute('unflippable', "");
        pairs.push(elt.lastChild.lastChild.src);
        return true;
    }
}

/**
 * 
 * @param {Text} difficultyValue 
 * créer la table a partir de la difficulté
 */

function generateTable(difficultyValue) {
    //créé les cases
    for (let x = 0; x<difficultyValue; x++) {
        let rowDiv = document.createElement('div');
        rowDiv.className = "row";
        for (let y = 0; y<difficultyValue; y++) {
            let cellDiv = document.createElement('div');
            cellDiv.className = "cell";
            rowDiv.appendChild(cellDiv);

            let frontDiv = document.createElement('div');
            frontDiv.className = "front";
            cellDiv.appendChild(frontDiv);

            let backDiv = document.createElement('div');
            backDiv.className = "back";
            let backImg = document.createElement('img');
            backImg.className = "back-img";
            backDiv.appendChild(backImg);
            cellDiv.appendChild(backDiv);
        }
        table.appendChild(rowDiv);
    }

    //cache le select pour display le tableau
    selectContainer.style.display = "none";
    table.style.display = "block";
}

function startTimer() {
    if(paused){
        paused = false;
        startTime = Date.now() - elapsedTime;
        intervalId = setInterval(updateTime, 100);
    }
}

function endGameAnimation() {
    popUp.style.display = 'block';
    pageContainer.style.opacity = "0.33";
}

function updateTime(){
    //chronometre
    if ((pairs.length === images.length) && pairs.length>0) {
        paused = true;
        clearInterval(intervalId);
        result.innerText = `Vous avez fini le memory en ${m} min ${s} secs et ${ms} ms`;
        const jsConfetti = new JSConfetti()

        function confettiFY() {
            jsConfetti.addConfetti({
                confettiColors: [
                    '#ff0a54', '#ff477e', '#ff7096', '#ff85a1', '#fbb1bd', '#f9bec7',
                ],
                confettiRadius: 6,
                confettiNumber: 500,
            })
            setTimeout(endGameAnimation, 2000);
        }
        confettiFY()
        let level;
        switch(selectDifficulty.value) {
            case "2":
                level = "easy";
                break;
            case "4":
                level = "medium";
                break;
            case "10":
                level = "hard";
                break;
            case "20":
                level = "impossible";
                break;
            default:
                level = "unknown";
                break
        }
        const data = {
            level,
            value: 23,
            stopwatch: `${m}:${s}:${ms}`
        }
        fetch('includes/send_score.php', {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            method: 'POST',
            body: new URLSearchParams(data)
        })
        .then((response) => {
            return response.text()
        })
        .then((text) => {
            console.log(text)
        })
    }
    if (!paused) {
        milliseconds+=10;
        if(milliseconds == 100){
            milliseconds = 0;
            seconds++;
            if(seconds == 60){
                seconds = 0;
                minutes++;
            }
        }
        m = minutes < 10 ? "0" + minutes : minutes;
        s = seconds < 10 ? "0" + seconds : seconds;
        ms = milliseconds < 10 ? "0" + milliseconds : milliseconds;

        timer.textContent = `${m}:${s}:${ms}`;
    }    
}

let chatBody = document.querySelector('#chat-body');
loadMessage();
setInterval(loadMessage, 5000)

function loadMessage() {
    fetch('includes/loadMessage.php')
        .then((response) => {
            if (response.status) return response.json();
        })
        .then((json) => {
            console.log(json)
                if (json['messages'] && json['messages'].length>0) {
                    chatBody.innerHTML = "";
                    json['messages'].forEach(message =>  addelement(message, json['user_id']))
                } else {
                    showNoMessage();
                }    
                chatBody.scrollTop = chatBody.scrollHeight
            }

        );    
}

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