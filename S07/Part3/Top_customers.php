<?php
require_once 'Database.php';

$db = Database::getInstance()->getConnection();

// SQL query
$sql = "
SELECT u.name, u.email, SUM(o.total_amount) AS total_spent
FROM users u
JOIN orders o ON u.id = o.user_id
GROUP BY u.id, u.name, u.email
ORDER BY total_spent DESC
LIMIT 3
";

$stmt = $db->prepare($sql);
$stmt->execute();
$customers = $stmt->fetchAll();
?>

<!-- HTML Table -->
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Total Spent</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $row): ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['total_spent'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>