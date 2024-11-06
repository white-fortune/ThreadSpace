<?php

require dirname(__DIR__) . "\\vendor\\autoload.php";

use Ratchet\App;
use ChatApp\Chat;
use Ratchet\WebSocket\WsServer;

set_time_limit(0);
$app = new App('localhost', 9000);
$chatserver = new WsServer(new Chat);

$app->route('/chat', $chatserver, array("*"));
echo "Websocket server is listening on localhost:9000\n";
$app->run();
