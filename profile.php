<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">User Profile</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Welcome, <?= htmlspecialchars($user['name']) ?></h4>
                    
                    <div class="mb-3">
                        <strong>Name:</strong>
                        <p><?= htmlspecialchars($user['name']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Email:</strong>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Role:</strong>
                        <p><?= htmlspecialchars($user['role']) ?></p> <!-- Assuming 'role' column exists -->
                    </div>

                    
                    
                    <div class="mb-3">
                        <strong>About Me:</strong>
                        <p>Passion For Events</p> 
                    </div>

                    <div class="text-center mt-4">
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
