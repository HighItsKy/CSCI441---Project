<?PHP
session_start();
error_reporting(0);

//check if logged in

if (true) {//(isset($_SESSION['user_id'])) {
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

    try {
        $pdo = new PDO($link, $user, $pass, $options);


        $GetID = $_GET['ID'];

        $PostID = $_POST['ID'];
    
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $GetID === NULL) {

            // This SQL statement selects ALL from the table 'Locations'
            // This SQL statement selects ALL from the table 'Locations'
            if ($_SESSION['admin'] === 'yes') {
                $sql = "SELECT ID, TransportDate, TransportTo, TransportFrom, Car1Serial, Car1Stock, Car2Serial, Car2Stock, Car3Serial, Car3Stock, Car4Serial, Car4Stock, Car5Serial, Car5Stock, Car6Serial, Car6Stock, Completed FROM TransportJobs ORDER BY ID ASC";
                try {
                    $stmt = $pdo->prepare($sql);
                } catch (Exception $e) {
                    echo "Failed to prepare statement";
                }
            } else {
                $sql = "SELECT ID, TransportDate, TransportTo, TransportFrom, Car1Serial, Car1Stock, Car2Serial, Car2Stock, Car3Serial, Car3Stock, Car4Serial, Car4Stock, Car5Serial, Car5Stock, Car6Serial, Car6Stock, Completed FROM TransportJobs WHERE driverUser = :driverUser ORDER BY ID ASC";
                try {
                    $stmt = $pdo->prepare($sql);
                } catch (Exception $e) {
                    echo "Failed to prepare statement";
                }
                $stmt->bindValue(':driverUser', $_SESSION['user_id'], PDO::PARAM_STR);
            }

            try {

                $stmt->execute();
            } catch (Exception $e) {
                echo "Failed to prepare statement";
            }
            // If so, then create a results array and a temporary one
            // to hold the data
            $resultArray = array();
            $tempArray = array();

            // Loop through each row in the result set
            while ($row = $stmt->fetch()) {
                // Add each row into our results array
                $tempArray = $row;
                array_push($resultArray, $tempArray);
            }

            // Finally, encode the array to JSON and output the results
            header('Content-Type: application/json');
            echo json_encode($resultArray);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $PostID === 'New Order') {

            if (!empty($_POST)) {

                $sql = "INSERT INTO `TransportJobs` (`ID`";
                $sql2 = " VALUES ( NULL";

                if ($_POST['TransportDate'] != '') {
                    $sql .= ", `TransportDate`";
                    $sql2 .=  ", :TransportDate";
                }

                if ($_POST['driverUser'] != '') {
                    $sql .= ", `driverUser`";
                    $sql2 .=  ", :driverUser";
                }

                if ($_POST['TransportFrom'] != '') {
                    $sql .= ", `TransportFrom`";
                    $sql2 .=  ", :TransportFrom";
                }

                if ($_POST['TransportFromAddress'] != '') {
                    $sql .= ", `TransportFromAddress`";
                    $sql2 .=  ", :TransportFromAddress";
                }

                if ($_POST['TransportFromCityStateZip'] != '') {
                    $sql .= ", `TransportFromCityStateZip`";
                    $sql2 .=  ", :TransportFromCityStateZip";
                }

                if ($_POST['TransportTo'] != '') {
                    $sql .= ", `TransportTo`";
                    $sql2 .=  ", :TransportTo";
                }

                if ($_POST['TransportToAddress'] != '') {
                    $sql .= ", `TransportToAddress`";
                    $sql2 .=  ", :TransportToAddress";
                }

                if ($_POST['TransportToCityStateZip'] != '') {
                    $sql .= ", `TransportToCityStateZip`";
                    $sql2 .=  ", :TransportToCityStateZip";
                }

                if ($_POST['Car1Year'] != '') {
                    $sql .= ", `Car1Year`";
                    $sql2 .=  ", :Car1Year";
                }

                if ($_POST['Car1Make'] != '') {
                    $sql .= ", `Car1Make`";
                    $sql2 .=  ", :Car1Make";
                }

                if ($_POST['Car1Model'] != '') {
                    $sql .= ", `Car1Model`";
                    $sql2 .=  ", :Car1Model";
                }

                if ($_POST['Car1Serial'] != '') {
                    $sql .= ", `Car1Serial`";
                    $sql2 .=  ", :Car1Serial";
                }

                if ($_POST['Car1Stock'] != '') {
                    $sql .= ", `Car1Stock`";
                    $sql2 .=  ", :Car1Stock";
                }

                if ($_POST['Car1Color'] != '') {
                    $sql .= ", `Car1Color`";
                    $sql2 .=  ", :Car1Color";
                }

                if ($_POST['Car1Price'] != '') {
                    $sql .= ", `Car1Price`";
                    $sql2 .=  ", :Car1Price";
                }

                if ($_POST['Car1Img'] != '') {
                    $sql .= ", `Car1Img`";
                    $sql2 .=  ", :Car1Img";
                }

                if ($_POST['Car2Year'] != '') {
                    $sql .= ", `Car2Year`";
                    $sql2 .=  ", :Car2Year";
                }

                if ($_POST['Car2Make'] != '') {
                    $sql .= ", `Car2Make`";
                    $sql2 .=  ", :Car2Make";
                }

                if ($_POST['Car2Model'] != '') {
                    $sql .= ", `Car2Model`";
                    $sql2 .=  ", :Car2Model";
                }

                if ($_POST['Car2Serial'] != '') {
                    $sql .= ", `Car2Serial`";
                    $sql2 .=  ", :Car2Serial";
                }

                if ($_POST['Car2Stock'] != '') {
                    $sql .= ", `Car2Stock`";
                    $sql2 .=  ", :Car2Stock";
                }

                if ($_POST['Car2Color'] != '') {
                    $sql .= ", `Car2Color`";
                    $sql2 .=  ", :Car2Color";
                }

                if ($_POST['Car2Price'] != '') {
                    $sql .= ", `Car2Price`";
                    $sql2 .=  ", :Car2Price";
                }

                if ($_POST['Car2Img'] != '') {
                    $sql .= ", `Car2Img`";
                    $sql2 .=  ", :Car2Img";
                }
                if ($_POST['Car3Year'] != '') {
                    $sql .= ", `Car3Year`";
                    $sql2 .=  ", :Car3Year";
                }

                if ($_POST['Car3Make'] != '') {
                    $sql .= ", `Car3Make`";
                    $sql2 .=  ", :Car3Make";
                }

                if ($_POST['Car3Model'] != '') {
                    $sql .= ", `Car3Model`";
                    $sql2 .=  ", :Car3Model";
                }

                if ($_POST['Car3Serial'] != '') {
                    $sql .= ", `Car3Serial`";
                    $sql2 .=  ", :Car3Serial";
                }

                if ($_POST['Car3Stock'] != '') {
                    $sql .= ", `Car3Stock`";
                    $sql2 .=  ", :Car3Stock";
                }

                if ($_POST['Car3Color'] != '') {
                    $sql .= ", `Car3Color`";
                    $sql2 .=  ", :Car3Color";
                }

                if ($_POST['Car3Price'] != '') {
                    $sql .= ", `Car3Price`";
                    $sql2 .=  ", :Car3Price";
                }

                if ($_POST['Car3Img'] != '') {
                    $sql .= ", `Car3Img`";
                    $sql2 .=  ", :Car3Img";
                }
                if ($_POST['Car4Year'] != '') {
                    $sql .= ", `Car4Year`";
                    $sql2 .=  ", :Car4Year";
                }

                if ($_POST['Car4Make'] != '') {
                    $sql .= ", `Car4Make`";
                    $sql2 .=  ", :Car4Make";
                }

                if ($_POST['Car4Model'] != '') {
                    $sql .= ", `Car4Model`";
                    $sql2 .=  ", :Car4Model";
                }

                if ($_POST['Car4Serial'] != '') {
                    $sql .= ", `Car4Serial`";
                    $sql2 .=  ", :Car4Serial";
                }

                if ($_POST['Car4Stock'] != '') {
                    $sql .= ", `Car4Stock`";
                    $sql2 .=  ", :Car4Stock";
                }

                if ($_POST['Car4Color'] != '') {
                    $sql .= ", `Car4Color`";
                    $sql2 .=  ", :Car4Color";
                }

                if ($_POST['Car4Price'] != '') {
                    $sql .= ", `Car4Price`";
                    $sql2 .=  ", :Car4Price";
                }

                if ($_POST['Car4Img'] != '') {
                    $sql .= ", `Car4Img`";
                    $sql2 .=  ", :Car4Img";
                }
                if ($_POST['Car5Year'] != '') {
                    $sql .= ", `Car5Year`";
                    $sql2 .=  ", :Car5Year";
                }

                if ($_POST['Car5Make'] != '') {
                    $sql .= ", `Car5Make`";
                    $sql2 .=  ", :Car5Make";
                }

                if ($_POST['Car5Model'] != '') {
                    $sql .= ", `Car5Model`";
                    $sql2 .=  ", :Car5Model";
                }

                if ($_POST['Car5Serial'] != '') {
                    $sql .= ", `Car5Serial`";
                    $sql2 .=  ", :Car5Serial";
                }

                if ($_POST['Car5Stock'] != '') {
                    $sql .= ", `Car5Stock`";
                    $sql2 .=  ", :Car5Stock";
                }

                if ($_POST['Car5Color'] != '') {
                    $sql .= ", `Car5Color`";
                    $sql2 .=  ", :Car5Color";
                }

                if ($_POST['Car5Price'] != '') {
                    $sql .= ", `Car5Price`";
                    $sql2 .=  ", :Car5Price";
                }

                if ($_POST['Car5Img'] != '') {
                    $sql .= ", `Car5Img`";
                    $sql2 .=  ", :Car5Img";
                }
                if ($_POST['Car6Year'] != '') {
                    $sql .= ", `Car6Year`";
                    $sql2 .=  ", :Car6Year";
                }

                if ($_POST['Car6Make'] != '') {
                    $sql .= ", `Car6Make`";
                    $sql2 .=  ", :Car6Make";
                }

                if ($_POST['Car6Model'] != '') {
                    $sql .= ", `Car6Model`";
                    $sql2 .=  ", :Car6Model";
                }

                if ($_POST['Car6Serial'] != '') {
                    $sql .= ", `Car6Serial`";
                    $sql2 .=  ", :Car6Serial";
                }

                if ($_POST['Car6Stock'] != '') {
                    $sql .= ", `Car6Stock`";
                    $sql2 .=  ", :Car6Stock";
                }

                if ($_POST['Car6Color'] != '') {
                    $sql .= ", `Car6Color`";
                    $sql2 .=  ", :Car6Color";
                }

                if ($_POST['Car6Price'] != '') {
                    $sql .= ", `Car6Price`";
                    $sql2 .=  ", :Car6Price";
                }

                if ($_POST['Car6Img'] != '') {
                    $sql .= ", `Car6Img`";
                    $sql2 .=  ", :Car6Img";
                }
                if ($_POST['DriverImg'] != '') {
                    $sql .= ", `DriverImg`";
                    $sql2 .=  ", :DriverImg";
                }

                if ($_POST['ShipperImg'] != '') {
                    $sql .= ", `ShipperImg`";
                    $sql2 .=  ", :ShipperImg";
                }

                if ($_POST['ShipperDate'] != '') {
                    $sql .= ", `ShipperDate`";
                    $sql2 .=  ", :ShipperDate";
                }

                if ($_POST['ReceiverImg'] != '') {
                    $sql .= ", `ReceiverImg`";
                    $sql2 .=  ", :ReceiverImg";
                }

                if ($_POST['ReceiverDate'] != '') {
                    $sql .= ", `ReceiverDate`";
                    $sql2 .=  ", :ReceiverDate";
                }
                
                $sql .= ", `Completed` )";
                $sql2 .= ", FALSE )";

                $sql .= $sql2;

                try {
                    $stmt = $pdo->prepare($sql);
                } catch (Exception $e) {
                    echo "Failed to prepare statement";
                }

                try {
                    if ($_POST['TransportDate'] != '')
                        $stmt->bindValue(':TransportDate', $_POST['TransportDate'], PDO::PARAM_STR);
                    if ($_POST['driverUser'] != '')
                        $stmt->bindValue(':driverUser', $_POST['driverUser'], PDO::PARAM_STR);
                    if ($_POST['TransportFrom'] != '')
                        $stmt->bindValue(':TransportFrom', $_POST['TransportFrom'], PDO::PARAM_STR);
                    if ($_POST['TransportFromAddress'] != '')
                        $stmt->bindValue(':TransportFromAddress', $_POST['TransportFromAddress'], PDO::PARAM_STR);
                    if ($_POST['TransportFromCityStateZip'] != '')
                        $stmt->bindValue(':TransportFromCityStateZip', $_POST['TransportFromCityStateZip'], PDO::PARAM_STR);
                    if ($_POST['TransportTo'] != '')
                        $stmt->bindValue(':TransportTo', $_POST['TransportTo'], PDO::PARAM_STR);
                    if ($_POST['TransportToAddress'] != '')
                        $stmt->bindValue(':TransportToAddress', $_POST['TransportToAddress'], PDO::PARAM_STR);
                    if ($_POST['TransportToCityStateZip'] != '')
                        $stmt->bindValue(':TransportToCityStateZip', $_POST['TransportToCityStateZip'], PDO::PARAM_STR);
                    if ($_POST['Car1Year'] != '')
                        $stmt->bindValue(':Car1Year', $_POST['Car1Year'], PDO::PARAM_STR);
                    if ($_POST['Car1Make'] != '')
                        $stmt->bindValue(':Car1Make', $_POST['Car1Make'], PDO::PARAM_STR);
                    if ($_POST['Car1Model'] != '')
                        $stmt->bindValue(':Car1Model', $_POST['Car1Model'], PDO::PARAM_STR);
                    if ($_POST['Car1Serial'] != '')
                        $stmt->bindValue(':Car1Serial', $_POST['Car1Serial'], PDO::PARAM_STR);
                    if ($_POST['Car1Stock'] != '')
                        $stmt->bindValue(':Car1Stock', $_POST['Car1Stock'], PDO::PARAM_STR);
                    if ($_POST['Car1Color'] != '')
                        $stmt->bindValue(':Car1Color', $_POST['Car1Color'], PDO::PARAM_STR);
                    if ($_POST['Car1Price'] != '')
                        $stmt->bindValue(':Car1Price', $_POST['Car1Price'], PDO::PARAM_STR);
                    if ($_POST['Car1Img'] != '')
                        $stmt->bindValue(':Car1Img', $_POST['Car1Img'], PDO::PARAM_STR);
                    if ($_POST['Car2Year'] != '')
                        $stmt->bindValue(':Car2Year', $_POST['Car2Year'], PDO::PARAM_STR);
                    if ($_POST['Car2Make'] != '')
                        $stmt->bindValue(':Car2Make', $_POST['Car2Make'], PDO::PARAM_STR);
                    if ($_POST['Car2Model'] != '')
                        $stmt->bindValue(':Car2Model', $_POST['Car2Model'], PDO::PARAM_STR);
                    if ($_POST['Car2Serial'] != '')
                        $stmt->bindValue(':Car2Serial', $_POST['Car2Serial'], PDO::PARAM_STR);
                    if ($_POST['Car2Stock'] != '')
                        $stmt->bindValue(':Car2Stock', $_POST['Car2Stock'], PDO::PARAM_STR);
                    if ($_POST['Car2Color'] != '')
                        $stmt->bindValue(':Car2Color', $_POST['Car2Color'], PDO::PARAM_STR);
                    if ($_POST['Car2Price'] != '')
                        $stmt->bindValue(':Car2Price', $_POST['Car2Price'], PDO::PARAM_STR);
                    if ($_POST['Car2Img'] != '')
                        $stmt->bindValue(':Car2Img', $_POST['Car2Img'], PDO::PARAM_STR);
                    if ($_POST['Car3Year'] != '')
                        $stmt->bindValue(':Car3Year', $_POST['Car3Year'], PDO::PARAM_STR);
                    if ($_POST['Car3Make'] != '')
                        $stmt->bindValue(':Car3Make', $_POST['Car3Make'], PDO::PARAM_STR);
                    if ($_POST['Car3Model'] != '')
                        $stmt->bindValue(':Car3Model', $_POST['Car3Model'], PDO::PARAM_STR);
                    if ($_POST['Car3Serial'] != '')
                        $stmt->bindValue(':Car3Serial', $_POST['Car3Serial'], PDO::PARAM_STR);
                    if ($_POST['Car3Stock'] != '')
                        $stmt->bindValue(':Car3Stock', $_POST['Car3Stock'], PDO::PARAM_STR);
                    if ($_POST['Car3Color'] != '')
                        $stmt->bindValue(':Car3Color', $_POST['Car3Color'], PDO::PARAM_STR);
                    if ($_POST['Car3Price'] != '')
                        $stmt->bindValue(':Car3Price', $_POST['Car3Price'], PDO::PARAM_STR);
                    if ($_POST['Car3Img'] != '')
                        $stmt->bindValue(':Car3Img', $_POST['Car3Img'], PDO::PARAM_STR);
                    if ($_POST['Car4Year'] != '')
                        $stmt->bindValue(':Car4Year', $_POST['Car4Year'], PDO::PARAM_STR);
                    if ($_POST['Car4Make'] != '')
                        $stmt->bindValue(':Car4Make', $_POST['Car4Make'], PDO::PARAM_STR);
                    if ($_POST['Car4Model'] != '')
                        $stmt->bindValue(':Car4Model', $_POST['Car4Model'], PDO::PARAM_STR);
                    if ($_POST['Car4Serial'] != '')
                        $stmt->bindValue(':Car4Serial', $_POST['Car4Serial'], PDO::PARAM_STR);
                    if ($_POST['Car4Stock'] != '')
                        $stmt->bindValue(':Car4Stock', $_POST['Car4Stock'], PDO::PARAM_STR);
                    if ($_POST['Car4Color'] != '')
                        $stmt->bindValue(':Car4Color', $_POST['Car4Color'], PDO::PARAM_STR);
                    if ($_POST['Car4Price'] != '')
                        $stmt->bindValue(':Car4Price', $_POST['Car4Price'], PDO::PARAM_STR);
                    if ($_POST['Car4Img'] != '')
                        $stmt->bindValue(':Car4Img', $_POST['Car4Img'], PDO::PARAM_STR);
                    if ($_POST['Car5Year'] != '')
                        $stmt->bindValue(':Car5Year', $_POST['Car5Year'], PDO::PARAM_STR);
                    if ($_POST['Car5Make'] != '')
                        $stmt->bindValue(':Car5Make', $_POST['Car5Make'], PDO::PARAM_STR);
                    if ($_POST['Car5Model'] != '')
                        $stmt->bindValue(':Car5Model', $_POST['Car5Model'], PDO::PARAM_STR);
                    if ($_POST['Car5Serial'] != '')
                        $stmt->bindValue(':Car5Serial', $_POST['Car5Serial'], PDO::PARAM_STR);
                    if ($_POST['Car5Stock'] != '')
                        $stmt->bindValue(':Car5Stock', $_POST['Car5Stock'], PDO::PARAM_STR);
                    if ($_POST['Car5Color'] != '')
                        $stmt->bindValue(':Car5Color', $_POST['Car5Color'], PDO::PARAM_STR);
                    if ($_POST['Car5Price'] != '')
                        $stmt->bindValue(':Car5Price', $_POST['Car5Price'], PDO::PARAM_STR);
                    if ($_POST['Car5Img'] != '')
                        $stmt->bindValue(':Car5Img', $_POST['Car5Img'], PDO::PARAM_STR);
                    if ($_POST['Car6Year'] != '')
                        $stmt->bindValue(':Car6Year', $_POST['Car6Year'], PDO::PARAM_STR);
                    if ($_POST['Car6Make'] != '')
                        $stmt->bindValue(':Car6Make', $_POST['Car6Make'], PDO::PARAM_STR);
                    if ($_POST['Car6Model'] != '')
                        $stmt->bindValue(':Car6Model', $_POST['Car6Model'], PDO::PARAM_STR);
                    if ($_POST['Car6Serial'] != '')
                        $stmt->bindValue(':Car6Serial', $_POST['Car6Serial'], PDO::PARAM_STR);
                    if ($_POST['Car6Stock'] != '')
                        $stmt->bindValue(':Car6Stock', $_POST['Car6Stock'], PDO::PARAM_STR);
                    if ($_POST['Car6Color'] != '')
                        $stmt->bindValue(':Car6Color', $_POST['Car6Color'], PDO::PARAM_STR);
                    if ($_POST['Car6Price'] != '')
                        $stmt->bindValue(':Car6Price', $_POST['Car6Price'], PDO::PARAM_STR);
                    if ($_POST['Car6Img'] != '')
                        $stmt->bindValue(':Car6Img', $_POST['Car6Img'], PDO::PARAM_STR);
                    if ($_POST['DriverImg'] != '')
                        $stmt->bindValue(':DriverImg', $_POST['DriverImg'], PDO::PARAM_STR);
                    if ($_POST['ShipperImg'] != '')
                        $stmt->bindValue(':ShipperImg', $_POST['ShipperImg'], PDO::PARAM_STR);
                    if ($_POST['ShipperDate'] != '')
                        $stmt->bindValue(':ShipperDate', $_POST['ShipperDate'], PDO::PARAM_STR);
                    if ($_POST['ReceiverImg'] != '')
                        $stmt->bindValue(':ReceiverImg', $_POST['ReceiverImg'], PDO::PARAM_STR);
                    if ($_POST['ReceiverDate'] != '')
                        $stmt->bindValue(':ReceiverDate', $_POST['ReceiverDate'], PDO::PARAM_STR);
                } catch (PDOException $e) {
                    $pdo->rollback();
                    echo "Error!: " . $e->getMessage() . "</br>";
                }

                try {
                    $pdo->beginTransaction();
                    $stmt->execute();
                    echo $pdo->lastInsertId();
                    $pdo->commit();
                } catch (PDOException $e) {
                    $pdo->rollback();
                    echo "Error!: " . $e->getMessage() . "</br>";
                }
            }
        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $PostID != 'New Order') {

            if (!empty($_POST)) {

                $sql = "UPDATE `TransportJobs` SET ";

                if ($_POST['TransportDate'] != '')
                    $sql .= "`TransportDate`= :TransportDate";
                if ($_POST['driverUser'] != '')
                    $sql .= ", `driverUser`= :driverUser";
                if ($_POST['TransportFrom'] != '')
                    $sql .= ", `TransportFrom`= :TransportFrom";
                if ($_POST['TransportFromAddress'] != '')
                    $sql .= ", `TransportFromAddress`= :TransportFromAddress";
                if ($_POST['TransportFromCityStateZip'] != '')
                    $sql .= ", `TransportFromCityStateZip`= :TransportFromCityStateZip";
                if ($_POST['TransportTo'] != '')
                    $sql .= ", `TransportTo`= :TransportTo";
                if ($_POST['TransportToAddress'] != '')
                    $sql .= ", `TransportToAddress`= :TransportToAddress";
                if ($_POST['TransportToCityStateZip'] != '')
                    $sql .= ", `TransportToCityStateZip`= :TransportToCityStateZip";
                if ($_POST['Car1Year'] != '')
                    $sql .= ", `Car1Year`= :Car1Year";
                if ($_POST['Car1Make'] != '')
                    $sql .= ", `Car1Make`= :Car1Make";
                if ($_POST['Car1Model'] != '')
                    $sql .= ", `Car1Model`= :Car1Model";
                if ($_POST['Car1Serial'] != '')
                    $sql .= ", `Car1Serial`= :Car1Serial";
                if ($_POST['Car1Stock'] != '')
                    $sql .= ", `Car1Stock`= :Car1Stock";
                if ($_POST['Car1Color'] != '')
                    $sql .= ", `Car1Color`= :Car1Color";
                if ($_POST['Car1Price'] != '')
                    $sql .= ", `Car1Price`= :Car1Price";
                if ($_POST['Car1Img'] != '')
                    $sql .= ", `Car1Img`= :Car1Img";
                if ($_POST['Car2Year'] != '')
                    $sql .= ", `Car2Year`= :Car2Year";
                if ($_POST['Car2Make'] != '')
                    $sql .= ", `Car2Make`= :Car2Make";
                if ($_POST['Car2Model'] != '')
                    $sql .= ", `Car2Model`= :Car2Model";
                if ($_POST['Car2Serial'] != '')
                    $sql .= ", `Car2Serial`= :Car2Serial";
                if ($_POST['Car2Stock'] != '')
                    $sql .= ", `Car2Stock`= :Car2Stock";
                if ($_POST['Car2Color'] != '')
                    $sql .= ", `Car2Color`= :Car2Color";
                if ($_POST['Car2Price'] != '')
                    $sql .= ", `Car2Price`= :Car2Price";
                if ($_POST['Car2Img'] != '')
                    $sql .= ", `Car2Img`= :Car2Img";
                if ($_POST['Car3Year'] != '')
                    $sql .= ", `Car3Year`= :Car3Year";
                if ($_POST['Car3Make'] != '')
                    $sql .= ", `Car3Make`= :Car3Make";
                if ($_POST['Car3Model'] != '')
                    $sql .= ", `Car3Model`= :Car3Model";
                if ($_POST['Car3Serial'] != '')
                    $sql .= ", `Car3Serial`= :Car3Serial";
                if ($_POST['Car3Stock'] != '')
                    $sql .= ", `Car3Stock`= :Car3Stock";
                if ($_POST['Car3Color'] != '')
                    $sql .= ", `Car3Color`= :Car3Color";
                if ($_POST['Car3Price'] != '')
                    $sql .= ", `Car3Price`= :Car3Price";
                if ($_POST['Car3Img'] != '')
                    $sql .= ", `Car3Img`= :Car3Img";
                if ($_POST['Car4Year'] != '')
                    $sql .= ", `Car4Year`= :Car4Year";
                if ($_POST['Car4Make'] != '')
                    $sql .= ", `Car4Make`= :Car4Make";
                if ($_POST['Car4Model'] != '')
                    $sql .= ", `Car4Model`= :Car4Model";
                if ($_POST['Car4Serial'] != '')
                    $sql .= ", `Car4Serial`= :Car4Serial";
                if ($_POST['Car4Stock'] != '')
                    $sql .= ", `Car4Stock`= :Car4Stock";
                if ($_POST['Car4Color'] != '')
                    $sql .= ", `Car4Color`= :Car4Color";
                if ($_POST['Car4Price'] != '')
                    $sql .= ", `Car4Price`= :Car4Price";
                if ($_POST['Car4Img'] != '')
                    $sql .= ", `Car4Img`= :Car4Img";
                if ($_POST['Car5Year'] != '')
                    $sql .= ", `Car5Year`= :Car5Year";
                if ($_POST['Car5Make'] != '')
                    $sql .= ", `Car5Make`= :Car5Make";
                if ($_POST['Car5Model'] != '')
                    $sql .= ", `Car5Model`= :Car5Model";
                if ($_POST['Car5Serial'] != '')
                    $sql .= ", `Car5Serial`= :Car5Serial";
                if ($_POST['Car5Stock'] != '')
                    $sql .= ", `Car5Stock`= :Car5Stock";
                if ($_POST['Car5Color'] != '')
                    $sql .= ", `Car5Color`= :Car5Color";
                if ($_POST['Car5Price'] != '')
                    $sql .= ", `Car5Price`= :Car5Price";
                if ($_POST['Car5Img'] != '')
                    $sql .= ", `Car5Img`= :Car5Img";
                if ($_POST['Car6Year'] != '')
                    $sql .= ", `Car6Year`= :Car6Year";
                if ($_POST['Car6Make'] != '')
                    $sql .= ", `Car6Make`= :Car6Make";
                if ($_POST['Car6Model'] != '')
                    $sql .= ", `Car6Model`= :Car6Model";
                if ($_POST['Car6Serial'] != '')
                    $sql .= ", `Car6Serial`= :Car6Serial";
                if ($_POST['Car6Stock'] != '')
                    $sql .= ", `Car6Stock`= :Car6Stock";
                if ($_POST['Car6Color'] != '')
                    $sql .= ", `Car6Color`= :Car6Color";
                if ($_POST['Car6Price'] != '')
                    $sql .= ", `Car6Price`= :Car6Price";
                if ($_POST['Car6Img'] != '')
                    $sql .= ", `Car6Img`= :Car6Img";
                if ($_POST['DriverImg'] != '')
                    $sql .= ", `DriverImg`= :DriverImg";
                if ($_POST['ShipperImg'] != '')
                    $sql .= ", `ShipperImg`= :ShipperImg";
                if ($_POST['ShipperDate'] != '')
                    $sql .= ", `ShipperDate`= :ShipperDate";
                if ($_POST['ReceiverImg'] != '')
                    $sql .= ", `ReceiverImg`= :ReceiverImg";
                if ($_POST['ReceiverDate'] != '')
                    $sql .= ", `ReceiverDate`= :ReceiverDate";

                if ($_POST['Completed'] != '')
                    $sql .= ", `Completed`= :Completed";

                $sql .= " WHERE `ID` = :ID";


                try {
                    $stmt = $pdo->prepare($sql);
                } catch (Exception $e) {
                    echo "Failed to prepare statement";
                }

                if ($_POST['TransportDate'] != '')
                    $stmt->bindValue(':TransportDate', $_POST['TransportDate'], PDO::PARAM_STR);
                if ($_POST['driverUser'] != '')
                    $stmt->bindValue(':driverUser', $_POST['driverUser'], PDO::PARAM_STR);
                if ($_POST['TransportFrom'] != '')
                    $stmt->bindValue(':TransportFrom', $_POST['TransportFrom'], PDO::PARAM_STR);
                if ($_POST['TransportFromAddress'] != '')
                    $stmt->bindValue(':TransportFromAddress', $_POST['TransportFromAddress'], PDO::PARAM_STR);
                if ($_POST['TransportFromCityStateZip'] != '')
                    $stmt->bindValue(':TransportFromCityStateZip', $_POST['TransportFromCityStateZip'], PDO::PARAM_STR);
                if ($_POST['TransportTo'] != '')
                    $stmt->bindValue(':TransportTo', $_POST['TransportTo'], PDO::PARAM_STR);
                if ($_POST['TransportToAddress'] != '')
                    $stmt->bindValue(':TransportToAddress', $_POST['TransportToAddress'], PDO::PARAM_STR);
                if ($_POST['TransportToCityStateZip'] != '')
                    $stmt->bindValue(':TransportToCityStateZip', $_POST['TransportToCityStateZip'], PDO::PARAM_STR);
                if ($_POST['Car1Year'] != '')
                    $stmt->bindValue(':Car1Year', $_POST['Car1Year'], PDO::PARAM_STR);
                if ($_POST['Car1Make'] != '')
                    $stmt->bindValue(':Car1Make', $_POST['Car1Make'], PDO::PARAM_STR);
                if ($_POST['Car1Model'] != '')
                    $stmt->bindValue(':Car1Model', $_POST['Car1Model'], PDO::PARAM_STR);
                if ($_POST['Car1Serial'] != '')
                    $stmt->bindValue(':Car1Serial', $_POST['Car1Serial'], PDO::PARAM_STR);
                if ($_POST['Car1Stock'] != '')
                    $stmt->bindValue(':Car1Stock', $_POST['Car1Stock'], PDO::PARAM_STR);
                if ($_POST['Car1Color'] != '')
                    $stmt->bindValue(':Car1Color', $_POST['Car1Color'], PDO::PARAM_STR);
                if ($_POST['Car1Price'] != '')
                    $stmt->bindValue(':Car1Price', $_POST['Car1Price'], PDO::PARAM_STR);
                if ($_POST['Car1Img'] != '')
                    $stmt->bindValue(':Car1Img', $_POST['Car1Img'], PDO::PARAM_STR);
                if ($_POST['Car2Year'] != '')
                    $stmt->bindValue(':Car2Year', $_POST['Car2Year'], PDO::PARAM_STR);
                if ($_POST['Car2Make'] != '')
                    $stmt->bindValue(':Car2Make', $_POST['Car2Make'], PDO::PARAM_STR);
                if ($_POST['Car2Model'] != '')
                    $stmt->bindValue(':Car2Model', $_POST['Car2Model'], PDO::PARAM_STR);
                if ($_POST['Car2Serial'] != '')
                    $stmt->bindValue(':Car2Serial', $_POST['Car2Serial'], PDO::PARAM_STR);
                if ($_POST['Car2Stock'] != '')
                    $stmt->bindValue(':Car2Stock', $_POST['Car2Stock'], PDO::PARAM_STR);
                if ($_POST['Car2Color'] != '')
                    $stmt->bindValue(':Car2Color', $_POST['Car2Color'], PDO::PARAM_STR);
                if ($_POST['Car2Price'] != '')
                    $stmt->bindValue(':Car2Price', $_POST['Car2Price'], PDO::PARAM_STR);
                if ($_POST['Car2Img'] != '')
                    $stmt->bindValue(':Car2Img', $_POST['Car2Img'], PDO::PARAM_STR);
                if ($_POST['Car3Year'] != '')
                    $stmt->bindValue(':Car3Year', $_POST['Car3Year'], PDO::PARAM_STR);
                if ($_POST['Car3Make'] != '')
                    $stmt->bindValue(':Car3Make', $_POST['Car3Make'], PDO::PARAM_STR);
                if ($_POST['Car3Model'] != '')
                    $stmt->bindValue(':Car3Model', $_POST['Car3Model'], PDO::PARAM_STR);
                if ($_POST['Car3Serial'] != '')
                    $stmt->bindValue(':Car3Serial', $_POST['Car3Serial'], PDO::PARAM_STR);
                if ($_POST['Car3Stock'] != '')
                    $stmt->bindValue(':Car3Stock', $_POST['Car3Stock'], PDO::PARAM_STR);
                if ($_POST['Car3Color'] != '')
                    $stmt->bindValue(':Car3Color', $_POST['Car3Color'], PDO::PARAM_STR);
                if ($_POST['Car3Price'] != '')
                    $stmt->bindValue(':Car3Price', $_POST['Car3Price'], PDO::PARAM_STR);
                if ($_POST['Car3Img'] != '')
                    $stmt->bindValue(':Car3Img', $_POST['Car3Img'], PDO::PARAM_STR);
                if ($_POST['Car4Year'] != '')
                    $stmt->bindValue(':Car4Year', $_POST['Car4Year'], PDO::PARAM_STR);
                if ($_POST['Car4Make'] != '')
                    $stmt->bindValue(':Car4Make', $_POST['Car4Make'], PDO::PARAM_STR);
                if ($_POST['Car4Model'] != '')
                    $stmt->bindValue(':Car4Model', $_POST['Car4Model'], PDO::PARAM_STR);
                if ($_POST['Car4Serial'] != '')
                    $stmt->bindValue(':Car4Serial', $_POST['Car4Serial'], PDO::PARAM_STR);
                if ($_POST['Car4Stock'] != '')
                    $stmt->bindValue(':Car4Stock', $_POST['Car4Stock'], PDO::PARAM_STR);
                if ($_POST['Car4Color'] != '')
                    $stmt->bindValue(':Car4Color', $_POST['Car4Color'], PDO::PARAM_STR);
                if ($_POST['Car4Price'] != '')
                    $stmt->bindValue(':Car4Price', $_POST['Car4Price'], PDO::PARAM_STR);
                if ($_POST['Car4Img'] != '')
                    $stmt->bindValue(':Car4Img', $_POST['Car4Img'], PDO::PARAM_STR);
                if ($_POST['Car5Year'] != '')
                    $stmt->bindValue(':Car5Year', $_POST['Car5Year'], PDO::PARAM_STR);
                if ($_POST['Car5Make'] != '')
                    $stmt->bindValue(':Car5Make', $_POST['Car5Make'], PDO::PARAM_STR);
                if ($_POST['Car5Model'] != '')
                    $stmt->bindValue(':Car5Model', $_POST['Car5Model'], PDO::PARAM_STR);
                if ($_POST['Car5Serial'] != '')
                    $stmt->bindValue(':Car5Serial', $_POST['Car5Serial'], PDO::PARAM_STR);
                if ($_POST['Car5Stock'] != '')
                    $stmt->bindValue(':Car5Stock', $_POST['Car5Stock'], PDO::PARAM_STR);
                if ($_POST['Car5Color'] != '')
                    $stmt->bindValue(':Car5Color', $_POST['Car5Color'], PDO::PARAM_STR);
                if ($_POST['Car5Price'] != '')
                    $stmt->bindValue(':Car5Price', $_POST['Car5Price'], PDO::PARAM_STR);
                if ($_POST['Car5Img'] != '')
                    $stmt->bindValue(':Car5Img', $_POST['Car5Img'], PDO::PARAM_STR);
                if ($_POST['Car6Year'] != '')
                    $stmt->bindValue(':Car6Year', $_POST['Car6Year'], PDO::PARAM_STR);
                if ($_POST['Car6Make'] != '')
                    $stmt->bindValue(':Car6Make', $_POST['Car6Make'], PDO::PARAM_STR);
                if ($_POST['Car6Model'] != '')
                    $stmt->bindValue(':Car6Model', $_POST['Car6Model'], PDO::PARAM_STR);
                if ($_POST['Car6Serial'] != '')
                    $stmt->bindValue(':Car6Serial', $_POST['Car6Serial'], PDO::PARAM_STR);
                if ($_POST['Car6Stock'] != '')
                    $stmt->bindValue(':Car6Stock', $_POST['Car6Stock'], PDO::PARAM_STR);
                if ($_POST['Car6Color'] != '')
                    $stmt->bindValue(':Car6Color', $_POST['Car6Color'], PDO::PARAM_STR);
                if ($_POST['Car6Price'] != '')
                    $stmt->bindValue(':Car6Price', $_POST['Car6Price'], PDO::PARAM_STR);
                if ($_POST['Car6Img'] != '')
                    $stmt->bindValue(':Car6Img', $_POST['Car6Img'], PDO::PARAM_STR);
                if ($_POST['DriverImg'] != '')
                    $stmt->bindValue(':DriverImg', $_POST['DriverImg'], PDO::PARAM_STR);
                if ($_POST['ShipperImg'] != '')
                    $stmt->bindValue(':ShipperImg', $_POST['ShipperImg'], PDO::PARAM_STR);
                if ($_POST['ShipperDate'] != '')
                    $stmt->bindValue(':ShipperDate', $_POST['ShipperDate'], PDO::PARAM_STR);
                if ($_POST['ReceiverImg'] != '')
                    $stmt->bindValue(':ReceiverImg', $_POST['ReceiverImg'], PDO::PARAM_STR);
                if ($_POST['ReceiverDate'] != '')
                    $stmt->bindValue(':ReceiverDate', $_POST['ReceiverDate'], PDO::PARAM_STR);
                if ($_POST['Completed'] != '')
                    $stmt->bindValue(':Completed', $_POST['Completed'], PDO::PARAM_STR);

                $stmt->bindValue(':ID', $PostID, PDO::PARAM_STR);
                
                try {
                    $pdo->beginTransaction();
                    $stmt->execute();
                    $pdo->commit();
                    echo $PostID;
                } catch (PDOException $e) {
                    $pdo->rollback();
                    echo "Error3!: " . $e->getMessage() . "<br>";
                }
            } else {
                echo 'Post is empty';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET'  && $GetID != NULL) {
            $sql = "SELECT * FROM TransportJobs WHERE `ID` = :ID";

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':ID', $GetID, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt) {
                // If so, then create a results array and a temporary one
                // to hold the data
                $resultArray = array();
                $tempArray = array();

                // Loop through each row in the result set
                while ($row = $stmt->fetch()) {
                    // Add each row into our results array
                    $tempArray = $row;
                    array_push($resultArray, $tempArray);
                }

                // Finally, encode the array to JSON and output the results
                header('Content-Type: application/json');
                echo json_encode($resultArray);
            } else {
                echo "Get ID Failed";
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

            $sql = "UPDATE `TransportJobs` SET `Completed` = TRUE WHERE `ID` = :ID";

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':ID', $GetID, PDO::PARAM_STR);

            if ($stmt->execute() === TRUE) {
                echo "Record marked completed successfully";
            } else {
                echo "Completed Update Failed";
            }
        }
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

    // No Need to Close connection with PDO




} else {
    // Redirect them to the login page
    header("Location: login.php");
}
