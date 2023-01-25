<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (window) {
    'use strict';
    var FORM_SELECTOR = '[data-transport-order="form"]';
    var CHECKLIST_SELECTOR = '[data-transport-order="checklist"]';
    var SERVER_URL = 'TransportData.php';
    var REPORT_URL = 'transporthtm-6cars.php';
    //UPDATE URL IN REPORT.JS TOO

    var REPORT_BUTTON = '[data-transport-order="reportButton"]';
    var REPORT_BUTTON2 = '[data-transport-order="reportButton2"]';


    var DRAW_CAR1 = '[data-transport-order="Car1Draw"]';
    var IMG_CAR1 = '[data-transport-order="Car1Img"]';
    var ERASER_CAR1 = '[data-transport-order="Car1Eraser"]';

    var DRAW_CAR2 = '[data-transport-order="Car2Draw"]';
    var IMG_CAR2 = '[data-transport-order="Car2Img"]';
    var ERASER_CAR2 = '[data-transport-order="Car2Eraser"]';

    var DRAW_CAR3 = '[data-transport-order="Car3Draw"]';
    var IMG_CAR3 = '[data-transport-order="Car3Img"]';
    var ERASER_CAR3 = '[data-transport-order="Car3Eraser"]';

    var DRAW_CAR4 = '[data-transport-order="Car4Draw"]';
    var IMG_CAR4 = '[data-transport-order="Car4Img"]';
    var ERASER_CAR4 = '[data-transport-order="Car4Eraser"]';

    var DRAW_CAR5 = '[data-transport-order="Car5Draw"]';
    var IMG_CAR5 = '[data-transport-order="Car5Img"]';
    var ERASER_CAR5 = '[data-transport-order="Car5Eraser"]';

    var DRAW_CAR6 = '[data-transport-order="Car6Draw"]';
    var IMG_CAR6 = '[data-transport-order="Car6Img"]';
    var ERASER_CAR6 = '[data-transport-order="Car6Eraser"]';

    var DRAW_DRIVER = '[data-transport-order="DriverDraw"]';
    var IMG_DRIVER = '[data-transport-order="DriverImg"]';
    var ERASER_DRIVER = '[data-transport-order="DriverEraser"]';

    var DRAW_SHIPPER = '[data-transport-order="ShipperDraw"]';
    var IMG_SHIPPER = '[data-transport-order="ShipperImg"]';
    var ERASER_SHIPPER = '[data-transport-order="ShipperEraser"]';
    
    var DRAW_RECEIVER = '[data-transport-order="ReceiverDraw"]';
    var IMG_RECEIVER = '[data-transport-order="ReceiverImg"]';
    var ERASER_RECEIVER = '[data-transport-order="ReceiverEraser"]';

    var SEARCHFIELD = '[data-transport-order="SearchField"]';

    var CAR_IMAGE = 'img/CarDiagram.jpeg';

    var App = window.App;
    var Truck = App.Truck;
    var DataStore = App.DataStore;
    var FormHandler = App.FormHandler;
    var CheckList = App.CheckList;
    var RemoteDataStore = App.RemoteDataStore;
    var ReportHandler = App.ReportHandler;
    var DamageDraw = App.DamageDraw;
    var FilterJobs = App.FilterJobs;

    var remoteDB = new RemoteDataStore(SERVER_URL);

    var myTruck = new Truck('OKTruck', remoteDB); //new DataStore());
    window.myTruck = myTruck;

    var checkList = new CheckList(CHECKLIST_SELECTOR);
    //checkList.addDblClickHandler(myTruck.deliverOrder.bind(myTruck));

    var filterJobs = new FilterJobs(SEARCHFIELD);
    filterJobs.addSearchHandler(CHECKLIST_SELECTOR);
    
    var formHandler = new FormHandler(FORM_SELECTOR);

    var reportHandler = new ReportHandler(REPORT_BUTTON, REPORT_URL);
    var reportHandler2 = new ReportHandler(REPORT_BUTTON2, REPORT_URL);
 
    
    var damageDrawCar1 = new DamageDraw(DRAW_CAR1, IMG_CAR1, ERASER_CAR1, CAR_IMAGE );
    var damageDrawCar2 = new DamageDraw(DRAW_CAR2, IMG_CAR2, ERASER_CAR2, CAR_IMAGE );
    var damageDrawCar3 = new DamageDraw(DRAW_CAR3, IMG_CAR3, ERASER_CAR3, CAR_IMAGE );
    var damageDrawCar4 = new DamageDraw(DRAW_CAR4, IMG_CAR4, ERASER_CAR4, CAR_IMAGE );
    var damageDrawCar5 = new DamageDraw(DRAW_CAR5, IMG_CAR5, ERASER_CAR5, CAR_IMAGE );
    var damageDrawCar6 = new DamageDraw(DRAW_CAR6, IMG_CAR6, ERASER_CAR6, CAR_IMAGE );
    var damageSig = new DamageDraw(DRAW_DRIVER, IMG_DRIVER, ERASER_DRIVER, null );
    var shipperSig = new DamageDraw(DRAW_SHIPPER, IMG_SHIPPER, ERASER_SHIPPER, null );
    var receiverSig = new DamageDraw(DRAW_RECEIVER, IMG_RECEIVER, ERASER_RECEIVER, null );



    var drawingArray = new Array();

    drawingArray.push( damageDrawCar1 );
    drawingArray.push( damageDrawCar2 );
    drawingArray.push( damageDrawCar3 );
    drawingArray.push( damageDrawCar4 );
    drawingArray.push( damageDrawCar5 );
    drawingArray.push( damageDrawCar6 );
    drawingArray.push( damageSig );
    drawingArray.push( shipperSig );
    drawingArray.push( receiverSig );
    

    damageDrawCar1.addDrawHandlers();
    damageDrawCar2.addDrawHandlers();
    damageDrawCar3.addDrawHandlers();
    damageDrawCar4.addDrawHandlers();
    damageDrawCar5.addDrawHandlers();
    damageDrawCar6.addDrawHandlers();    
    damageSig.addDrawHandlers();
    shipperSig.addDrawHandlers();
    receiverSig.addDrawHandlers();


    checkList.addClickHandler(myTruck.updateOrder.bind(myTruck), drawingArray );

    formHandler.addSubmitHandler( drawingArray, function (data) {
        return myTruck.createOrder(data).then(function () {
            checkList.addRow(data);
        }, function () {
            alert('Server unreachable, try again later.');

        });
    });

    reportHandler.addReportClick( );
    reportHandler2.addReportClick( );


    //formHandler.addInputHandler();

    myTruck.printOrders(checkList.addRow.bind(checkList));

})(window);