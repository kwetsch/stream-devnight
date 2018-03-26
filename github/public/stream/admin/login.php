<?php
require_once 'includes/config.php';
$username     = $password = "";
$username_err = $password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = 'Bitte gebe Deinen Benutzernamen ein.';
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST['password']))) {
        $password_err = 'Bitte gebe Dein Passwort ein.';
    } else {
        $password = trim($_POST['password']);
    }
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT username, password FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $param_username = trim($_POST["username"]);
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);
            if ($result = $stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) == 1) {
                    $row             = $result[0];
                    $hashed_password = $row['password'];
                    if (password_verify($password, $hashed_password)) {
                        session_start();
                        $_SESSION['username'] = $username;
                        header("location: index.php");
                    } else {
                        $password_err = 'Das eingegebene Passwort ist ungültig.';
                    }
                } else {
                    $username_err = 'Kein Account mit dem Benutzer gefunden.';
                }
            } else {
                echo "Oops! Etwas ist schief gelaufen. Bitte probiere es erneut.";
            }
        }
        unset($stmt);
    }
    unset($pdo);
}
?>
<? include 'includes/head.php';?>
<body>
<div style="height: 100vh">
    <div class="flex-center flex-column">
        <h1 class="animated fadeIn mb-4">/dev/night | ADMIN - Login</h1>
        <h5 class="animated fadeIn mb-3">Bitte logge Dich ein, um als Admin bei /dev/night zu arbeiten.</h5>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Benutzername</label>
                    <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Passwort</label>
                    <input type="password" name="password" class="form-control">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
        <p>Du hast keinen Account? <a href="mailto:kaw@tradebyte.biz?subject=Anfordern%20Login-Daten%20der%20/dev/night - Admin Seite&amp;body=Name:%20%0D%0A%0D%0AEmail:">Anfordern</a></p>
        </form>
    </div>
</div>
<? include 'includes/scripts.php';?>
</body>
</html>
