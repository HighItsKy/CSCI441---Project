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
    var $ = window.jQuery;
    //var Validation = App.Validation;


    function FormHandler(selector) {
        if (!selector) {
            throw new Error('No selector provided');
        }

        this.$formElement = $(selector);
        if (this.$formElement.length === 0) {
            throw new Error('Could not find element with selector: ' + selector);
        }

    }
    
    FormHandler.prototype.addSubmitHandler = function (resetArray, fn) {
        this.$formElement.on('submit', function (event) {
            event.preventDefault();

            resetArray.forEach( function( item, number ) {
                item.setFormData();
            });

            var data = {};
            $(this).serializeArray().forEach(function (item) {
                data[item.name] = item.value;
            });
            fn(data).then(function () {

                this.reset();

            }.bind(this));

        });

        this.$formElement.on('reset', function (event) {

            resetArray.forEach( function( item, number ) {
                item.resetImage();
            });

        });

    };

    FormHandler.prototype.addInputHandler = function () {
        this.$formElement.on('input', '[name="emailAddress"]', function (event) {
            var emailAddress = event.target.value;
            var message = '';
            if (/.+@gmail\.com$/.test(emailAddress)) {
                event.target.setCustomValidity('');
            } else {
                message = emailAddress + ' is not an authorized email address!';
                event.target.setCustomValidity(message);
            }

        });
    };

    App.FormHandler = FormHandler;
    window.App = App;
})(window);