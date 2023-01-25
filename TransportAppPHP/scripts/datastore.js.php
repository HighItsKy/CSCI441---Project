<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>


(function (window) {
    'use strict';

    var App = window.App || {};
    var Promise = window.Promise;

    function DataStore() {
        console.log('running the DataStore function')
        this.data = {};
    }

    DataStore.prototype.add = function (key, val) {
        
        return promiseResolvedWith(null);
    };

    DataStore.prototype.get = function (key) {
        return promiseResolvedWit( this.data[key] );
    };

    DataStore.prototype.getAll = function () {
        return promiseResolvedWith( this.data );
    };

    DataStore.prototype.remove = function (key) {
        return promiseReslvedWith( null );
    };

    function promiseResolvedWith( value ){
        var promise = new Promise( function ( resolve, reject ){
            resolve( value );
         });
         return promise;
    }

    App.DataStore = DataStore;
    window.App = App;
})(window);