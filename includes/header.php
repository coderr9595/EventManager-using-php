<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <style>
        .btn-logout {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: darkred;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/EventManager/index.php">Event Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost/EventManager/admin/create_event.php">Create Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="http://localhost/EventManager/admin/manage_events.php">Manage Events</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/myevent.php">My Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/profile.php"><?= htmlspecialchars($_SESSION['user']['name']) ?></a>
                    </li>
                    <li class="nav-item">
                        <form action="http://localhost/EventManager/logout.php" method="POST" style="display: inline;">
                            <button type="submit" class="btn-logout">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/EventManager/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
    <div class="flex-grow-1">