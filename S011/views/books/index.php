<h1>Book List</h1>
<a href="index.php?action=create">Add</a>

<table border="1">
<?php foreach ($books as $b): ?>
<tr>
    <td><?= $b['id'] ?></td>
    <td><?= $b['title'] ?></td>
    <td>
        <a href="index.php?action=delete&id=<?= $b['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>