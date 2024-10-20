<?php
function sessionAuthMiddleware($res) {
    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if(isset($_SESSION['ID_USER'])) {
        $res->user = new stdClass();
        $res->user->id = $_SESSION['ID_USER'];
        $res->user->email = $_SESSION['EMAIL_USER'];
    }
}
?>
