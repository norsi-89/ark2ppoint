<?php
include 'db.php';

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$face_image = uniqid() . '.png';

if (file_put_contents("uploads/$face_image", base64_decode($_POST['face_image']))) {
    $stmt = $conn->prepare("INSERT INTO users (email, password, face_image) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $email, $password, $face_image);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Image upload failed.']);
}
$conn->close();
?>
