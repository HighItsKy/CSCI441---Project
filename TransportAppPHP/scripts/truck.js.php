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

    function Truck(truckId, db) {
        this.truckId = truckId;
        this.db = db;
    }

    Truck.prototype.createOrder = function (order) {
        console.log('Adding order for ' + order.ID);
        return this.db.add(order.ID, order);
    };

    Truck.prototype.deliverOrder = function (customerId ) {
        console.log('Completed order for ' + customerId);
        return this.db.remove(customerId);
    }

    Truck.prototype.updateOrder = function (customerId, printFn, drawingArray ) {
       
        return this.db.get(customerId).then( function (orders) {
            var customerIdArray = Object.keys(orders);
            customerIdArray.forEach(function (id) {
                if (printFn) {
                    printFn(orders[id], drawingArray);
                }
            }.bind(this));
        }.bind(this));
    };
 
    Truck.prototype.printOrders = function (printFn) {
        return this.db.getAll().then(function (orders) {
            var customerIdArray = Object.keys(orders);
            customerIdArray.forEach(function (id) {
                if (printFn) {
                    printFn(orders[id]);
                }
            }.bind(this));
        }.bind(this));
    };

    App.Truck = Truck;
    window.App = App;
})(window);