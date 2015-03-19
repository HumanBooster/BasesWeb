<?php

// gestion des messages
function addMessage($code, $type, $lib) {
    $_SESSION['messages'][] = array("code" => $code, "type" => $type, "lib" => $lib);
}

function addMessageRedirect($code, $type, $lib, $url = "index.php") {
    addMessage($code, $type, $lib);
    header("Location: " . $url);
    exit();
}

function showMessages() {
    if (isset($_SESSION['messages'])) {
        // on affiche un bloc pour chaque message
        foreach ($_SESSION['messages'] as $msg) {
            echo '<p class="message-' . $msg['type'] . '">[' . $msg['code'] . '] ' . $msg['lib'] . "</p>\n";
        }

        // du coup on peut supprimer les messages
        unset($_SESSION['messages']);
    }
}

// mise en forme
// système, include dans une variable
function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    return false;
}
