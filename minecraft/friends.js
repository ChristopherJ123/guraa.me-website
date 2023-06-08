let top_tab_inactive = document.querySelector('.top-tab-inactive');
let top_tab_active = document.querySelector('.top-tab-active');
let friends_panel = document.querySelector('.friends-panel');
let add_panel = document.querySelector('.add-panel');


top_tab_inactive.addEventListener('click', ()=>{
    top_tab_inactive.classList.remove('top-tab-inactive');
    top_tab_active.classList.remove('top-tab-active');
    top_tab_inactive.classList.add('top-tab-active');
    top_tab_active.classList.add('top-tab-inactive');
    friends_panel.style.display = 'none';
    add_panel.style.display = 'flex';
})

top_tab_active.addEventListener('click', ()=>{
    top_tab_active.classList.remove('top-tab-inactive');
    top_tab_inactive.classList.remove('top-tab-active');
    top_tab_active.classList.add('top-tab-active');
    top_tab_inactive.classList.add('top-tab-inactive');
    friends_panel.style.display = 'flex';
    add_panel.style.display = 'none';
})

// Prevent submitting form
$('#friend-search-form').on('submit', function(event) {
    event.preventDefault();
})

function searchHint(value) {
    if (value.length == 0) {
        document.getElementById('search-output').innerHTML = "";
        document.getElementById('friends-output').style.display = "none";
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 & this.status == 200) {
                document.getElementById('search-output').innerHTML = this.responseText;
                document.getElementById('friends-output').style.display = "none";
            }
        }
        xmlhttp.open('GET', 'get_usernames.php?u=' + value, true);
        xmlhttp.send();
    }
}

function addFriend(username) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 & this.status == 200) {
            document.getElementById('search-warning-output').innerHTML = this.responseText;
            document.getElementById('search-warning-output').style.display = "flex";
        }
    }
    xmlhttp.open('GET', 'add_friend.php?u=' + username, true);
    xmlhttp.send();
}

function acceptFriend(username) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 & this.status == 200) {
            document.getElementById('friends-warning-output').innerHTML = this.responseText;
            document.getElementById('friends-warning-output').style.display = "flex";
            document.getElementById('pending-user-' + username).style.display = "none";
            function delay(time) {
                return new Promise(resolve => setTimeout(resolve, time));
            }
            delay(1000).then(() => location.reload());
        }
    }
    xmlhttp.open('GET', 'accept_friend.php?u=' + username, true);
    xmlhttp.send();
}
