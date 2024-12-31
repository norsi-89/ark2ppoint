// Example: Basic validation for login or registration form via JS
document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Example of AJAX logic to send data (optional)
});


const wheel = document.getElementById('wheel');
const spinBtn = document.getElementById('spin-btn');
const totalPointsEl = document.getElementById('total-points');
const playsLeftEl = document.getElementById('plays-left');
const ctx = wheel.getContext('2d');

const segments = [20, 10, 5, 50, 75, 40, 0, 1, 15];
const colors = ["#FF5733", "#33FF57", "#3357FF", "#FF33A1", "#A133FF", "#33FFF5", "#FFDA33", "#DFFF33", "#33FFDA"];
let totalPoints = 0;
let playsLeft = 3;

// Draw Wheel
function drawWheel() {
    const radius = wheel.width / 2;
    ctx.clearRect(0, 0, wheel.width, wheel.height);
    const angle = (2 * Math.PI) / segments.length;

    for (let i = 0; i < segments.length; i++) {
        ctx.beginPath();
        ctx.moveTo(radius, radius);
        ctx.arc(radius, radius, radius, i * angle, (i + 1) * angle);
        ctx.fillStyle = colors[i];
        ctx.fill();
        ctx.stroke();
        ctx.closePath();
    }
}

// Spin Wheel
function spinWheel() {
    if (playsLeft <= 0) {
        alert("You can't play anymore. Try again after 8 hours.");
        return;
    }

    const spinAngle = Math.random() * 360 + 720; // Spin at least 2 full rotations
    const duration = 3000; // Spin duration in ms
    let startAngle = 0;

    const spinInterval = setInterval(() => {
        startAngle = (startAngle + 5) % 360;
        wheel.style.transform = `rotate(${startAngle}deg)`;
    }, 16);

    setTimeout(() => {
        clearInterval(spinInterval);
        const finalAngle = (startAngle + spinAngle) % 360;
        const segmentIndex = Math.floor(finalAngle / (360 / segments.length));
        const pointsWon = segments[segmentIndex];

        totalPoints += pointsWon;
        playsLeft--;

        // Update UI
        totalPointsEl.textContent = totalPoints;
        playsLeftEl.textContent = playsLeft;

        // Notify server
        fetch('backend.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ totalPoints, playsLeft })
        });
    }, duration);
}

spinBtn.addEventListener('click', spinWheel);
drawWheel();
