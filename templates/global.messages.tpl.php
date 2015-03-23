<div id="messages">
    <?php
            // on affiche un bloc pour chaque message
            foreach ($messages as $msg) {
                echo '<p class="message-' . $msg['type'] . '">[' . $msg['code'] . '] ' . $msg['lib'] . "</p>\n";
            }
    ?>
</div>