let difficultySelect = document.querySelector('#select-difficulty');
let playerSelect = document.querySelector('#select-player');
let gameSelect = document.querySelector('#select-game');

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


function sendParam() {
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
        if (response.status = 200) return response.text()
    })
    .then((json) => {
        console.log(json[0])
    })
}
