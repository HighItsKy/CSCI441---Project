<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>

(function (window) {
  "use strict";

  var App = window.App || {};
  var $ = window.jQuery;

  function FilterJobs(selector) {

    this.$formElement = $(selector);
    if (this.$formElement.length === 0) {
      throw new Error("Could not find element with selector: " + selector);
    }

  }

  FilterJobs.prototype.addSearchHandler = function ( tableName ) {
    this.$formElement.on("keyup", function (event) {
        var value = $(this).val().toLowerCase();
        $(tableName + " tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  };

  App.FilterJobs = FilterJobs;
  window.App = App;
})(window);
