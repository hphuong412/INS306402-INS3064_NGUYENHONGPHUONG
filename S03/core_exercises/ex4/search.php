<?php
$q = "";

if (isset($_GET["q"])) {
    $q = htmlspecialchars($_GET["q"]);
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Search</h2>

<form method="get">
    <input type="text" name="q" value="<?= $q ?>">
    <button type="submit">Search</button>
</form>

<?php if ($q): ?>
    <p>You searched for: <strong><?= $q ?></strong></p>
<?php endif; ?>

</body>
</html>
