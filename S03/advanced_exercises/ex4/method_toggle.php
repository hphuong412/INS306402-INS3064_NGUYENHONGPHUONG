<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name'])) {
    echo "<h3>GET Data:</h3>";
    print_r($_GET);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>POST Data:</h3>";
    print_r($_POST);
}
?>

<h2>GET vs POST</h2>

<label>
<input type="radio" name="method" value="GET" checked> GET
</label>
<label>
<input type="radio" name="method" value="POST"> POST
</label>

<form id="myForm">
    <input type="text" name="name" required>
    <button type="submit">Send</button>
</form>

<script>
const form = document.getElementById('myForm');
const radios = document.getElementsByName('method');

radios.forEach(r => {
    r.addEventListener('change', function() {
        form.method = this.value;
    });
});
</script>