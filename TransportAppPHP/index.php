<?php
// Always start this first
session_start();
error_reporting(0);


if (isset($_SESSION['user_id'])) {
    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages

    header("Location: protected.php");
} else {
    if (!empty($_POST)) {
        if (isset($_POST['username']) && isset($_POST['password'])) {

            $databaseName = "TransportProd"; //SET DATABASE NAME FOR PRODUCTION
            $link = "mysql:host=localhost;dbname=$databaseName;charset=utf8mb4";
            $user = "serveruser";
            $pass = "Car0lina2210!";

            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $pdo = new PDO($link, $user, $pass, $options);
                try {
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user");
                } catch (Exception $e) {
                    echo "Failed to prepare statement";
                }
                $stmt->bindValue(':user', $_POST['username'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                } catch (Exception $e) {
                    echo "Failed to execute statement";
                }
                if ($stmt)
                    $user = $stmt->fetch(PDO::FETCH_OBJ);
                else $user = "None";
            } catch (Exception $e) {
                echo "Failed database lookup";
            }
            
            //Verify user password and set $_SESSION
            if (password_verify($_POST['password'], $user->password) && $user->Enabled == 1 ) {
                $_SESSION['user_id'] = $user->username;
                $_SESSION['admin'] = $user->admin;
                header("Location: protected.php");
            } else {
                //IF NOT, Display the message below
                echo '<script type="text/javascript">alert("Invalid Credentials")</script>';
            }

        }
    }
}

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>



<div class="jumbotron d-flex align-items-center vh-100">
    <div class="container">

        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <h1> Login </h1>
            </div>
            <div class="col">
            </div>
        </div>
        <div class="row">
            <div class="col">
            </div>
            <div class="col">
                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <input type="text" name="username" class="form-control" />
                        <label class="form-label" for="username">Login Name</label>
                    </div>
                    <div class="frm-outline mb-4">
                        <input type="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                    </div>
                    <div class="frm-outline mb-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                    </div>
                </form>
            </div>
            <div class="col">
            </div>
        </div>

    </div>
</div>

</body>

</html>