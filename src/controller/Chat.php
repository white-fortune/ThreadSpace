<?php

namespace ChatApp;

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
        // echo "New connection\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $command = explode(":", $msg);
        switch($command[0]) {
            case "NEWUSER":
                $roomname = $command[1];
                $displayname = $command[2];
                $this->addToRoom($roomname, $from);
                // print_r("Room [{$roomname}] population: {$this->rooms[$roomname]->count()}\n");
                $this->sendToRoom($roomname, "SERVER:JOINOK:{$displayname}", $from);
                break;
            case "SEND":
                $roomname = $command[1];
                $message = $command[2];
                $id = spl_object_id($from);
                // print_r("Message [{$message}] got from Room [{$roomname}] from conn [{$id}]\n");
                $this->sendToRoom($roomname, $message, $from);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        // echo "Connection closed\n";
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
                // $id = spl_object_id($client);
                // print_r("Sent to {$id} : {$msg}\n");
            }
        }
    }
}

