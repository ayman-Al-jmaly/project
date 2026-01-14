
<?php
require 'config.php';
$id = $_SESSION['user']['id'];

$rows = $pdo->prepare("
SELECT t.*, u1.username sender, u2.username receiver
FROM transfers t
JOIN users u1 ON t.sender_id=u1.id
JOIN users u2 ON t.receiver_id=u2.id
WHERE sender_id=? OR receiver_id=?
ORDER BY t.id DESC
");
$rows->execute([$id,$id]);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>📄 سجل الحركات</h2>
<table>
<tr>
<th>من</th><th>إلى</th><th>المبلغ</th><th>الرسالة</th><th>التاريخ</th>
</tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?= $r['sender'] ?></td>
<td><?= $r['receiver'] ?></td>
<td><?= $r['amount'] ?></td>
<td><?= $r['message'] ?></td>
<td><?= $r['created_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<a href="dashboard.php">رجوع</a>

</body>
</html>

