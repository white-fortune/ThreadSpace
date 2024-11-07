<!DOCTYPE html>
<?php
require dirname(__DIR__, 1) . "\\vendor\\autoload.php";

session_start();
if(!isset($_SESSION["email"])) {
    header("Location: /public/login.php");
	exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        .chat-card {
            width: 300px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            
            margin: 50px;
        }

        .chat-header {
            padding: 10px;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
        }

        .chat-header .h2 {
            font-size: 16px;
            color: #333;
        }

        .chat-body {
            padding: 20px;
            height: 300px;
            overflow-y: scroll;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .incoming {
            background-color: #e1e1e1;
        }

        .outgoing {
            background-color: #f2f2f2;
            text-align: right;
        }

        .message p {
            font-size: 14px;
            color: #333;
            margin: 0;
        }

        .chat-footer {
            padding: 10px;
            background-color: #f2f2f2;
            display: flex;
        }

        .chat-footer input[type="text"] {
            flex-grow: 1;
            padding: 5px;
            border: none;
            border-radius: 3px;
        }

        .chat-footer button {
            padding: 5px 10px;
            border: none;
            background-color: #4285f4;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chat-footer button:hover {
            background-color: #0f9d58;
        }

        @keyframes chatAnimation {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-card .message {
            animation: chatAnimation 0.3s ease-in-out;
            animation-fill-mode: both;
            animation-delay: 0.1s;
        }

        .chat-card .message:nth-child(even) {
            animation-delay: 0.2s;
        }

        .chat-card .message:nth-child(odd) {
            animation-delay: 0.3s;
        }

    </style>
</head>
<body>
    <?php
    include("navbar.php") 
    ?>
    <div class="container">
        <div class="chat-card">
            <div class="chat-header">
                <div class="h2" id="displayname" style="display: none;"><?php echo $_COOKIE['displayname'] ?></div>
                <div class="h2" id="roomname"><?php echo $_GET['room'] ?></div>
            </div>
            <div class="chat-body"></div>
            <div class="chat-footer">
                <input placeholder="Type your message" type="text" class="text">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script>
        const socket = new WebSocket("ws://localhost:9000/chat");
        
        let sender = document.querySelector('#displayname').innerHTML
        let roomname = document.querySelector('#roomname').innerHTML

        socket.onopen = function() {
            socket.send(`NEWUSER:${roomname}:${sender}`);
        }

        socket.onmessage = function(event) {
            const p = document.createElement("p");
            if (event.data.indexOf(":") != -1) {
                let command = event.data.split(":")
                switch(command[1]) {
                    case "JOINOK":
                        let joined = command[2]
                        p.innerHTML = `<b>${joined}</b> Just joined the chat`
                        break                
                }
            } else {
                p.innerHTML = event.data;
            }
            const chatBox = document.querySelector('.chat-body');
            const newMsg = document.createElement("div");
            newMsg.classList.add("message", "incoming");
            newMsg.appendChild(p);
            chatBox.appendChild(newMsg);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function sendMessage() {
            const message = document.querySelector('.text').value.trim();
            if(message != "") {
                const chatBox = document.querySelector('.chat-body');
                const newMsg = document.createElement("div");
                newMsg.classList.add("message", "outgoing");
                const p = document.createElement("p");
                p.innerHTML = message
                newMsg.appendChild(p);
                chatBox.appendChild(newMsg);
                chatBox.scrollTop = chatBox.scrollHeight;
                document.querySelector('.text').value = "";

                socket.send(`SEND:${roomname}:<b>${sender}</b><br> ${message}`);
            } 
        }
    </script>

</body>
</html>