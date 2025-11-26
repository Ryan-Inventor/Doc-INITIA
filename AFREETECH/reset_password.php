<?php
require_once __DIR__ . '/config/database.php';

$database = new Database();
$db = $database->getConnection();

$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT);
$email = 'admin@intia.com';

$query = "UPDATE utilisateurs SET mot_de_passe = :hash WHERE email = :email";
$stmt = $db->prepare($query);
$stmt->bindParam(':hash', $hash);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    echo "Password reset successfully for $email\n";
    echo "New hash: $hash\n";
} else {
    echo "Failed to reset password.\n";
}
