// Scroll element into view
let anchor = document.getElementById('anchor');
anchor.scrollIntoView();

// Unused
// function selectDirectChat(username) {
//     document.querySelector('.chat-text-area').id = 'direct';

//     var xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 & this.status == 200) {
//             let response = this.responseText;
//             let responseArray = response.split(",")
//             if (responseArray[1] == null) {
//                 responseArray[1] = '';
//             }
//             document.getElementById('chat-user').innerHTML = responseArray[0];
//             document.getElementById('chat-output').innerHTML = responseArray[1];
//         }
//     }
//     xmlhttp.open('POST', 'scripts/get_direct_chat.php', true);
//     xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//     xmlhttp.send('u=' + username);
// }

// function selectServerChat(name) {
//     document.querySelector('.chat-text-area').id = 'server';

//     var xmlhttp = new XMLHttpRequest();
//     xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 & this.status == 200) {
//             document.getElementById('chat-user').innerHTML = name;
//             document.getElementById('chat-output').innerHTML = this.responseText;
//         }
//     }
//     xmlhttp.open('POST', 'scripts/get_server_chat.php', true);
//     xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
//     xmlhttp.send('s=' + name);
// }

// Prevent submitting form
// IMPORTANT NOTE: Fungsi dibawah ini cuma men-select 1 element Id SAAT load page
// TODO: Perlu test: pake $('.chat-text-box-form') yaitu class agar bisa lebih dari 1 element
$('#chat-text-box-form').on('submit', function(event) {
    event.preventDefault();
    let type = document.querySelector('.chat-text-area').id;
    let message = document.getElementById('chat-input').value;
    let name = document.getElementById('chat-user').innerText;
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
            xmlhttp.send('s=' + name + '&' + 'msg=' + message);
        } else if (type == 'direct') {
            xmlhttp.open('POST', 'scripts/send_direct_chat.php', true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send('u=' + name + '&' + 'msg=' + message);
        }
    }
})

$('#server-name').on('submit', function(event) {
    event.preventDefault();
    let name = document.getElementById('new-server-name').value;
    if (name.length > 0) {
        document.getElementById('chat-input').value = '';

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 & this.status == 200) {
                // TODO: Real time chatting
                // console.log(this.responseText);
                document.getElementById('output').innerHTML = this.responseText
                function delay(time) {
                    return new Promise(resolve => setTimeout(resolve, time));
                }
                delay(1000).then(() => location.reload());
            }
        }
        xmlhttp.open('POST', 'scripts/create_server_chat.php', true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send('s=' + name);

    }
})

function formOpen() {
    document.querySelector('.new-server-chat').style = "display:none;";
    document.querySelector('.new-server-name').style = "display:flex;";
}

function formClose() {
    document.querySelector('.new-server-chat').style = "display:flex; margin-top:10px; font-size:22px; cursor:pointer;";
    document.querySelector('.new-server-name').style = "display:none;";
}

function redirect(link) {
    location.href = "chat.php" + link;
}