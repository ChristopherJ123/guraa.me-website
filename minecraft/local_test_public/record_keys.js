document.addEventListener('keypress', (e) => {
    var key = e.key;
    var code = e.code;  

    // document.querySelector('.key').innerText += key;
})

function keyPressed(value) {
    document.querySelector('.key').innerText += value;

    if (value.length == 0) {
        document.getElementById('search-output').innerHTML = "";
        document.getElementById('search-warning-output').style.display = "none";
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 & this.status == 200) {
                document.getElementById('search-output').innerHTML = this.responseText;
                document.getElementById('search-warning-output').style.display = "none";
            }
        }
        xmlhttp.open('GET', 'xmlhttp.php?i=' + value, true);
        xmlhttp.send();
    }

}

// Selain keypress ada keydown dan keyup
// keydown = dipencet lebih lama
// keyup = key dilepas dari keyboard
