<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="container py-2 bg-gray-900 text-white text-center p-2 justify-center items-center">
    <?php
    $profileName = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : 1;
    ?>
    <div class="backdrop-blur-sm bg-black/30 rounded-lg p-2   mt-2">
        <div id="clock" class="text-4xl font-bold mb-4"></div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xl">earn points</span>
                <span class="text-xl font-semibold"><?php echo htmlspecialchars($profileName); ?></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xl">Level:</span>
                <span class="text-xl font-semibold"><?php echo $level; ?></span>
            </div>
        </div>
    </div>
    <script>
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleTimeString();
    }
    setInterval(updateClock, 1000);
    updateClock();
    </script>
</div>
</body>
</html>