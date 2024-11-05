<?php

require __DIR__ . "\\vendor\\autoload.php";

use Ratchet\App;
use ChatApp\Chat;

$app = new App('localhost', 9000);
$app->route('/chat', new Chat, array("*"));
echo "Websocket server is listening on localhost:9000\n";
$app->run();
