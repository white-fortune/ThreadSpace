<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location: /public/login.php");
	exit();
}


include("../src/controller/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["threadname"]) && isset($_POST["description"]) && isset($_POST["password"]) && isset($_POST["threadtype"])) {
        $threadname = filter_input(INPUT_POST, "threadname", FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        $threadtype = filter_input(INPUT_POST, "threadtype", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        addThread($threadname, $desc, $password, $threadtype);
        header("Location: /public/threads.php");
        exit();
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .card {
        --border-radius: 0.75rem;
        --primary-color: #7257fa;
        --secondary-color: #3c3852;
        width: 80%;
        font-family: "Arial";
        padding: 1rem;
        cursor: pointer;
        border-radius: var(--border-radius);
        background: #f1f1f3;
        box-shadow: 0px 8px 16px 0px rgb(0 0 0 / 3%);
        position: relative;
        margin: 10px;
        }

        .card > * + * {
        margin-top: 1.1em;
        }

        .card .card__content {
        color: var(--secondary-color);
        font-size: 0.86rem;
        }

        .card .card__title {
        padding: 0;
        font-size: 1.3rem;
        font-weight: bold;
        }

        .card .card__state {
        color: #6e6b80;
        font-size: 20px;
        }

        .card .card__arrow {
        position: absolute;
        background: var(--primary-color);
        padding: 0.4rem;
        border-top-left-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
        bottom: 0;
        right: 0;
        transition: 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        }

        .card svg {
        transition: 0.2s;
        }

        /* hover */
        .card:hover .card__title {
        color: var(--primary-color);
        text-decoration: underline;
        }

        .card:hover .card__arrow {
        background: #111;
        }

        .card:hover .card__arrow svg {
        transform: translateX(3px);
        }
    </style>
</head>
<body>
    <?php include("navbar.php") ?> 
    
    <br>
    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Start Thread
        </button>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Start a new thraed</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="thread-name" class="col-form-label">Thread Name:</label>
                                <input type="text" class="form-control" type="text" name="threadname" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="thread-name" class="col-form-label">Thread Type:</label>
                                <select class="form-select" aria-label="Default select example" name="threadtype">
                                    <option value="public" selected>Public</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                            <div class="mb-3" id="passwordDiv">
                                <label for="message-text" class="col-form-label">Password:</label>
                                <input class="form-control" type="text" name="password" id="passinput">
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-outline-success" type="submit">Start</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <br><br>
        <?php
            foreach(getAllThread() as $thread) {
                echo <<<HTML
                    <div class="card">
                        <h3 class="card__title">{$thread["name"]}</h3>
                        <p class="card__content">{$thread["description"]}</p>
                        <div class="card__state">
                            <span class="badge text-bg-success">{$thread["state"]}</span>
                        </div>
                        <div class="card__arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="15" width="15">
                                <path fill="#fff" d="M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z"></path>
                            </svg>
                        </div>
                    </div>
                HTML;
            } 
        ?>
    </div>
    <script>
        const arrows = document.querySelectorAll('.card__arrow')
        arrows.forEach(arrow => {
            let roomname = arrow.parentElement.querySelector(".card__title").innerHTML
            arrow.addEventListener("click", function() {
                window.location.href = `/public/chat.php?room=${roomname}`
            })
        })


        let passField = document.querySelector('div#passwordDiv')
        passField.style.display = "none"

        let passInput = document.querySelector('#passinput')
        let selectType = document.querySelector('select')

        selectType.addEventListener("change", function() {
            switch(selectType.value) {
                case "public":
                    passField.style.display = "none"
                    passInput.removeAttribute("required")
                    break
                case "private":
                    passField.style.display = "block"
                    passInput.setAttribute("required", "required")
                    break
            }
        })
    </script>
</body>
</html>