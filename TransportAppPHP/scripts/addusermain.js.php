<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (window) {
    'use strict';
    var FORM_SELECTOR = '[data-adduser-order="form"]';
    var CHECKLIST_SELECTOR = '[data-adduser-order="checklist"]';
    var SERVER_URL = 'AddUserData.php';
    
    var App = window.App;
    var AddUser = App.AddUser;
    var CheckList = App.CheckList;
    var RemoteDataStore = App.RemoteDataStore;

    var remoteDB = new RemoteDataStore(SERVER_URL);

    var myAddUser = new Truck('OKAddUser', remoteDB); //new DataStore());
    window.myAddUser = myAddUser;

    var checkList = new CheckList(CHECKLIST_SELECTOR);

    checkList.addClickHandler(myTruck.updateOrder.bind(myAddUser), NULL );

})(window);