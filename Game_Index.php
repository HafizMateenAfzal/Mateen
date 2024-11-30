<?php
// Only PHP logic is used for embedding dynamic values if needed.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bounce Bell Game</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-color: #282c34;
            font-family: Arial, sans-serif;
            color: white;
        }
        canvas {
            display: block;
        }
        #score {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div id="score">Score: 0</div>
    <canvas id="gameCanvas"></canvas>
    <script>
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        // Game variables
        let ball = { x: canvas.width / 2, y: canvas.height / 2, radius: 15, dx: 3, dy: 3 };
        let bell = { x: canvas.width / 2 - 30, y: 50, width: 60, height: 20 };
        let score = 0;

        // Load bell sound
        const bellSound = new Audio('https://www.soundjay.com/button/beep-07.wav');

        function drawBall() {
            ctx.beginPath();
            ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
            ctx.fillStyle = "#FF4500";
            ctx.fill();
            ctx.closePath();
        }

        function drawBell() {
            ctx.beginPath();
            ctx.rect(bell.x, bell.y, bell.width, bell.height);
            ctx.fillStyle = "#FFD700";
            ctx.fill();
            ctx.closePath();
        }

        function drawScore() {
            document.getElementById("score").innerText = `Score: ${score}`;
        }

        function update() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw elements
            drawBall();
            drawBell();
            drawScore();

            // Ball movement
            ball.x += ball.dx;
            ball.y += ball.dy;

            // Ball collision with walls
            if (ball.x + ball.radius > canvas.width || ball.x - ball.radius < 0) {
                ball.dx = -ball.dx;
            }
            if (ball.y - ball.radius < 0) {
                ball.dy = -ball.dy;
            } else if (ball.y + ball.radius > canvas.height) {
                ball.dy = -ball.dy;
            }

            // Ball collision with bell
            if (
                ball.x > bell.x &&
                ball.x < bell.x + bell.width &&
                ball.y - ball.radius < bell.y + bell.height &&
                ball.y + ball.radius > bell.y
            ) {
                score++;
                ball.dy = -ball.dy;
                bellSound.play();
            }

            // Loop update
            requestAnimationFrame(update);
        }

        // Start game
        update();
    </script>
</body>
</html>
