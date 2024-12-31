<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $totalPoints = $data['totalPoints'];
    $playsLeft = $data['playsLeft'];

    $_SESSION['totalPoints'] = $totalPoints;
    $_SESSION['playsLeft'] = $playsLeft;

    if ($playsLeft <= 0) {
        $_SESSION['cooldown'] = time() + 8 * 3600; // 8 hours cooldown
    }

    echo json_encode(['success' => true]);
    exit;
}

// On page load
if (!isset($_SESSION['playsLeft'])) {
    $_SESSION['playsLeft'] = 3;
    $_SESSION['totalPoints'] = 0;
}

if (isset($_SESSION['cooldown']) && time() < $_SESSION['cooldown']) {
    echo json_encode(['cooldown' => $_SESSION['cooldown'] - time()]);
    exit;
}
