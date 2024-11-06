<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    $sql = "INSERT INTO events (title, description, date, time, price, location) VALUES (:title, :description, :date, :time, :price, :location)";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'time' => $time,
            'price' => $price,
            'location' => $location,
        ]);
        $message = "Event created successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Create Event</h1>
    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" class="bg-light p-4 rounded shadow">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Event Title" required>
        </div>
        <div class="form-group">
            <label for="description">Event Description</label>
            <textarea name="description" class="form-control" id="description" placeholder="Event Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" id="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" class="form-control" id="time" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" id="location" placeholder="Location" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" id="price" placeholder="Price" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary btn-block">Create Event</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
