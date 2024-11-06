<?php
session_start();
include '../includes/db.php';

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

$event_price = $event['price'];
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">
            <h1>Payment for <?= htmlspecialchars($event['title']) ?></h1>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($event['time']) ?></p>
                <p><strong>Price:</strong> $<?= number_format($event_price, 2) ?></p>
                <p><?= htmlspecialchars($event['description']) ?></p>
            </div>
            <div class="text-center">
                <form action="register_event.php?id=<?= $event_id ?>" method="POST">
                    <button type="submit" class="btn btn-success btn-lg mb-2">Pay Now</button>
                </form>
                <a href="event_details.php?id=<?= $event_id ?>" class="btn btn-danger btn-lg">Cancel</a>
            </div>
        </div>
        <div class="card-footer text-muted text-center">
            Secure payment powered by Event Manager
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
