<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

$currentPassword = $user["user_password"];
?>

<?php session_start(); ?>

<html lang="en">

<head>
    <title>Bc House</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="./หน้าบ้าน/forgotpassword.css" rel="stylesheet">
</head>

<body style=    "background-color: #E2EDD2;">

    <?php include('ตัวเสริม.php'); ?>

    <div class="frame4">
        <div class="frame3">
            <div class="login">

                <div class="MovetoggleButtons">
                    <img id="eyeIcon" type="button" onclick="togglePasswordVisibility()" src="icon/EyeOpen.png" width="20" height="20" alt="eye">
                </div>

                <div class="MovetoggleButtonn">
                    <img id="eyeIcons" type="button" onclick="togglePasswordVisibilitys()" src="icon/EyeOpen.png" width="20" height="20" alt="eye">
                </div>
                <h2 class="text">Reset Password</h2>
                <h2 class="textcontent">Please enter your desired new password!</h2>
                <br>
                <br>
                <form name="register" action="reset-password-process.php" method="POST" enctype="multipart/form-data" class="form-horizontal" id="signupForm" onsubmit="handleSubmit(event)">
                    <div class="ipg1">
                        <input name="Password" id="Password" class="input" type="password" placeholder="New Password" required>
                        <input name="ConfirmPassword" id="Passwords" class="input" type="password" placeholder="Confirm new password" required>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input type="hidden" name="currentPassword" id="currentPassword" value="<?= htmlspecialchars($currentPassword) ?>">

                        <button type="submit" class="button">
                            <h6 class="fontLogin">Reset Password</h6>
                        </button>

                        <div class="o">
                            <div class="nt">
                                <h4 class="textAm"> Already a member? </h4>
                                <a href="formlogin.php">
                                    <h4 class="textLogin"> Login </h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>

            <div class="logologin">
                <img src="icon/ตัดกรอบ.png" width="550" height="500" alt="logo">
            </div>
        </div>
    </div>

    <script>
        function handleSubmit(event) {
            event.preventDefault();

            const P = document.getElementById('Password').value;
            const CP = document.getElementById('Passwords').value;
            const currentPassword = document.getElementById('currentPassword').value;

            if (P != CP) {
                alert('Password do not match!');
                return;
            }

            if (P === currentPassword) {
                alert("The new password can't be the same as the current password.");
                return;
            }

            

            if (P.length < 6) {
                alert('Password must contain at least 6 characters.');
                return;
            }
            event.target.submit();
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('Password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.src = 'icon/EyeClosed.png';
            } else {
                passwordInput.type = 'password';
                eyeIcon.src = 'icon/EyeOpen.png';
            }
        }

        function togglePasswordVisibilitys() {
            const passwordInput = document.getElementById('Passwords');
            const eyeIcon = document.getElementById('eyeIcons');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.src = 'icon/EyeClosed.png';
            } else {
                passwordInput.type = 'password';
                eyeIcon.src = 'icon/EyeOpen.png';
            }
        }
    </script>

    <script src="login/js/jquery.min.js"></script>
    <script src="login/js/popper.js"></script>
    <script src="login/js/bootstrap.min.js"></script>
    <script src="login/js/main.js"></script>

</body>

</html>