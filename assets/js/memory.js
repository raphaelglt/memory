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

const images = [];
const pairs = []
const state = {
    cards: [],
    canPlay: true,
    returnedCards: 0,
    lastCard: {},
};

[milliseconds,seconds,minutes,hours] = [0,0,0,0];

function onButton() {
    //prend la valeur de la difficulté (nombre de case) et le theme
    let difficultyValue = selectDifficulty.value;
    let themeValue = selectTheme.value;
    if (difficultyValue != "" && themeValue != "") {
        //requête ajax pour chercher les images
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let jsonResponse = JSON.parse(this.responseText);
                for (let elt of jsonResponse) {
                    images.push({
                        'url': elt['image_url'],
                        'alreadyUsed': false,
                    });
                }
                startGame();
            } else {
                console.log('Error')
                console.log("req : includes/get_theme_images.php?theme="+themeValue+"&size="+difficultyValue);
            }
        };
        xmlhttp.open("GET","includes/get_theme_images.php?theme="+themeValue+"&size="+difficultyValue,true);
        xmlhttp.responseType = "text";
        xmlhttp.send();
        
        generateTable(difficultyValue, themeValue)
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
    }
    const backs = document.querySelectorAll(".back-img");
    for (let i = 0; i < backs.length; i++) {
        console.log();
        backs[i].src = state.cards[i];
    }
}

function shuffleCards(array) {
    const copy = [...array];
    const result = []
    let i = (copy.length)*2;
    while (i > 0) {
        const cardIndex = Math.floor(Math.random() * copy.length); // 0 et la longueur du tableau (non-comprise)
        console.log('index :',cardIndex)
        const card = copy[cardIndex]['url'];
        result.push(card);
        if (copy[cardIndex]['alreadyUsed']) {
            console.log('delete')
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
        console.log('pair')
        prevElt.elt.setAttribute('unflippable', "");
        elt.setAttribute('unflippable', "");
        pairs.push(elt.lastChild.lastChild.src);
        return true;
    }
}


function generateTable(difficultyValue, themeValue) {
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

function updateTime(){
    //chronometre
    if (pairs.length === images.length) {
        paused = true;
        clearInterval(intervalId);
        const jsConfetti = new JSConfetti()

        function confettiFY() {
            jsConfetti.addConfetti({
                confettiColors: [
                    '#ff0a54', '#ff477e', '#ff7096', '#ff85a1', '#fbb1bd', '#f9bec7',
                ],
                confettiRadius: 6,
                confettiNumber: 500,
            })
        }
        confettiFY()
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
        let m = minutes < 10 ? "0" + minutes : minutes;
        let s = seconds < 10 ? "0" + seconds : seconds;
        let ms = milliseconds < 10 ? "0" + milliseconds : milliseconds;

        timer.textContent = `${m}:${s}:${ms}`;
    }    
}

//Mounir