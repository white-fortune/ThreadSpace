<?php 
session_start();
if(isset($_SESSION["email"])) {
	header("Location: /public/dashboard.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <style>
		/* From Uiverse.io by 0xnihilism */ 
		.brutalist-container {
			position: relative;
			width: 250px;
			font-family: monospace;
			margin: 50px;
		}

		.brutalist-input {
			width: 100%;
			padding: 15px;
			font-size: 18px;
			font-weight: bold;
			color: #000;
			background-color: #fff;
			border: 4px solid #000;
			position: relative;
			overflow: hidden;
			border-radius: 0;
			outline: none;
			transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
			box-shadow: 5px 5px 0 #000, 10px 10px 0 #4a90e2;
		}

		@keyframes glitch {
			0% {
				transform: translate(0);
			}
			20% {
				transform: translate(-2px, 2px);
			}
			40% {
				transform: translate(-2px, -2px);
			}
			60% {
				transform: translate(2px, 2px);
			}
			80% {
				transform: translate(2px, -2px);
			}
			100% {
				transform: translate(0);
			}
		}

		.brutalist-input:focus {
			animation: focus-pulse 4s cubic-bezier(0.25, 0.8, 0.25, 1) infinite,
			glitch 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) infinite;
		}

		.brutalist-input:focus::after {
			content: "";
			position: absolute;
			top: -2px;
			left: -2px;
			right: -2px;
			bottom: -2px;
			background: white;
			z-index: -1;
		}

		.brutalist-input:focus::before {
			content: "";
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: black;
			z-index: -2;
			clip-path: inset(0 100% 0 0);
			animation: glitch-slice 4s steps(2, end) infinite;
		}

		@keyframes glitch-slice {
			0% {
				clip-path: inset(0 100% 0 0);
			}
			10% {
				clip-path: inset(0 5% 0 0);
			}
			20% {
				clip-path: inset(0 80% 0 0);
			}
			30% {
				clip-path: inset(0 10% 0 0);
			}
			40% {
				clip-path: inset(0 50% 0 0);
			}
			50% {
				clip-path: inset(0 30% 0 0);
			}
			60% {
				clip-path: inset(0 70% 0 0);
			}
			70% {
				clip-path: inset(0 15% 0 0);
			}
			80% {
				clip-path: inset(0 90% 0 0);
			}
			90% {
				clip-path: inset(0 5% 0 0);
			}
			100% {
				clip-path: inset(0 100% 0 0);
			}
		}

		.brutalist-label {
			position: absolute;
			left: -3px;
			top: -35px;
			font-size: 14px;
			font-weight: bold;
			color: #fff;
			background-color: #000;
			padding: 5px 10px;
			transform: rotate(-1deg);
			z-index: 1;
			transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
		}

		.brutalist-input:focus + .brutalist-label {
			transform: rotate(0deg) scale(1.05);
			background-color: #4a90e2;
		}

		.smooth-type {
			position: relative;
			overflow: hidden;
		}

		.smooth-type::before {
			content: "";
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			background: linear-gradient(90deg, #fff 0%, rgba(255, 255, 255, 0) 100%);
			z-index: 1;
			opacity: 0;
			transition: opacity 0.3s ease;
		}

		.smooth-type:focus::before {
			opacity: 1;
			animation: type-gradient 2s linear infinite;
		}

		@keyframes type-gradient {
			0% {
				background-position: 300px 0;
			}
			100% {
				background-position: 0 0;
			}
		}

		.brutalist-input::placeholder {
			color: #888;
			transition: color 0.3s ease;
		}

		.brutalist-input:focus::placeholder {
			color: transparent;
		}

		.brutalist-input:focus {
			animation: focus-pulse 4s cubic-bezier(0.25, 0.8, 0.25, 1) infinite;
		}

		@keyframes focus-pulse {
			0%,
			100% {
				border-color: #000;
			}
			50% {
				border-color: #4a90e2;
			}
		}

		.button {
			--bezier: cubic-bezier(0.22, 0.61, 0.36, 1);
			--edge-light: hsla(0, 0%, 50%, 0.8);
			--text-light: rgba(255, 255, 255, 0.4);
			--back-color: 240, 40%;

			cursor: pointer;
			padding: 0.7em 1em;
			border-radius: 0.5em;
			min-height: 2.4em;
			min-width: 3em;
			display: flex;
			align-items: center;
			gap: 0.5em;

			font-size: 18px;
			letter-spacing: 0.05em;
			line-height: 1;
			font-weight: bold;

			background: linear-gradient(
				140deg,
				hsla(var(--back-color), 50%, 1) min(2em, 20%),
				hsla(var(--back-color), 50%, 0.6) min(8em, 100%)
			);
			color: hsla(0, 0%, 90%);
			border: 0;
			box-shadow: inset 0.4px 1px 4px var(--edge-light);

			transition: all 0.1s var(--bezier);
			margin-left: 120px;
		}

		.button:hover {
			--edge-light: hsla(0, 0%, 50%, 1);
			text-shadow: 0px 0px 10px var(--text-light);
			box-shadow: inset 0.4px 1px 4px var(--edge-light),
				2px 4px 8px hsla(0, 0%, 0%, 0.295);
			transform: scale(1.1);
			}

			.button:active {
			--text-light: rgba(255, 255, 255, 1);

			background: linear-gradient(
				140deg,
				hsla(var(--back-color), 50%, 1) min(2em, 20%),
				hsla(var(--back-color), 50%, 0.6) min(8em, 100%)
			);
			box-shadow: inset 0.4px 1px 8px var(--edge-light),
				0px 0px 8px hsla(var(--back-color), 50%, 0.6);
			text-shadow: 0px 0px 20px var(--text-light);
			color: hsla(0, 0%, 100%, 1);
			letter-spacing: 0.1em;
			transform: scale(1);
		}

    </style>
</head>
<body>
	<?php include("navbar.php") ?>
	<br>
	<div class="container">
		<form action="../src/controller/register.php" method="post">
			<div class="brutalist-container">
				<label class="brutalist-label">Register Now!!</label>
				<input
					placeholder="DISPLAY NAME"
					class="brutalist-input smooth-type"
					type="text"
					name="displayname"
					required
				/><br><br>
				<input
					placeholder="EMAIL"
					class="brutalist-input smooth-type"
					type="email"
					name="email"
					required
				/>
				<br><br>
				<input
					placeholder="ABOUT YOU/BIO"
					class="brutalist-input smooth-type"
					type="text"
					name="description"
					required
				/>
				<br><br>
				<input
					placeholder="PASSWORD"
					class="brutalist-input smooth-type"
					type="password"
					name="password"
					required
				/>
			</div>
			<div>
			<button class="button">
				<svg
					viewBox="0 0 16 16"
					class="bi bi-lightning-charge-fill"
					fill="currentColor"
					height="16"
					width="16"
					xmlns="http://www.w3.org/2000/svg"
				>
				<path
					d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"
				></path></svg>
				Register
			</button>
			</div>
		</form>
	</div>
</body>
</html>