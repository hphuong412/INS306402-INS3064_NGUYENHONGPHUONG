<?php
$host = "localhost";
$dbname = "hospital_management";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$message = "";
$error = "";

function clean_input($data) {
    return htmlspecialchars(trim($data));
}
//lay dl
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_code = clean_input($_POST['patient_code'] ?? '');
    $full_name = clean_input($_POST['full_name'] ?? '');
    $date_of_birth = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;
    $gender = clean_input($_POST['gender'] ?? 'Other');
    $phone = clean_input($_POST['phone'] ?? '');
    $address = clean_input($_POST['address'] ?? '');

    if (empty($patient_code) || empty($full_name)) {
        $error = "Patient Code and Full Name are required.";
    } else {
        try {
            if (isset($_POST['add'])) {
                $sql = "INSERT INTO patients (patient_code, full_name, date_of_birth, gender, phone, address)
                        VALUES (:patient_code, :full_name, :date_of_birth, :gender, :phone, :address)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':patient_code' => $patient_code,
                    ':full_name' => $full_name,
                    ':date_of_birth' => $date_of_birth,
                    ':gender' => $gender,
                    ':phone' => $phone,
                    ':address' => $address
                ]);
                $message = "Patient added successfully.";
            }

            if (isset($_POST['update'])) {
                $update_id = (int)$_POST['id'];
                $sql = "UPDATE patients
                        SET patient_code = :patient_code,
                            full_name = :full_name,
                            date_of_birth = :date_of_birth,
                            gender = :gender,
                            phone = :phone,
                            address = :address
                        WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':patient_code' => $patient_code,
                    ':full_name' => $full_name,
                    ':date_of_birth' => $date_of_birth,
                    ':gender' => $gender,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':id' => $update_id
                ]);
                $message = "Patient updated successfully.";
                $action = '';
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM patients WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $message = "Patient deleted successfully.";
        $action = '';
    } catch (PDOException $e) {
        $error = "Delete failed: " . $e->getMessage();
    }
}

$editData = null;
if ($action === 'edit' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM patients WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $pdo->query("SELECT * FROM patients ORDER BY id ASC");
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Patient Management</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            background: #f4f7fb;
            color: #333;
        }
        .container {
            width: 95%;
            max-width: 1100px;
            margin: 30px auto;
        }
        h1 {
            text-align: center;
            color: #0b5ed7;
            margin-bottom: 20px;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
        }
        .success {
            background: #d1e7dd;
            color: #0f5132;
        }
        .error {
            background: #f8d7da;
            color: #842029;
        }
        form .row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        form .form-group {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 6px;
            font-weight: bold;
        }
        input, select, textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        textarea {
            resize: vertical;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-primary {
            background: #0b5ed7;
        }
        .btn-warning {
            background: #f0ad4e;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-secondary {
            background: #6c757d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #0b5ed7;
            color: white;
        }
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .actions a {
            margin-right: 8px;
        }
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                font-size: 14px;
            }
            .actions a {
                display: inline-block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hospital Patient Management System</h1>
    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    <?php if ($message): ?>
        <div class="message success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <h2><?php echo $editData ? "Edit Patient" : "Add New Patient"; ?></h2>
        <form method="POST">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
            <?php endif; ?>

            <div class="row">
                <div class="form-group">
                    <label>Patient Code *</label>
                    <input type="text" name="patient_code" required
                           value="<?php echo $editData['patient_code'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" required
                           value="<?php echo $editData['full_name'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth"
                           value="<?php echo $editData['date_of_birth'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="Male" <?php echo (isset($editData['gender']) && $editData['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo (isset($editData['gender']) && $editData['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo (isset($editData['gender']) && $editData['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone"
                           value="<?php echo $editData['phone'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address"><?php echo $editData['address'] ?? ''; ?></textarea>
                </div>
            </div>

            <?php if ($editData): ?>
                <button type="submit" name="update" class="btn btn-warning">Update Patient</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            <?php else: ?>
                <button type="submit" name="add" class="btn btn-primary">Add Patient</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h2>Patient List</h2>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Code</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($patients) > 0): ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo $patient['id']; ?></td>
                                <td><?php echo htmlspecialchars($patient['patient_code']); ?></td>
                                <td><?php echo htmlspecialchars($patient['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                                <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                                <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                                <td><?php echo htmlspecialchars($patient['address']); ?></td>
                                <td class="actions">
                                    <a class="btn btn-warning" href="index.php?action=edit&id=<?php echo $patient['id']; ?>">Edit</a>
                                    <a class="btn btn-danger"
                                       href="index.php?action=delete&id=<?php echo $patient['id']; ?>"
                                       onclick="return confirm('Are you sure you want to delete this patient?');">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">No patient data found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>