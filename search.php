<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wallet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-900 ">
<button class="fixed top-4 right-2 text-2xl text-white px-4 py-2 rounded-lg" onclick="location.href='index.php'">back</button>
<br><br>
    <h1 class="text-white flex items-center justify-center p-4 m-4 text-2xl">your ark code</h1>
    <h1 class="text-white flex items-center justify-center p-4 m-4 text-3xl bg-red-900 rounded-lg shadow-md" onclick="copyText()">9878-hjgd-2421-mksx</h1>

    <div id="timer-container" class="text-white shadow-md rounded-lg p-6 text-center">
        <div class="mb-4">
            <h1 class="text-xl font-bold">your time</h1>
        </div>
        <div id="timer-display" class="text-3xl font-mono mb-4">
            <span id="hours"></span>:<span id="minutes"></span>:<span id="seconds">00</span>
        </div>
        <div class="flex justify-center space-x-4 mb-4">
            <button id="refresh-btn"></button>
            <button id="delete-btn" ></button>
        </div>
    </div>
    <div class=" justify-center items-center text-center text-white p-4">
    <h1 class="text-4xl text-yellow-500">warning</h1>
<p><p class="text-yellow-400">1</p> points are counted at any time of play</p>
<p><p class="text-yellow-400">2</p>Each time you refresh, the points will <br> be 0 but will be added to the account</p>
<p><p class="text-yellow-400">3</p>no one should know the code.<br>steal points if you can</p>
<p><p class="text-yellow-400">4</p>anyone who uses the website for less than <br>5 minutes per day will not count point</p>
<p><p class="text-yellow-400">5</p>you cannot use the code until the points reach 290 points</p>

    </div>
    <script>






        let timerInterval;
        let totalSeconds = 0;

        const hoursEl = document.getElementById("hours");
        const minutesEl = document.getElementById("minutes");
        const secondsEl = document.getElementById("seconds");
        const refreshBtn = document.getElementById("refresh-btn");
        const deleteBtn = document.getElementById("delete-btn");

        function updateTimerDisplay() {
            const hours = Math.floor(totalSeconds / 3600).toString().padStart(2, "0");
            const minutes = Math.floor((totalSeconds % 3600) / 60).toString().padStart(2, "0");
            const seconds = (totalSeconds % 60).toString().padStart(2, "0");

            hoursEl.textContent = hours;
            minutesEl.textContent = minutes;
            secondsEl.textContent = seconds;
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                totalSeconds++;
                updateTimerDisplay();
            }, 1000);
        }

        function refreshTimer() {
            clearInterval(timerInterval);
            totalSeconds = 0;
            updateTimerDisplay();
            startTimer();
        }

        function deleteTimer() {
            clearInterval(timerInterval);
            document.getElementById("timer-container").remove();

            // Simulating AJAX call for deletion
            fetch("/delete-timer", {
                method: "POST",
            })
                .then(response => console.log("Timer deleted", response))
                .catch(err => console.error("Error deleting timer", err));
        }

        refreshBtn.addEventListener("click", refreshTimer);
        deleteBtn.addEventListener("click", deleteTimer);

        // Auto-start the timer on page load
        startTimer();
    </script>




</body>
</html>