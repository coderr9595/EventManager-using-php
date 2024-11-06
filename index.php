<?php
session_start();
include 'includes/db.php';
$sql = "SELECT * FROM events ORDER BY date DESC LIMIT 4";
$stmt = $conn->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Events</h5>
                    <p class="display-6"><?= count($events) ?> </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Upcoming Events</h5>
                    <p class="display-6"><?= count(array_filter($events, fn($e) => $e['date'] >= date('Y-m-d'))) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Attendees</h5>
                    <p class="display-6">123 </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Past Events</h5>
                    <p class="display-6"><?= count(array_filter($events, fn($e) => $e['date'] < date('Y-m-d'))) ?></p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Recent Events</h2>
    <div class="row">
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="events/event_details.php?id=<?= $event['id'] ?>" class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($event['title']) ?>
                                </a>
                            </h5>
                            <p class="text-muted mb-1"><?= htmlspecialchars($event['date']) ?> at <?= htmlspecialchars($event['time']) ?></p>
                            <p class="text-muted">Location: <?= htmlspecialchars($event['location']) ?></p>
                            <p class="card-text"><?= htmlspecialchars(substr($event['description'], 0, 60)) ?>...</p>
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
                <div class="alert alert-info text-center">No recent events available.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
