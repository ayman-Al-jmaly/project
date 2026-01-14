<?php
require 'config.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

$id = $_SESSION['user']['id'];
$user = $pdo->query("SELECT * FROM users WHERE id=$id")->fetch();
$_SESSION['user'] = $user;
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">
<h2>مرحباً <?= $user['username'] ?></h2>
<p class="balance">رصيدك: <?= $user['balance'] ?> $</p>

<a href="transfer.php">🔁 تحويل رصيد</a>
<a href="history.php">📄 سجل الحركات</a>

<?php if ($user['role']=='admin'): ?>
<a href="admin.php">👑 لوحة المدير</a>
<?php endif; ?>

<a href="logout.php">🚪 خروج</a>
</div>

</body>
</html>

