<?php
require 'config.php';
$user = $_SESSION['user'];
$msg = "";

if ($_POST) {
    $to = $_POST['to'];
    $amount = floatval($_POST['amount']);
    $note = $_POST['message'];

    $sender = $pdo->query("SELECT balance FROM users WHERE id={$user['id']}")->fetchColumn();

    $receiver = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $receiver->execute([$to]);
    $r = $receiver->fetch();

    if (!$r) {
        $msg = "error|المستخدم غير موجود";
    } elseif ($amount <= 0) {
        $msg = "error|مبلغ غير صحيح";
    } elseif ($sender < $amount) {
        $msg = "error|رصيدك غير كافي";
    } else {
        $pdo->beginTransaction();

        $pdo->prepare("UPDATE users SET balance=balance-? WHERE id=?")
            ->execute([$amount,$user['id']]);

        $pdo->prepare("UPDATE users SET balance=balance+? WHERE id=?")
            ->execute([$amount,$r['id']]);

        $pdo->prepare("INSERT INTO transfers 
        (sender_id,receiver_id,amount,message)
        VALUES (?,?,?,?)")
        ->execute([$user['id'],$r['id'],$amount,$note]);

        $pdo->commit();
        $msg = "success|تم التحويل بنجاح";
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
<h3>تحويل رصيد</h3>
<input name="to" placeholder="اسم المستلم" required>
<input name="amount" type="number" step="0.01" placeholder="المبلغ" required>
<input name="message" placeholder="رسالة (اختياري)">
<button>تحويل</button>
<a href="dashboard.php">رجوع</a>
</form>

<?php if($msg): ?>
<script>alertMsg("<?= $msg ?>");</script>
<?php endif; ?>

</body>
</html>

