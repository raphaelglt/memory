let difficultySelect = document.querySelector('#select-difficulty');
let playerSelect = document.querySelector('#select-player');
let gameSelect = document.querySelector('#select-game');
let tbodyElt = document.querySelector('tbody');

let difficultyParam;
let playerParam;
let gameParam;

difficultySelect.addEventListener('click', (event)=>{
    if (difficultySelect.value) {
        difficultyParam = difficultySelect.value;
    } else {
        difficultyParam = null;
    }
    sendParam()
})

getAllScores()

playerSelect.addEventListener('click', (event)=>{
    if (playerSelect.value) {
        playerParam = playerSelect.value;
    } else {
        playerParam = null;
    }
    sendParam()
})

gameSelect.addEventListener('click', (event)=>{
    if (gameSelect.value) {
        gameParam = gameSelect.value;
    } else {
        gameParam = null;
    }
    sendParam()
})

function getAllScores() {
    fetch('includes/get_all_scores.php')
    .then((response) => {
        if (response.status = 200) return response.json()
    })
    .then((json) => {
        loadScores(json.scores);
    })
}

function sendParam() {
    if (difficultyParam || playerParam || gameParam) {
        let requestParams = 'WHERE ';
        if (difficultyParam) {
            requestParams += `score_level = '${difficultyParam}' AND `;
        }
        if (playerParam) {
            requestParams += `score_user_id = '${playerParam}' AND `;
        }
        if (gameParam) {
            requestParams += `score_game_id = '${gameParam}' AND `;
        }
        requestParams = requestParams.substring(0, requestParams.length - 5);
        const data = {
            requestParams
        }
        fetch('includes/filter_score.php', {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            method: 'POST',
            body: new URLSearchParams(data)
        })
        .then((response) => {
            if (response.status = 200) return response.json()
        })
        .then((json) => {
            loadScores(json.scores);
        })
    } else {
        getAllScores()
    }    
}

function loadScores(scores) {
    tbodyElt.innerHTML = "";
    scores.forEach(score => {
        let tr = document.createElement('tr');

        let tdLinkContent = document.createElement('td');
        let tdLink = document.createElement('a');
        tdLink.setAttribute('href', 'memory.php');
        tdLink.classList.add('memory-link');
        tdLink.innerText = score['game_name'];
        tdLinkContent.appendChild(tdLink);
        tr.appendChild(tdLinkContent);

        let tdUserContent = document.createElement('td');
        tdUserContent.innerText = score['user_pseudo'];
        tr.appendChild(tdUserContent);

        let tdLevelContent = document.createElement('td');
        tdLevelContent.innerText = score['score_level'];
        tr.appendChild(tdLevelContent);

        let tdStopWatchContent = document.createElement('td');
        tdStopWatchContent.innerText = score['score_stopwatch'];
        tr.appendChild(tdStopWatchContent);

        let tdDatetimeContent = document.createElement('td');
        tdDatetimeContent.innerText = score['score_datetime'];
        tr.appendChild(tdDatetimeContent);

        tbodyElt.append(tr)
    });
}