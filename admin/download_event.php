<?php
require_once '../vendor/autoload.php'; 

session_start();
include '../includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}


$event_id = $_GET['id']; 

$event_sql = "SELECT title, description, date, time, location, price FROM events WHERE id = :event_id";
$event_stmt = $conn->prepare($event_sql);
$event_stmt->execute(['event_id' => $event_id]);
$event = $event_stmt->fetch(PDO::FETCH_ASSOC);


$users_sql = "SELECT users.name, users.email FROM registrations 
              JOIN users ON registrations.user_id = users.id 
              WHERE registrations.event_id = :event_id";
$users_stmt = $conn->prepare($users_sql);
$users_stmt->execute(['event_id' => $event_id]);
$registered_users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);


$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Event Details', 0, 1, 'C');
$pdf->Ln(10);

if ($event) {
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Title: ' . htmlspecialchars($event['title']), 0, 1);
    $pdf->Cell(0, 10, 'Description: ' . htmlspecialchars($event['description']), 0, 1);
    $pdf->Cell(0, 10, 'Date: ' . htmlspecialchars($event['date']), 0, 1);
    $pdf->Cell(0, 10, 'Time: ' . htmlspecialchars($event['time']), 0, 1);
    $pdf->Cell(0, 10, 'Location: ' . htmlspecialchars($event['location']), 0, 1);
    $pdf->Cell(0, 10, 'Price: $' . number_format($event['price'], 2), 0, 1);
    $pdf->Ln(10);
    
    
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Registered Users', 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    
    if (count($registered_users) > 0) {
        foreach ($registered_users as $user) {
            $pdf->Cell(0, 10, 'Name: ' . htmlspecialchars($user['name']) . ', Email: ' . htmlspecialchars($user['email']), 0, 1);
        }
    } else {
        $pdf->Cell(0, 10, 'No users registered for this event.', 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'Event not found.', 0, 1);
}


$pdf->Output('event_details_' . $event_id . '.pdf', 'D');
exit;
?>
