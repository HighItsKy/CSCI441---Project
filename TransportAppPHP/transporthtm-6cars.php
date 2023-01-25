<?PHP

session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: index.php");
  
} else {

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
  } catch (Exception $e) {
    echo "Oh no! There's an error in the Datatbase!";
  }

  $sql = "SELECT * FROM TransportJobs WHERE `ID` = :ID";

  try {
    $stmt = $pdo->prepare($sql);
  } catch (Exception $e) {
    echo "Oh no! There's an error in the query!";
  }
  $stmt->bindValue(':ID', $_GET['ID'], PDO::PARAM_STR);
  try {
    $stmt->execute();
  } catch (Exception $e) {
    echo "Oh no! There's an error in the lookup!";
  }
  if ($stmt) {
    // If so, then create a results array and a temporary one
    // to hold the data
    $resultArray = $stmt->fetch(PDO::FETCH_OBJ);
  }
}
?>

<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheets/report.css">

  <title>Transport Report</title>
</head>

<body>
  <div class="wrapper">
    <div class="box company_logo">
      <img src="img/company.png" style="height: auto; width: 80%;" alt="">
    </div>
    <div class="box billing">
      <table>
        <TR>
          <TD style="text-align: left; font: 14pt Georgia, 'Times New Roman', Times, serif;"><B>Date: <?PHP echo $resultArray->TransportDate; ?></B></TD>
          <TD style="text-align: right; font: 14pt Georgia, 'Times New Roman', Times, serif;"><B>Invoice: <?PHP echo $resultArray->ID; ?></B></TD>
        </TR>
        <TR>
          <TD style="height: 5px;" colspan="2"> </TD>
        </TR>
        <TR>
          <TD style="text-align: left;"><b>Remit Payment To: </b></TD>
          <td style="text-align: right;"><strong>Terms: Net 15 DAYS</strong></td>
        </TR>
        <tr>
          <td colspan="2">TRUCKS DIRECT PARTS AND TIRES, LLC</td>
        </tr>
        <TR>
          <TD colspan="2">3920 S. Classen Blvd. #104</td>
        </tr>
        <TR>
          <TD colspan="2">Norman, OK 73071</td>
        </tr>
      </table>
    </div>

    <div class="box ship">
      SHIP FROM:<BR>
      Name:<BR>
      Address:<BR>
      City/State/Zip:<BR>
    </div>
    <div class="box ship_from">
      <BR>
      <?PHP echo $resultArray->TransportFrom; ?><br>
      <?PHP echo $resultArray->TransportFromAddress; ?><br>
      <?PHP echo $resultArray->TransportFromCityStateZip; ?> <br>
    </div>

    <div class="box ship">
      SHIP TO:<BR>
      Name:<BR>
      Address:<BR>
      City/State/Zip:<BR>
    </div>
    <div class="box ship_to">
      <BR>
      <?PHP echo $resultArray->TransportTo; ?><br>
      <?PHP echo $resultArray->TransportToAddress; ?><br>
      <?PHP echo $resultArray->TransportToCityStateZip; ?> <br>
    </div>

    <div class="box car_info">
      <table>
        <tr>
          <th width="5%">CAR</th>
          <th width="10%">YEAR</th>
          <th width="19%">MAKE</th>
          <th width="19%">MODEL</th>
          <th width="19%">SERIAL # - LAST 8</th>
          <th width="14%">COLOR</th>
          <th width="14%">PRICE</th>
        </tr>
        <tr>
          <th>1</th>
          <td><?PHP echo $resultArray->Car1Year; ?></td>
          <td><?PHP echo $resultArray->Car1Make; ?></td>
          <td><?PHP echo $resultArray->Car1Model; ?></td>
          <td><?PHP echo $resultArray->Car1Serial; ?></td>
          <td><?PHP echo $resultArray->Car1Color; ?></td>
          <td style="text-align: right;"><?PHP if($resultArray->Car1Price) { echo "$" . number_format($resultArray->Car1Price, 2);} ?></td>
        </tr>
        <tr>
          <th>2</th>
          <td><?PHP echo $resultArray->Car2Year; ?></td>
          <td><?PHP echo $resultArray->Car2Make; ?></td>
          <td><?PHP echo $resultArray->Car2Model; ?></td>
          <td><?PHP echo $resultArray->Car2Serial; ?></td>
          <td><?PHP echo $resultArray->Car2Color; ?></td>
          <td style="text-align: right;"><?PHP if( $resultArray->Car2Price ) { echo "$" . number_format($resultArray->Car2Price, 2); }?></td>
        </tr>
        <tr>
          <th>3</th>
          <td><?PHP echo $resultArray->Car3Year; ?></td>
          <td><?PHP echo $resultArray->Car3Make; ?></td>
          <td><?PHP echo $resultArray->Car3Model; ?></td>
          <td><?PHP echo $resultArray->Car3Serial; ?></td>
          <td><?PHP echo $resultArray->Car3Color; ?></td>
          <td style="text-align: right;"><?PHP if( $resultArray->Car3Price ) {echo number_format($resultArray->Car3Price, 2); }?></td>
        </tr>

        <tr>
          <th>4</th>
          <td><?PHP echo $resultArray->Car4Year; ?></td>
          <td><?PHP echo $resultArray->Car4Make; ?></td>
          <td><?PHP echo $resultArray->Car4Model; ?></td>
          <td><?PHP echo $resultArray->Car4Serial; ?></td>
          <td><?PHP echo $resultArray->Car4Color; ?></td>
          <td style="text-align: right;"><?PHP if($resultArray->Car4Price){ echo number_format($resultArray->Car4Price, 2); }?></td>
        </tr>

        <tr>
          <th>5</th>
          <td><?PHP echo $resultArray->Car5Year; ?></td>
          <td><?PHP echo $resultArray->Car5Make; ?></td>
          <td><?PHP echo $resultArray->Car5Model; ?></td>
          <td><?PHP echo $resultArray->Car5Serial; ?></td>
          <td><?PHP echo $resultArray->Car5Color; ?></td>
          <td style="text-align: right;"><?PHP if($resultArray->Car5Price){ echo number_format($resultArray->Car5Price, 2); }?></td>
        </tr>

        <tr>
          <th>6</th>
          <td><?PHP echo $resultArray->Car6Year; ?></td>
          <td><?PHP echo $resultArray->Car6Make; ?></td>
          <td><?PHP echo $resultArray->Car6Model; ?></td>
          <td><?PHP echo $resultArray->Car6Serial; ?></td>
          <td><?PHP echo $resultArray->Car6Color; ?></td>
          <td style="text-align: right;"><?PHP if( $resultArray->Car6Price){ echo number_format($resultArray->Car6Price, 2); }?></td>
        </tr>

        <tr>
          <td colspan="4"> </td>
          <td colspan="2" style="text-align:right; background-color: #000000; color: #FFFFFF;">PAY THIS AMOUNT:</td>
          <td style="text-align: right;">$<?PHP echo number_format($resultArray->Car1Price + $resultArray->Car2Price + $resultArray->Car3Price + $resultArray->Car4Price + $resultArray->Car5Price + $resultArray->Car6Price, 2); ?></td>
        </tr>
      </table>
    </div>

    <div class="box car_damage">
      Car 1:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car1Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car1Stock; ?>
    </div>

    <div class="box car_damage">
      Car 2:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car2Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car2Stock; ?>
    </div>

    <div class="box car_damage">
      Car 3:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car3Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car3Stock; ?>
    </div>

    <div class="box car_damage">
      Car 4:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car4Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car4Stock; ?>
    </div>

    <div class="box car_damage">
      Car 5:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car5Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car5Stock; ?>
    </div>

    <div class="box car_damage">
      Car 6:<BR>
      <img style="display: block; margin-left: auto; margin-right: auto; height: auto; width: 65%;" src="<?PHP echo $resultArray->Car6Img; ?>" alt="">
      <BR><?PHP echo $resultArray->Car6Stock; ?>
    </div>

    <div class="signature">
      <table>
        <tr>
          <td>B=Bent</td>
          <td>CR=Cracked</td>
          <td>PC=Paint Chip</td>
          <td>D=Dented</td>
          <td>L=Loose</td>
          <td>SS=Surface Scratch</td>
        </tr>
        <tr>
        </tr>
        <tr>
          <td>BR=Broken</td>
          <td>M=Missing</td>
          <td>C=Cut</td>
          <td>FF=Foreign Fluid</td>
          <td>S=Scratched</td>
        </tr>
      </table>
    </div>

    <div class="box signature">
      Driver's Signature: <img style="width: 30%; height: auto;" src="<?PHP echo $resultArray->DriverImg; ?>">
      Date: <?PHP echo $resultArray->TransportDate; ?>
    </div>

    <div class="box disclaimer">
      During transport vehicles and vehicle equipment may cease to operate properly due to no
      fault of the transporter. The transport company <b>WILL NOT</b> be responsible for damage
      that is not directly caused by the transport driver.
    </div>

    <div class="box disclaimer_inspection">
     CONSIGNEE AGREES TO THE CONDITION OF THE VEHICLE(S), RATE, TERMS & CONDITIONS
    </div>

    <div class="box signature">
      <table>
      <tbody>
      <tr><td colspan="2"><BR></td></tr>
      <tr><td>THE SHIPPER HAS SHIPPED THE ABOVE LISTED VEHICLE(S) WITH THE ABOVE NOTED DAMAGE OR HAS
            MADE SUCH EXCEPTIONS ON INSPECTION SHEETS</td>
            <td>THE RECEIVER HAS RECIEVED THE ABOVE LISTED VEHICLE(S) WITH NO TRANSPORTATION DAMAGE NOTED OR HAS
            MADE SUCH EXCEPTIONS ON INSPECTION SHEETS</td></tr>
            <tr><td><img style="width: 60%; height: auto;" src="<?PHP echo $resultArray->ShipperImg; ?>"> 
      Date: <?PHP echo $resultArray->ShipperDate; ?></td>
          <td><img style="width: 60%; height: auto;" src="<?PHP echo $resultArray->ReceiverImg; ?>"> 
      Date: <?PHP echo $resultArray->ReceiverDate; ?></td></tr>
      </tbody>
      </table>
    </div>
    <div class="no-print">
      <button type="button" onclick="javascript:window.close('','_parent','')">Close</button>
      <button type="button" onclick="javascript:window.print()">Print</button>
    </div>
  </div>
</body>

</html>