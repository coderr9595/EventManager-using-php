<?php
session_start();
include '../includes/db.php';
include '../includes/header.php'; 

$event_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

$sql = "INSERT INTO registrations (user_id, event_id) VALUES (:user_id, :event_id)";
$stmt = $conn->prepare($sql);
$stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
            <h1>Registration Successful!</h1>
        </div>
        <div class="card-body text-center">
            <p>You have been successfully registered for the event.</p>
            <p class="font-weight-bold">Event ID: <?= htmlspecialchars($event_id) ?></p>
            <a href="http://localhost/EventManager/index.php" class="btn btn-primary btn-lg">Go to Dashboard</a>
        </div>
        <div class="card-footer text-muted text-center">
            Thank you for registering! We look forward to seeing you at the event.
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
