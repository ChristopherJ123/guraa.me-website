let first_time = 'true';

(async function ping () {
    // Alternatif pake fetch() tapi itu mending buat application/JSON
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open('POST', 'scripts/update_users_online_status_id.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send('condition=' + first_time);

    first_time = 'false';
    setTimeout( ping, 60_000 );
}());