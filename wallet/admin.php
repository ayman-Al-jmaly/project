<?php
require 'config.php';
if ($_SESSION['user']['role']!='admin') die("ممنوع");
$msg = "";

if ($_POST) {
    $pdo->prepare("UPDATE users SET balance=balance+? WHERE id=?")
        ->execute([$_POST['amount'],$_POST['id']]);
    $msg = "success|تم الإيداع";
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>
<body>

<h2>👑 لوحة المدير</h2>

<?php foreach($users as $u): ?>
<form method="post" class="mini">
<?= $u['username'] ?> | <?= $u['balance'] ?> $
<input type="hidden" name="id" value="<?= $u['id'] ?>">
<input name="amount" placeholder="مبلغ">
<button>إيداع</button>
</form>
<?php endforeach; ?>

<?php if($msg): ?>
<script>alertMsg("<?= $msg ?>");</script>
<?php endif; ?>

<a href="dashboard.php">رجوع</a>

</body>
</html>
