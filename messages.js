function selectDirectChat(username) {
    document.querySelector('.chat-text-area').id = 'direct';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 & this.status == 200) {
            let response = this.responseText;
            let responseArray = response.split(",")
            if (responseArray[1] == null) {
                responseArray[1] = '';
            }
            document.getElementById('chat-user').innerHTML = responseArray[0];
            document.getElementById('chat-output').innerHTML = responseArray[1];
        }
    }
    xmlhttp.open('POST', 'scripts/get_direct_chat.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send('u=' + username);
}

function selectServerChat(name) {
    document.querySelector('.chat-text-area').id = 'server';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 & this.status == 200) {
            document.getElementById('chat-user').innerHTML = name;
            document.getElementById('chat-output').innerHTML = this.responseText;
        }
    }
    xmlhttp.open('POST', 'scripts/get_server_chat.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send('s=' + name);
}

// Prevent submitting form
// IMPORTANT NOTE: Fungsi dibawah ini cuma menselect 1 element Id SAAT load page
// TODO: Perlu test: pake $('.chat-text-box-form') yaitu class agar bisa lebih dari 1 element
$('#chat-text-box-form').on('submit', function(event) {
    event.preventDefault();
    let type = document.querySelector('.chat-text-area').id;
    let message = document.getElementById('chat-input').value;
    let username = document.getElementById('chat-user').innerText;
    if (message.length > 0) {
        document.getElementById('chat-input').value = '';

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 & this.status == 200) {
                // TODO: Real time chatting
                // console.log(this.responseText);
                location.reload();
            }
        }
        if (type == 'server') {
            xmlhttp.open('POST', 'scripts/send_server_chat.php', true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send('msg=' + message);
        } else if (type == 'direct') {
            xmlhttp.open('POST', 'scripts/send_direct_chat.php', true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send('u=' + username + '&' + 'msg=' + message);
        }
    }
})