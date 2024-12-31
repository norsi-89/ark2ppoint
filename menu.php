<?php
session_start();
if (!isset($_SESSION['points'])) {
    $_SESSION['points'] = 0;
}

// Handle AJAX requests for spinning
if (isset($_POST['action']) && $_POST['action'] == 'spin') {
    $prizes = [100, 200, 300, 400, 500, 'BANKRUPT', 750, 1000];
    $result = $prizes[array_rand($prizes)];
    
    if ($result !== 'BANKRUPT') {
        $_SESSION['points'] += $result;
    } else {
        $_SESSION['points'] = 0;
    }
    
    echo json_encode(['prize' => $result, 'total_points' => $_SESSION['points']]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheel of Fortune</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    @keyframes typing {
      from { width: 0; }
      to { width: 100%; }
    }

    @keyframes blink {
      50% { border-color: transparent; }
    }

    .typing-effect {
      border-right: 2px solid black;
      white-space: nowrap;
      overflow: hidden;
      display: inline-block;
      animation: typing 3s steps(30, end), blink 0.6s step-end infinite;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <button class="fixed top-4 right-2 text-2xl text-white px-4 py-2 rounded-lg" onclick="location.href='index.php'">back</button>
    <div class="container mx-auto text-center">
    <h1 class="text-2xl font-bold text-gray-800">
    <span class="typing-effect text-white shadow-sm ">the lucky wheel is it</span>
  </h1>

  <script>
    const text = "Welcome to the Animation!";
    const typingEffect = document.querySelector(".typing-effect");

    function resetAnimation() {
      typingEffect.style.animation = 'none';
      void typingEffect.offsetWidth; // trigger reflow
      typingEffect.style.animation = null; 
    }

    typingEffect.addEventListener('animationend', () => {
      setTimeout(resetAnimation, 2000); // Pause before restarting animation
    });
  </script>
        <br>
        <div class="wheel-container relative w-64 h-64 mx-auto mb-8">
            <canvas id="wheel" width="300" height="300" class="border-4 border-blue-500 rounded-full"></canvas>
            <div id="spinner" class="absolute top-1/2 right-0 transform translate-x-full -translate-y-1/2 text-4xl bg-white/30 rounded-lg m-6 p-1">▶</div>
        </div>

        <div class="controls space-y-4">
            <br>
            <button id="spinBtn" class="bg-green-500 text-white px-6 py-2 rounded-lg transition">
                SPIN
            </button>
            
            <div class="points-display text-sm font-bold text-white">
                Points: <span id="points"><?php echo $_SESSION['points']; ?></span>
            </div>
            
            <div id="result" class="text-xl font-bold text-green-600"></div>
        </div>
    </div>

    <script>
        const wheel = document.getElementById('wheel');
        const ctx = wheel.getContext('2d');
        const prizes = [10, 50, 0, 25, 35, 'BANKRUPT', 40, 50];
        let isSpinning = false;

        function drawWheel() {
            const centerX = wheel.width / 2;
            const centerY = wheel.height / 2;
            const radius = 150;
            const sections = prizes.length;
            const arc = (Math.PI * 2) / sections;

            for (let i = 0; i < sections; i++) {
                ctx.beginPath();
                ctx.fillStyle = i % 2 ? '#4F46E5' : '#818CF8';
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, i * arc, (i + 1) * arc);
                ctx.closePath();
                ctx.fill();

                // Add text
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(i * arc + arc / 2);
                ctx.textAlign = 'right';
                ctx.fillStyle = 'white';
                ctx.font = '16px Arial';
                ctx.fillText(prizes[i], radius - 20, 0);
                ctx.restore();
            }
        }

        drawWheel();

        $('#spinBtn').click(function() {
            if (isSpinning) return;
            isSpinning = true;
            $(this).prop('disabled', true);

            const rotations = 5 + Math.random() * 5;
            const duration = 5000;
            const wheel = document.getElementById('wheel');
            
            wheel.style.transition = `transform ${duration}ms cubic-bezier(0.17, 0.67, 0.12, 0.99)`;
            wheel.style.transform = `rotate(${rotations * 360}deg)`;

            $.post('menu.php', { action: 'spin' }, function(response) {
                const data = JSON.parse(response);
                setTimeout(() => {
                    $('#points').text(data.total_points);
                    $('#result').text(`You got: ${data.prize}`);
                    isSpinning = false;
                    $('#spinBtn').prop('disabled', false);
                    wheel.style.transform = 'rotate(0deg)';
                }, duration);
            });
        });
    </script>
</body>
</html>