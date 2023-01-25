<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (window) {
    'use strict';
    App = window.App || {};

    var Validation = {
        isCompanyEmail: function (email) {
            return /.+@gmail\.com$/.test(email);
        }
    }

    App.Validation = Validation;
    window.App = App;
})(window);