<!--2572024 - Audrick Estrello-->
<?php 
session_start();
include "connect.php";

$pass = filter_input(INPUT_POST, 'pass');
if (isset($_POST['btnlogin'])) {
    $username = filter_input(INPUT_POST, 'emane');
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $usn = $stmt->fetch();

    if ($usn && password_verify($pass, $usn['password'])) {
        $_SESSION['username'] = $usn['username'];
        header("Location: dashboard.php");
    } else {
    }
}

if (isset($_POST['btnregis'])) {
    $usaname = filter_input(INPUT_POST, 'uname');
    $email = filter_input(INPUT_POST, 'emal');
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$usaname, $email]);
    $search = $stmt->fetch();

    if ($search){
        echo "<div class='card wrong'>Email sudah terdaftar.</div>";
    } else{
        $hashPassword = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$usaname, $email, $hashPassword]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginRegister-2572024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { 
            min-height: 100vh;
        }

        .wrong{
            background-color: rgba(200, 10, 5, 100);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="container d-flex row gap-3">
        <div class="card text-center p-3" id="loh">
            <h2>Login</h2>
            <form action="" method="post" class="text-start">
                <p>Email / Username</p>
                <input type="text" name="emane" class="w-100">
                <br>
                <p>Password</p>
                <input type="password" name="pass" class=" w-100">
                <br>
                <input type="submit" name="btnlogin" class="btn btn-success w-100 mt-2" value="Login">
            </form>
            <p>Belum punya akun? <a href="#" id="toreg">Register</a></p>
        </div>
        <div class="card text-center p-3" id="regi">
            <h2>Register</h2>
            <form action="" method="post" class="text-start">
                <p>Username</p>
                <input type="text" name="uname" class="w-100">
                <br>
                <p>Email</p>
                <input type="email" name="emal" class="w-100">
                <br>
                <p>Password</p>
                <input type="password" name="pass" class=" w-100">
                <br>
                <input type="submit" name="btnregis" class="btn btn-primary w-100 mt-2" value="Register">
            </form>
            <p>Sudah punya akun? <a href="#" id="tuloh">Login</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const regi = document.getElementById('regi');
        const loh = document.getElementById('loh');
        regi.style.display = "none";

        const toreg = document.getElementById('toreg');
        const tuloh = document.getElementById('tuloh');

        toreg.addEventListener('click', function(event) {
            event.preventDefault(); 
            
            swapplace();
        });

        tuloh.addEventListener('click', function(event) {
            event.preventDefault(); 
            
            swapplace();
        });

        function swapplace() {
            if (regi.checkVisibility()){
                loh.style.display = "block";
                regi.style.display = "none";
            } else {
                loh.style.display = "none";
                regi.style.display = "block";
            }
        }
    </script>
</body>
</html>