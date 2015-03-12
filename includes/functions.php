<?php

// gestion des messages
function addMessage($code, $type, $lib) {
	$_SESSION['messages'][] = array("code"=>$code, "type" => $type, "lib" => $lib);
}

function showMessages() {
    if (isset($_SESSION['messages'])) {
        // on affiche un bloc pour chaque message
        foreach ($_SESSION['messages'] as $msg) {
            echo '<p class="message-'.$msg['type'].'">['.$msg['code'].'] '.$msg['lib']. "</p>\n";
        }

        // du coup on peut supprimer les messages
        unset($_SESSION['messages']);
        
    }
}