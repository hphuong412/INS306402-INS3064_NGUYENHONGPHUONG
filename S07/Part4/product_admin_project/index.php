<?php
require_once 'Database.php';
$db = (new Database())->connect();

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT p.id, p.name, p.price, c.name AS category_name, p.stock
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE 1";

$params = [];

if (!empty($search)) {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%$search%";
}

if (!empty($category)) {
    $sql .= " AND p.category_id = ?";
    $params[] = $category;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$catStmt = $db->query("SELECT * FROM categories");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Admin Dashboard</title>
</head>
<body>

<h2>Product Admin Dashboard</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Search product..."
           value="<?= htmlspecialchars($search) ?>">

    <select name="category">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"
                <?= $category == $cat['id'] ? 'selected' : '' ?>>
                <?= $cat['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filter</button>
</form>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Stock</th>
    </tr>

    <?php foreach ($products as $p): ?>
        <tr style="<?= $p['stock'] < 10 ? 'background-color: #ffcccc;' : '' ?>">
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= htmlspecialchars($p['price']) ?></td>
            <td><?= htmlspecialchars($p['category_name']) ?></td>
            <td><?= htmlspecialchars($p['stock']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
