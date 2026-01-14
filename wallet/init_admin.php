<?php
require 'config.php';

$check = $pdo->query("SELECT id FROM users WHERE role='admin'");
if ($check->rowCount() == 0) {
    $pass = password_hash("admin123", PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users (username,password,role)
                   VALUES ('admin',?,'admin')")
        ->execute([$pass]);
    echo "Admin Created<br>username: admin<br>password: admin123";
} else {
    echo "Admin already exists";
}

