<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

$sql = "SELECT events.* FROM events 
        JOIN registrations ON events.id = registrations.event_id 
        WHERE registrations.user_id = :user_id 
        ORDER BY events.date ASC";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$registered_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Your Registered Events</h1>
    <div class="row">
        <?php if (count($registered_events) > 0): ?>
            <?php foreach ($registered_events as $event): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="events/event_details.php?id=<?= $event['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($event['title']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-2">
                                <?= htmlspecialchars($event['date']) ?> at <?= htmlspecialchars($event['time']) ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars($event['description']) ?></p>
                            <div class="mt-auto">
                                <a href="events/event_details.php?id=<?= $event['id'] ?>" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">You are not registered for any events.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
