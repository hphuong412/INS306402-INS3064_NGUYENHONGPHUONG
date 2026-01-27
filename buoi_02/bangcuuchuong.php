<?php
echo "<h2>Bảng Cửu Chương</h2>";
echo "<table border='1' cellpadding='8' cellspacing='0'>";

for ($i = 1; $i <= 10; $i++) {
    echo "<tr>";
    for ($j = 2; $j <= 9; $j++) {
        echo "<td>$j x $i = " . ($j * $i) . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>
