<?php

session_start();

if (isset($_SESSION['user_id']) && $_SESSION['admin'] === 'yes') {
    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages

    $databaseName = "TransportProd"; //SET DATABASE NAME FOR PRODUCTION
    $link = "mysql:host=localhost;dbname=$databaseName;charset=utf8mb4";
    $user = "serveruser";
    $pass = "Car0lina2210!";

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $users = array();

    try {

        //setup connection
        $pdo = new PDO($link, $user, $pass, $options);

        //update user
        if (isset($_POST['username']) && isset($_POST['lname']) && isset($_POST['fname']) &&  isset($_POST['email'])) {

            //set other variables

            if ($_POST['admin'] === 'yes')
                $adminUser = 'yes';
            else
                $adminUser = 'no';

            if ($_POST['enabledUser'] === '1')
                $enabledUser = '1';
            else
                $enabledUser = '0';

            if (strlen(trim($_POST['password'])) > 5)
                $passwordHash = password_hash($_POST['password'],  PASSWORD_DEFAULT);
            else
                $passwordHash = NULL;

            try {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user");
            } catch (Exception $e) {
                echo "Failed to prepare statement 1";
            }

            $stmt->bindValue(':user', $_POST['username'], PDO::PARAM_STR);

            try {
                $stmt->execute();
            } catch (Exception $e) {
                echo "Failed to execute statement";
            }

            $rowcount = $stmt->rowCount();

            if ($rowcount > 0) {

                $user = $stmt->fetch(PDO::FETCH_OBJ);

                //if there is an update to the password do it first otherwise if password is blank move on

                if ($passwordHash != NULL) {
                    $sql3 = "UPDATE `users` SET `password` = :pass  WHERE id = :ID";

                    try {
                        $stmt3 = $pdo->prepare($sql3);
                    } catch (Exception $e) {
                        echo "Failed to prepare statement 3";
                    }

                    $stmt3->bindValue(':pass', $passwordHash, PDO::PARAM_STR);
                    $stmt3->bindValue(':ID', $user->id, PDO::PARAM_STR);


                    try{ 
                        $stmt3->execute();
                        echo "Pass Updated";
                    } catch (Exception $e) {
                        echo "Failed to execute statement";
                        echo "Pass Update Failed";
                    }
    
                } else {
                    echo 'Password Not Updated';
                }

                //sql to update a user
                $sql2 = "UPDATE `users` SET `username` = :users, `email` = :email, `FirstName` = :fname, `LastName` = :lname, `Enabled` = :enabledUser, `admin` = :adminUser WHERE id = :ID";
                $updateokay = TRUE;

            } else {
                //add new user

                if ($passwordHash != NULL){
                    $sql2 = "INSERT INTO `users` ( `username`, `password`, `email`, `FirstName`, `LastName`, `Enabled`, `admin` ) VALUES ( :users, :pass, :email, :fname, :lname, :enabledUser, :adminUser )";
                    $updateokay = TRUE;
                }
                else {
                    echo '<script type="text/javascript">alert("Password Invalid")</script>';
                    $updateokay = FALSE;
                }
            }
            if( $updateokay ) {
                //exeute the add user or update user
                echo $sql2;

                try {
                    $stmt2 = $pdo->prepare($sql2);
                } catch (Exception $e) {
                    echo "Failed to prepare statement 2";
                }
                
                
                $stmt2->bindValue(':users', $_POST['username'], PDO::PARAM_STR);
                $stmt2->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                //$stmt2->bindValue( ':dtime', , PDO::PARAM_STR );
                $stmt2->bindValue(':fname', $_POST['fname'], PDO::PARAM_STR);
                $stmt2->bindValue(':lname', $_POST['lname'], PDO::PARAM_STR);
                if ($rowcount > 0)
                    $stmt2->bindValue(':ID', $user->id, PDO::PARAM_STR);
                
                if ($rowcount < 1)
                    $stmt2->bindValue(':pass', $passwordHash, PDO::PARAM_STR);
                
                $stmt2->bindValue(':enabledUser', $enabledUser, PDO::PARAM_STR);
                $stmt2->bindValue(':adminUser', $adminUser, PDO::PARAM_STR);
                

                try{ 
                    $stmt2->execute();
                    echo "Record Updated";
                } catch (Exception $e) {
                     echo $e->getMessage();
                }
        
                
            }
        }

        if (isset($_POST['userbutton'])) {

            //load form
            try {

                $stmt4 = $pdo->prepare("SELECT * FROM users WHERE username = :user");
            } catch (Exception $e) {
                echo "Failed to prepare statement 1";
            }

            $stmt4->bindValue(':user', $_POST['userbutton'], PDO::PARAM_STR);

            try {
                $stmt4->execute();
            } catch (Exception $e) {
                echo "Failed to execute statement";
            }

            try {
                $stmt4->execute();
            } catch (Exception $e) {
                echo "Failed to execute statement";
            }

            if ($stmt4) {

                //update 
                $userUpdate = $stmt4->fetch(PDO::FETCH_OBJ);
            }
        }

        //default load table - no matter what happens

        try {
            $stmt5 = $pdo->prepare("SELECT * FROM users");
        } catch (Exception $e) {
            echo "Failed to prepare statement 1";
        }

        try {
            $stmt5->execute();
        } catch (Exception $e) {
            echo "Failed to execute statement";
        }


        if ($stmt5) {
            $users = $stmt5->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
} else {

    header("Location: protected.php");
}

?>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User Form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>


<body>
    <div class="jumbotron d-flex align-items-center vh-100">
        <div class="container">

            <header>
                <h1>Oklahoma Trucks Direct Parts & Tires Transport App v2.0 Development</h1>
            </header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="protected.php">Home</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
                            </li>
                        </ul>
                        </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6 text-center">
                    <h2>Add User Form</h2>
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form class="form-control" action="" method="post">
                        <div class="form-outline mb-4">
                            <input class="form-control" type="text" name="username" <?php if (isset($_POST['userbutton'])) {
                                                                                        echo 'value="';
                                                                                        echo $userUpdate->username;
                                                                                        echo '"';
                                                                                    } ?> placeholder="Enter the login name" autocomplete="new-password" required>
                            <input class="form-control" type="password" name="password" placeholder="Enter the new password" autocomplete="new-password">
                            <input class="form-control" type="text" name="lname" <?php if (isset($_POST['userbutton'])) {
                                                                                        echo 'value="';
                                                                                        echo $userUpdate->LastName;
                                                                                        echo '"';
                                                                                    } ?> placeholder="Enter the last name" required>
                            <input class="form-control" type="text" name="fname" <?php if (isset($_POST['userbutton'])) {
                                                                                        echo 'value="';
                                                                                        echo $userUpdate->FirstName;
                                                                                        echo '"';
                                                                                    } ?> placeholder="Enter the first name" required>
                            <input class="form-control" type="text" name="email" <?php if (isset($_POST['userbutton'])) {
                                                                                        echo 'value="';
                                                                                        echo $userUpdate->email;
                                                                                        echo '"';
                                                                                    } ?> placeholder="Enter the e-mail" required>
                            <label for="enabledUser">Enabled? (Check means yes)</label>
                            <input class="form-check-input" type="checkbox" <?php if (isset($_POST['userbutton'])) {
                                                                                if ($userUpdate->Enabled) echo ' checked ';
                                                                            } ?> value="1" name="enabledUser">
                            <label for="admin">Admin User? (Check means yes)</label>
                            <input class="form-check-input" type="checkbox" <?php if (isset($_POST['userbutton'])) {
                                                                                if ($userUpdate->admin === 'yes') echo ' checked ';
                                                                            } ?> value="yes" name="admin">
                        </div>
                        <div class="frm-outline mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Add User</button>
                            <button type="reset" class="btn btn-primary btn-block">Clear</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>