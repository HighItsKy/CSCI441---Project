<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (window) {
    'use strict';
    var REPORT_URL = 'transporthtm-6cars.php'; //UPDATE

    var App = window.App || {};
    var $ = window.jQuery;

    
    function ReportHandler(selector, url) {
        if (!selector) {
            throw new Error('No selector provided');
        }

        this.$element = $(selector);
        if (this.$element.length === 0) {
            throw new Error('Could not find element with selector: ' + selector);
        }

        if (!url) {
            throw new Error('No url supplied');
        }

        this.serverUrl = url;
    }

    ReportHandler.prototype.addReportClick = function( fn ) {
        this.$element.on('click', function (event) {
                var printID = $('input[name="ID"]').val();
                if( printID != 'New Order') {
                    $('form[data-transport-order="form"]').submit();
                    open( REPORT_URL + '?ID=' + printID );
                }
        });

    };

    App.ReportHandler = ReportHandler;
    window.App = App;

})(window);