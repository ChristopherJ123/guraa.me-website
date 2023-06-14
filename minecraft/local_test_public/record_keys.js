document.addEventListener('keypress', (e) => {
    var key = e.key;
    var code = e.code;  

    document.querySelector('.key').innerText += key;
})

function keyPressed(key) {
    document.querySelector('.key').innerText += key;
}

// Selain keypress ada keydown dan keyup
// keydown = dipencet lebih lama
// keyup = key dilepas dari keyboard
