<?php
/**
 * User Profile Page
 * Display and edit user profile information
 */

require_once 'functions.php';

// Require login - redirect if not authenticated
requireLogin();

$user_id = getCurrentUser();
$user = getUserById($user_id);

if (!$user) {
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

$edit_mode = isset($_GET['edit']) && $_GET['edit'] === 'true';
$errors = [];
$success = false;

/**
 * Safe date formatter (prevents 1970 + avoids strtotime(null) deprecated)
 */
function formatDateOrNA($dt, $format = 'F d, Y H:i') {
    if (empty($dt)) return 'N/A';
    $ts = strtotime($dt);
    if ($ts === false) return 'N/A';
    return date($format, $ts);
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'update_bio') {
        $bio = sanitizeInput($_POST['bio'] ?? '');

        // Validate bio
        if (strlen($bio) > 500) {
            $errors['bio'] = 'Bio must be less than 500 characters';
        } else {
            // Update bio + updated_at
            $sql = "UPDATE users SET bio = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $bio, $user_id);

            if ($stmt->execute()) {
                $success = 'Bio updated successfully!';
                // Reload user to get updated_at fresh
                $user = getUserById($user_id);
            } else {
                $errors['bio'] = 'Failed to update bio. Please try again.';
            }

            $stmt->close();
        }
    }

    elseif ($_POST['action'] === 'upload_avatar') {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
            if (isValidImage($_FILES['avatar'])) {

                // Delete old avatar
                if (!empty($user['avatar'])) {
                    deleteAvatar($user['avatar']);
                }

                // Upload new avatar
                $new_avatar = uploadAvatar($_FILES['avatar'], $user_id);

                if ($new_avatar) {
                    // Update avatar + updated_at
                    $sql = "UPDATE users SET avatar = ?, updated_at = NOW() WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('si', $new_avatar, $user_id);

                    if ($stmt->execute()) {
                        $success = 'Avatar updated successfully!';
                        // Reload user to get avatar + updated_at fresh
                        $user = getUserById($user_id);
                    } else {
                        $errors['avatar'] = 'Failed to update avatar. Please try again.';
                    }

                    $stmt->close();
                } else {
                    $errors['avatar'] = 'Failed to upload avatar. Please try again.';
                }

            } else {
                $errors['avatar'] = '❌ Invalid image file. Only JPG, PNG, GIF, and WebP are allowed (Max 5MB).';
            }
        } else {
            $errors['avatar'] = '❌ Please select a valid image file.';
        }
    }
}

// Member since (safe)
$member_since = 'N/A';
if (!empty($user['created_at'])) {
    $member_since = formatDateOrNA($user['created_at'], 'F d, Y');
}

// Last updated (fallback to created_at if updated_at missing)
$last_updated = 'N/A';
$dt_for_last_updated = $user['updated_at'] ?? $user['created_at'] ?? null;
$last_updated = formatDateOrNA($dt_for_last_updated, 'F d, Y H:i');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mini App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                <i class="fa-solid fa-user-circle"></i>
                Mini App
            </a>
            <div class="navbar-actions">
                <a href="logout.php" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <!-- Profile Header -->
            <div class="profile-header">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?php echo escapeHTML($user['avatar']); ?>" alt="Profile" class="avatar-large">
                <?php else: ?>
                    <div class="avatar-default">
                        <i class="fa-solid fa-user"></i>
                    </div>
                <?php endif; ?>

                <h1 class="profile-title"><?php echo escapeHTML($user['username'] ?? ''); ?></h1>
                <p class="profile-email"><?php echo escapeHTML($user['email'] ?? ''); ?></p>

                <div class="profile-actions">
                    <?php if (!$edit_mode): ?>
                        <a href="?edit=true" class="btn btn-primary">
                            <i class="fa-solid fa-edit"></i> Edit Profile
                        </a>
                    <?php else: ?>
                        <a href="profile.php" class="btn btn-secondary">
                            <i class="fa-solid fa-times"></i> Cancel
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Information Section -->
                <div class="profile-section">
                    <div class="profile-section-header">
                        <i class="fa-solid fa-info-circle"></i>
                        Account Information
                    </div>
                    <div class="profile-section-body">
                        <div class="profile-info-group">
                            <div class="profile-info-label">Username</div>
                            <div class="profile-info-value"><?php echo escapeHTML($user['username'] ?? ''); ?></div>
                        </div>

                        <div class="profile-info-group">
                            <div class="profile-info-label">Email</div>
                            <div class="profile-info-value"><?php echo escapeHTML($user['email'] ?? ''); ?></div>
                        </div>

                        <div class="profile-info-group">
                            <div class="profile-info-label">Member Since</div>
                            <div class="profile-info-value"><?php echo $member_since; ?></div>
                        </div>

                        <div class="profile-info-group">
                            <div class="profile-info-label">Last Updated</div>
                            <div class="profile-info-value"><?php echo $last_updated; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Edit Section -->
                <?php if ($edit_mode): ?>
                    <div class="profile-section">
                        <div class="profile-section-header">
                            <i class="fa-solid fa-camera"></i>
                            Upload Avatar
                        </div>
                        <div class="profile-section-body">
                            <?php if (!empty($success) && strpos($success, 'Avatar') !== false): ?>
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div><?php echo $success; ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errors['avatar'])): ?>
                                <div class="alert alert-error">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    <div><?php echo $errors['avatar']; ?></div>
                                </div>
                            <?php endif; ?>

                            <form method="POST" enctype="multipart/form-data" class="avatar-upload-wrapper">
                                <input type="hidden" name="action" value="upload_avatar">

                                <label class="avatar-upload">
                                    <div class="avatar-upload-box">
                                        <div class="avatar-upload-icon">
                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                        </div>
                                        <div class="avatar-upload-text">
                                            <strong>Click to upload</strong> or drag and drop
                                        </div>
                                        <div class="avatar-upload-hint">
                                            JPG, PNG, GIF, WebP (Max 5MB)
                                        </div>
                                    </div>
                                    <input type="file" name="avatar" accept="image/*" required>
                                </label>

                                <?php if (!empty($user['avatar'])): ?>
                                    <div class="avatar-preview">
                                        <p style="color: var(--gray-500); font-size: 0.85rem; margin-bottom: 0.5rem;">Current Avatar:</p>
                                        <img src="<?php echo escapeHTML($user['avatar']); ?>" alt="Current avatar">
                                    </div>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-success btn-block mt-3">
                                    <i class="fa-solid fa-upload"></i> Upload Avatar
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="profile-section">
                        <div class="profile-section-header">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit Bio
                        </div>
                        <div class="profile-section-body">
                            <?php if (!empty($success) && strpos($success, 'Bio') !== false): ?>
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <div><?php echo $success; ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errors['bio'])): ?>
                                <div class="alert alert-error">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    <div><?php echo $errors['bio']; ?></div>
                                </div>
                            <?php endif; ?>

                            <form method="POST">
                                <input type="hidden" name="action" value="update_bio">

                                <div class="form-group">
                                    <label for="bio">
                                        <i class="fa-solid fa-pen"></i> Your Bio
                                    </label>
                                    <textarea
                                        id="bio"
                                        name="bio"
                                        placeholder="Tell us about yourself... (Max 500 characters)"
                                        maxlength="500"
                                    ><?php echo escapeHTML($user['bio'] ?? ''); ?></textarea>
                                    <div class="form-help">
                                        <span id="char-count">0</span>/500 characters
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-block">
                                    <i class="fa-solid fa-save"></i> Save Bio
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- View Mode Bio Section -->
                    <div class="profile-section">
                        <div class="profile-section-header">
                            <i class="fa-solid fa-book"></i>
                            About
                        </div>
                        <div class="profile-section-body">
                            <?php if (!empty($user['bio'])): ?>
                                <div class="profile-bio">
                                    <?php echo nl2br(escapeHTML($user['bio'])); ?>
                                </div>
                            <?php else: ?>
                                <div class="profile-bio profile-bio-empty">
                                    <i class="fa-solid fa-message"></i> No bio yet.
                                    <a href="?edit=true" style="color: var(--primary); font-weight: 600;">Add one now</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Mini App. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Character counter for bio
        const bioTextarea = document.getElementById('bio');
        const charCount = document.getElementById('char-count');

        if (bioTextarea && charCount) {
            bioTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
            charCount.textContent = bioTextarea.value.length;
        }

        // Drag and drop for avatar upload
        const avatarUpload = document.querySelector('.avatar-upload');
        if (avatarUpload) {
            const avatarUploadBox = avatarUpload.querySelector('.avatar-upload-box');
            const fileInput = avatarUpload.querySelector('input[type="file"]');

            avatarUploadBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                avatarUploadBox.style.borderColor = 'var(--primary)';
                avatarUploadBox.style.backgroundColor = '#eff6ff';
            });

            avatarUploadBox.addEventListener('dragleave', () => {
                avatarUploadBox.style.borderColor = 'var(--gray-300)';
                avatarUploadBox.style.backgroundColor = 'var(--gray-50)';
            });

            avatarUploadBox.addEventListener('drop', (e) => {
                e.preventDefault();
                avatarUploadBox.style.borderColor = 'var(--gray-300)';
                avatarUploadBox.style.backgroundColor = 'var(--gray-50)';

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                }
            });
        }
    </script>
</body>
</html>