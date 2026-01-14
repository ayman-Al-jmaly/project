<?php
require 'config.php';
$msg = "";

if ($_POST) {
    $u = trim($_POST['username']);
    $p = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$u]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($p, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
        } else {
            $msg = "error|كلمة المرور غير صحيحة";
        }
    } else {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username,password) VALUES (?,?)")
            ->execute([$u,$hash]);
        $msg = "success|تم إنشاء الحساب بنجاح";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>
<body>

<form method="post" class="box">
<h2>تسجيل / إنشاء حساب</h2>
<input name="username" placeholder="اسم المستخدم" required>
<input name="password" type="password" placeholder="كلمة المرور" required>
<button>دخول</button>
</form>

<?php if($msg): ?>
<script>alertMsg("<?= $msg ?>");</script>
<?php endif; ?>

</body>
</html>
