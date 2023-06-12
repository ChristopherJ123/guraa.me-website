(async function ping () {
    // Asynchronously call x.php
    await fetch( "scripts/update_users_online_status_id.php" );
    // Issue this call again in 60 seconds
    setTimeout( ping, 60_000 );
}());