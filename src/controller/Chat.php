<?php

namespace ChatApp;

include(__DIR__ . "/db.php");

use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $rooms;

    public function __construct()
    {
        $this->clients = new SplObjectStorage();
        $this->rooms = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $id = spl_object_id($conn);
        // print_r("New connection id [{$id}]\n");
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            $command = explode(":", $msg);
            switch($command[0]) {
                case "NEWUSER":
                    $roomname = $command[1];
                    $displayname = $command[2];
                    $thread = getThread($roomname);
    
                    switch($thread["state"]) {
                        case "public":
                            $this->addToRoom($roomname, $from);
                            // print_r("Room [{$roomname}] population: {$this->rooms[$roomname]->count()}\n");
                            $this->sendToRoom($roomname, "SERVER:JOINOK:{$displayname}", $from);
                            break;
                        case "private":
                            if (isset($command[3])) {
                                if($command[3] === "JOINPRIVATE") {
                                    $this->addToRoom($roomname, $from);
                                    // print_r("Room [{$roomname}] population: {$this->rooms[$roomname]->count()}\n");
                                    $this->sendToRoom($roomname, "SERVER:JOINOK:{$displayname}", $from);
                                }
                            } else {
                                $from->send("SERVER:PRIVATE");
                            }
                    }
                    break;
                case "SEND":
                    $roomname = $command[1];
                    $message = $command[2];
                    $id = spl_object_id($from);
                    // print_r("Message [{$message}] got from Room [{$roomname}] from conn [{$id}]\n");
                    $this->sendToRoom($roomname, $message, $from);
                    break;
                case "PASSWORD":
                    $roomname = $command[1];
                    $password = $command[2];
                    $displayname = $command[3];
                    $thread = getThread($roomname);
                    
                    if($password === $thread["password"]) {
                        $from->send("OK");
                        $this->addToRoom($roomname, $from);
                        $this->sendToRoom($roomname, "SERVER:JOINOK:{$displayname}", $from);
                    } else {
                        echo "Bruh\n";
                    }
                    break;
            }
        } catch (Exception $e) {}
    }

    public function onClose(ConnectionInterface $conn)
    {
        $id = spl_object_id($conn);
        // print_r("Close connection of id [{$id}]\n");
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    private function addToRoom(string $roomname, ConnectionInterface $conn) {
        if(!isset($this->rooms[$roomname])) {
            $this->rooms[$roomname] = new SplObjectStorage();
        }
        $this->rooms[$roomname]->attach($conn);
        // print_r("Connection " . spl_object_id($conn) . " added in room {$roomname}\n");
    }

    private function sendToRoom(string $roomname, $msg, ConnectionInterface $from) {
        foreach($this->rooms[$roomname] as $client) {
            if($client !== $from) {
                $client->send($msg);
                $id = spl_object_id($client);
                // print_r("Sent to {$id} : {$msg}\n");
            }
        }
    }
}

