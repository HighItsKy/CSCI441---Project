<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (windows) {
    'use strict';

    App = window.App || {};
    var $ = window.jQuery;

    function RemoteDataStore(url) {
        if (!url) {
            throw new Error('No url supplied');
        }

        this.serverUrl = url;
    }

    RemoteDataStore.prototype.add = function (key, val) {

        return $.post(this.serverUrl, val, function (serverResponse) {
            if( serverResponse.includes('Error') || serverResponse.includes('Record') ){
                console.log(serverResponse);
            }
            else {
                val.ID = serverResponse;
            }
            
        });

    };

    RemoteDataStore.prototype.getAll = function (cb) {
        return $.get(this.serverUrl, function (serverResponse) {
            if (cb) {
                console.log(serverResponse);
                cb(serverResponse);
            }
        });

    };

    RemoteDataStore.prototype.get = function (key, cb) {
        return $.get(this.serverUrl + '?ID=' + key, function (serverResponse) {
            if (cb) {
                console.log(serverResponse);
                cb(serverResponse);
            }
        });
    };

    RemoteDataStore.prototype.remove = function (key) {

        console.log(this.serverUrl + '?ID=' + key);
        return $.ajax(this.serverUrl + '?ID=' + key, {
            type: 'DELETE'
        });

    };

    App.RemoteDataStore = RemoteDataStore;
    window.App = App;

})(window);