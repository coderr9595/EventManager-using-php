<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']['id'])) {
    echo "User is not logged in.";
    exit;
}

$event_id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

$sql = "SELECT * FROM events WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch();

if (!$event) {
    echo "Event not found.";
    exit;
}

$registration_sql = "SELECT * FROM registrations WHERE user_id = :user_id AND event_id = :event_id";
$reg_stmt = $conn->prepare($registration_sql);
$reg_stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
$is_registered = $reg_stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_booking'])) {
    $event_time = strtotime($event['date'] . ' ' . $event['time']);
    $current_time = time();
    $time_remaining = $event_time - $current_time;

    if ($time_remaining > 86400) {
        echo "<script>alert('Your booking has been canceled. A refund will be processed.');</script>";
        
        $delete_sql = "DELETE FROM registrations WHERE user_id = :user_id AND event_id = :event_id";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->execute(['user_id' => $user_id, 'event_id' => $event_id]);
        
    } else {
        echo "<script>alert('You cannot cancel this booking less than 24 hours before the event.');</script>";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h1 class="text-center"><?= htmlspecialchars($event['title']) ?></h1>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
                <p><strong>Price:</strong> $<?= htmlspecialchars($event['price']) ?></p>
            </div>

            <?php if ($is_registered): ?>
                <div class="alert alert-info text-center">You are already registered for this event.</div>
                <form method="POST" class="text-center">
                    <button type="submit" name="cancel_booking" class="btn btn-danger">Cancel Booking</button>
                </form>
            <?php else: ?>
                <form action="payment.php?id=<?= $event_id ?>" method="POST" class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            <?php endif; ?>
        </div>
        <div class="card-footer text-muted text-center">
            Thank you for choosing our events.
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
