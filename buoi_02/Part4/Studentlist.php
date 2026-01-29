<?php
$students = [
    ['name' => 'Alice', 'grade' => 90],
    ['name' => 'Bob', 'grade' => 85],
    ['name' => 'Charlie', 'grade' => 92],
    ['name' => 'Diana', 'grade' => 88],
    ['name' => 'Eve', 'grade' => 95]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>
    <h2>Student List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student) { ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['grade']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
