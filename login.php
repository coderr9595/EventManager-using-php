<?php 
session_start(); 
include 'includes/db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {     
    $email = $_POST['email']; 
    $password = $_POST['password'];      

    $sql = "SELECT * FROM users WHERE email = :email"; 
    $stmt = $conn->prepare($sql);     
    $stmt->bindParam(':email', $email); 
    $stmt->execute();     
    $user = $stmt->fetch(PDO::FETCH_ASSOC);      

    if ($user && password_verify($password, $user['password'])) {         
        $_SESSION['user'] = [             
            'id' => $user['id'],             
            'name' => $user['name'],             
            'email' => $user['email'],             
            'role' => $user['role']         
        ];         
        header('Location: index.php');         
        exit;     
    } else {         
        $error = "Invalid email or password.";     
    } 
} 
?> 

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
