<?php
session_start();

if (!isset($_SESSION['user_id'])) {

    // Redirect them to the login page
    header("Location: index.php");
} else {

    // Extend cookie life time by an amount of your liking
    $cookieLifetime = 6 * 60 * 60; // 6 hours in seconds
    setcookie(session_name(), session_id(), time() + $cookieLifetime);


    $databaseName = "TransportProd"; //SET DATABASE NAME FOR PRODUCTION
    $link = "mysql:host=localhost;dbname=$databaseName;charset=utf8mb4";
    $user = "serveruser";
    $pass = "Car0lina2210!";

    $users = array();

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($link, $user, $pass, $options);

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE Enabled = '1'");
        } catch (Exception $e) {
            echo "Failed to prepare statement 1";
        }

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo "Failed to execute statement";
        }


        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="stylesheets/media.css" />

    <title>Oklahoma Trucks Direct Parts & Tires Transport v2.0</title>

</head>

<body>
    <div class="container d-flex flex-column vh-100 mh-100 vw-98 mw-98 overflow-hidden">
        <div class="row flex-shrink-1 vh-10 mh-10">

            <header>
                <h1>Oklahoma Trucks Direct Parts & Tires Transport App v2.7</h1>
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
                            <?PHP
                            if ($_SESSION['admin'] === 'yes')
                                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="3" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        User Manager
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="adduser.php">Add User</a></li>
                    </ul>
                    </li>';
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row flex-grow-1 formwithscrolls">
            <div id="col-left" class="col-xl-6 formscrollbars">
                <form data-transport-order="form">
                    <button type="button" data-transport-order="reportButton" class="btn btn-primary">Print Form</button>

                    <div class="form-group">
                        <label for="TransportOrder">Invoice No.</label>
                        <input class="form-control" name="ID" id="Invoice" Value="New Order" readonly>
                        <label for="TransportOrder">Date</label>
                        <input type="date" class="form-control" name="TransportDate" id="TransportDate" autofocus required>
                        <lablel for="TransportOrder">Assigned Driver</lablel>
                        <?PHP
                        if ($_SESSION['admin'] === 'yes') {
                            echo '<select class="form-select" id="driverUser" name="driverUser" data-transport-order="driverUser">
              <option selected value="">None</option>';

                            echo $users[0]['username'];
                            for ($i = 0; $i < count($users); $i++) {
                                echo '<option value="';
                                echo $users[$i]['username'];
                                echo '">';
                                echo $users[$i]['LastName'];
                                echo ', ';
                                echo $users[$i]['FirstName'];
                                echo '</option>';
                            }

                            echo '</select>';
                        } else {
                            echo '<input class="form-control" id="driverUser" id="driverUser" name="driverUser" data-transport-order="driverUser" value="';
                            echo $_SESSION['user_id'];
                            echo '" readonly>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="TransportOrder">Ship From:</label><BR>
                        <label for="TransportOrder">Name</label>
                        <input class="form-control" name="TransportFrom" id="TransportFrom" required>
                        <label for="TransportOrder">Address</label>
                        <input class="form-control" name="TransportFromAddress" id="TransportFromAddress" required>
                        <label for="TransportOrder">City/State/Zip</label>
                        <input class="form-control" name="TransportFromCityStateZip" id="TransportFromCityStateZip" required>
                    </div>

                    <div class="form-group">
                        <label for="TransportOrder">Ship To:</label><BR>
                        <label for="TransportOrder">Name</label>
                        <input class="form-control" name="TransportTo" id="TransportTo" required>
                        <label for="TransportOrder">Address</label>
                        <input class="form-control" name="TransportToAddress" id="TransportToAddress" required>
                        <label for="TransportOrder">City/State/Zip</label>
                        <input class="form-control" name="TransportToCityStateZip" id="TransportToCityStateZip" required>
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 1:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car1Year" id="Car1Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car1Make" id="Car1Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car1Model" id="Car1Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car1Color" id="Car1Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car1Serial" id="Car1Serial">
                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car1Price" id="Car1Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car1Eraser" data-transport-order="Car1Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car1Draw" name="Car1Draw" data-transport-order="Car1Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car1Img" name="Car1Img" data-transport-order="Car1Img"><br>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car1Stock" id="Car1Stock">
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 2:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car2Year" id="Car2Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car2Make" id="Car2Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car2Model" id="Car2Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car2Color" id="Car2Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car2Serial" id="Car2Serial">
                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car2Price" id="Car2Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car2Eraser" data-transport-order="Car2Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car2Draw" name="Car2Draw" data-transport-order="Car2Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car2Img" name="Car2Img" data-transport-order="Car2Img"><br>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car2Stock" id="Car2Stock">
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 3:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car3Year" id="Car3Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car3Make" id="Car3Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car3Model" id="Car3Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car3Color" id="Car3Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car3Serial" id="Car3Serial">
                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car3Price" id="Car3Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car3Eraser" data-transport-order="Car3Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car3Draw" name="Car3Draw" data-transport-order="Car3Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car3Img" name="Car3Img" data-transport-order="Car3Img"><br>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car3Stock" id="Car3Stock">
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 4:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car4Year" id="Car4Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car4Make" id="Car4Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car4Model" id="Car4Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car4Color" id="Car4Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car4Serial" id="Car4Serial">
                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car4Price" id="Car4Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car4Eraser" data-transport-order="Car4Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car4Draw" name="Car4Draw" data-transport-order="Car4Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car4Img" name="Car4Img" data-transport-order="Car4Img"><br>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car4Stock" id="Car4Stock">
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 5:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car5Year" id="Car5Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car5Make" id="Car5Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car5Model" id="Car5Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car5Color" id="Car5Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car5Serial" id="Car5Serial">

                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car5Price" id="Car5Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car5Eraser" data-transport-order="Car5Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car5Draw" name="Car5Draw" data-transport-order="Car5Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car5Img" name="Car5Img" data-transport-order="Car5Img"><br>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car5Stock" id="Car5Stock">
                    </div>

                    <div class="form-group">
                        <BR>
                        <h3><label for="TransportOrder">Car 6:</label></h3>
                        <label for="TranportOrder">Year</label>
                        <input class="form-control" name="Car6Year" id="Car6Year">
                        <label for="TranportOrder">Make</label>
                        <input class="form-control" name="Car6Make" id="Car6Make">
                        <label for="TranportOrder">Model</label>
                        <input class="form-control" name="Car6Model" id="Car6Model">
                        <label for="TranportOrder">Color</label>
                        <input class="form-control" name="Car6Color" id="Car6Color">
                        <label for="TranportOrder">Serial No. (Last 8)</label>
                        <input class="form-control" name="Car6Serial" id="Car6Serial">
                        <label for="TranportOrder">Price</label>
                        <input class="form-control" name="Car6Price" id="Car6Price">
                        <label for="TransportOrder">Damage: </label>
                        <button type="button" id="Car6Eraser" data-transport-order="Car6Eraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="Car6Draw" name="Car6Draw" data-transport-order="Car6Draw" width="500" height="350" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="Car6Img" name="Car6Img" data-transport-order="Car6Img"><BR>
                        <label for="TranportOrder">Notes/Stock No.</label>
                        <input class="form-control" name="Car6Stock" id="Car6Stock">
                    </div>
                    <div class="form-group">
                        <label for="TransportOrder" class="form-check-label">Completed:</label>
                        <input type="hidden" name="CompletedHidden" id="CompletedHidden" data-transport-order="completedUnCheck" value="0">
                        <input type="checkbox" name="Completed" id="Completed" data-transport-order="completedCheck" class="form-check-input" value="1" <?PHP if ($_SESSION['admin'] != 'yes') echo ' disabled="disabled" '; ?>>
                    </div>

                    <div class="form-group">
                        <label for="canvasForSig">Driver's Signature: </label>
                        <button type="button" id="DriverEraser" data-transport-order="DriverEraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="DriverDraw" name="DriverDraw" data-transport-order="DriverDraw" width="510" height="125" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="DriverImg" name="DriverImg" data-transport-order="DriverImg">
                    </div>

                    <div class="form-group">
                        CONSIGNEE AGREES TO THE CONDITION OF THE VEHICLE, RATE, TERMS & CONDITIONS<BR><BR>
                    </div>

                    <div class="form-group">
                        THE SHIPPER HAS SHIPPED THE ABOVE LISTED VEHICLE WITH THE ABOVE NOTED DAMAGE OR HAS
                        MADE SUCH EXCEPTIONS ON INSPECTION SHEETS<BR>
                        <label for="canvasForSig">Shipper's Signature: </label>
                        <button type="button" id="ShipperEraser" data-transport-order="ShipperEraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="ShipperDraw" name="ShipperDraw" data-transport-order="ShipperDraw" width="510" height="125" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="ShipperImg" name="ShipperImg" data-transport-order="ShipperImg">
                        <BR><label for="TransportOrder">Date:</label>
                        <input type="date" class="form-control" name="ShipperDate" id="ShipperDate">
                    </div>

                    <div class="form-group">
                        THE RECEIVER HAS RECIEVED THE ABOVE LISTED VEHICLE WITH NO TRANSPORTATION DAMAGE NOTED OR HAS
                        MADE SUCH EXCEPTIONS ON INSPECTION SHEETS<BR>
                        <label for="canvasForSig">Receiver's Signature: </label>
                        <button type="button" id="ReceiverEraser" data-transport-order="ReceiverEraser" class="btn btn-primary">UNDO</button><br>
                        <canvas id="ReceiverDraw" name="ReceiverDraw" data-transport-order="ReceiverDraw" width="510" height="125" style="border:1px solid #000000;"></canvas>
                        <input type="hidden" id="ReceiverImg" name="ReceiverImg" data-transport-order="ReceiverImg">
                        <BR><label for="TransportOrder">Date:</label>
                        <input type="date" class="form-control" name="ReceiverDate" id="ReceiverDate">

                    </div>
                    <BR>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                    <button type="button" data-transport-order="reportButton2" class="btn btn-primary">Print Form</button>

                    <BR>
                </form>
            </div>

            <div id="col-right" class="col-xl-6 formscrollbars">

                <h4>Pending Orders:</h4>
                <div data-transport-order="jobfilter">
                    <input type="text" id="filtersearch" data-transport-order="SearchField" placeholder="Search for jobs..">
                </div>
                <table class="table table-sm table-striped" data-transport-order="JobTable">
                    <col style="width:10%">
                    <col style="width:20%">
                    <col style="width:30%">
                    <col style="width:30%">
                    <col style="width:10%">
                    <tbody data-transport-order="checklist" id="jobTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/checklist.js.php" charset="utf-8"></script>
    <script src="scripts/report.js.php" charset="utf-8"></script>
    <script src="scripts/formhandler.js.php" charset="utf-8"></script>
    <script src="scripts/datastore.js.php" charset="utf-8"></script>
    <script src="scripts/remotedatastore.js.php" charset="utf-8"></script>
    <script src="scripts/truck.js.php" charset="utf-8"></script>
    <script src="scripts/damagedraw.js.php" charset="utf-8"></script>
    <script src="scripts/filterjobs.js.php" charset="utf-8"></script>
    <script src="scripts/main.js.php" charset="utf-8"></script>

</body>

</html>