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

    function CheckList(selector) {
        if (!selector) {
            throw new Error('No selector provided');
        }

        this.$element = $(selector);
        if (this.$element.length === 0) {
            throw new Error('Could not find element with selector: ' + selector);
        }
    }

    //CheckList.prototype.addDblClickHandler = function (fn) {
    //    this.$element.on('dblclick', 'input', function (event) {
    //        var ID = event.target.value;
    //        fn(ID);
    //        this.removeRow(ID);
    //    }.bind(this));
    //};

    CheckList.prototype.addClickHandler = function ( fn, drawingArray ) {
        this.$element.on('click', 'input', function (event) {
            var ID = event.target.value;
            fn( ID, this.addData, drawingArray );
            this.$element
                .find('[value="' + ID + '"]')
                .closest('[data-transport-order="button"]')
                .prop('checked', false);
         }.bind(this));
    };

    CheckList.prototype.addData = function (transportOrder, drawingArray ) {
        
        $('input[name="ID"]').val(transportOrder.ID);
        $('input[name="TransportDate"]').val(transportOrder.TransportDate);
        $('input[name="TransportFrom"]').val(transportOrder.TransportFrom);
        $('input[name="TransportFromAddress"]').val(transportOrder.TransportFromAddress);
        $('input[name="TransportFromCityStateZip"]').val(transportOrder.TransportFromCityStateZip);
        $('input[name="TransportTo"]').val(transportOrder.TransportTo);
        $('input[name="TransportToAddress"]').val(transportOrder.TransportToAddress);
        $('input[name="TransportToCityStateZip"]').val(transportOrder.TransportToCityStateZip);
        $('input[name="Car1Year"]').val(transportOrder.Car1Year);
        $('input[name="Car1Make"]').val(transportOrder.Car1Make);
        $('input[name="Car1Model"]').val(transportOrder.Car1Model);
        $('input[name="Car1Serial"]').val(transportOrder.Car1Serial);
        $('input[name="Car1Stock"]').val(transportOrder.Car1Stock);
        $('input[name="Car1Color"]').val(transportOrder.Car1Color);
        $('input[name="Car1Price"]').val(transportOrder.Car1Price);
        $('input[name="Car2Year"]').val(transportOrder.Car2Year);
        $('input[name="Car2Make"]').val(transportOrder.Car2Make);
        $('input[name="Car2Model"]').val(transportOrder.Car2Model);
        $('input[name="Car2Serial"]').val(transportOrder.Car2Serial);
        $('input[name="Car2Stock"]').val(transportOrder.Car2Stock);
        $('input[name="Car2Color"]').val(transportOrder.Car2Color);
        $('input[name="Car2Price"]').val(transportOrder.Car2Price);
        $('input[name="Car3Year"]').val(transportOrder.Car3Year);
        $('input[name="Car3Make"]').val(transportOrder.Car3Make);
        $('input[name="Car3Model"]').val(transportOrder.Car3Model);
        $('input[name="Car3Serial"]').val(transportOrder.Car3Serial);
        $('input[name="Car3Stock"]').val(transportOrder.Car3Stock);
        $('input[name="Car3Color"]').val(transportOrder.Car3Color);
        $('input[name="Car3Price"]').val(transportOrder.Car3Price);
        $('input[name="Car4Year"]').val(transportOrder.Car4Year);
        $('input[name="Car4Make"]').val(transportOrder.Car4Make);
        $('input[name="Car4Model"]').val(transportOrder.Car4Model);
        $('input[name="Car4Serial"]').val(transportOrder.Car4Serial);
        $('input[name="Car4Stock"]').val(transportOrder.Car4Stock);
        $('input[name="Car4Color"]').val(transportOrder.Car4Color);
        $('input[name="Car4Price"]').val(transportOrder.Car4Price);
        $('input[name="Car5Year"]').val(transportOrder.Car5Year);
        $('input[name="Car5Make"]').val(transportOrder.Car5Make);
        $('input[name="Car5Model"]').val(transportOrder.Car5Model);
        $('input[name="Car5Serial"]').val(transportOrder.Car5Serial);
        $('input[name="Car5Stock"]').val(transportOrder.Car5Stock);
        $('input[name="Car5Color"]').val(transportOrder.Car5Color);
        $('input[name="Car5Price"]').val(transportOrder.Car5Price);
        $('input[name="Car6Year"]').val(transportOrder.Car6Year);
        $('input[name="Car6Make"]').val(transportOrder.Car6Make);
        $('input[name="Car6Model"]').val(transportOrder.Car6Model);
        $('input[name="Car6Serial"]').val(transportOrder.Car6Serial);
        $('input[name="Car6Stock"]').val(transportOrder.Car6Stock);
        $('input[name="Car6Color"]').val(transportOrder.Car6Color);
        $('input[name="Car6Price"]').val(transportOrder.Car6Price);
        $('select[name="driverUser"]').val(transportOrder.driverUser).change();

        $('input[name="ShipperDate"]').val(transportOrder.ShipperDate);
        $('input[name="ReceiverDate"]').val(transportOrder.ReceiverDate);

        if( transportOrder.Completed === '1')
            $('[data-transport-order="completedCheck"]').get(0).checked = true;
        else
            $('[data-transport-order="completedCheck"]').get(0).checked = false;



        $('#Car1Img').val(transportOrder.Car1Img);
        $('#Car2Img').val(transportOrder.Car2Img);
        $('#Car3Img').val(transportOrder.Car3Img);
        $('#Car4Img').val(transportOrder.Car4Img);
        $('#Car5Img').val(transportOrder.Car5Img);
        $('#Car6Img').val(transportOrder.Car6Img);
        $('#DriverImg').val(transportOrder.DriverImg);
        $('#ShipperImg').val(transportOrder.ShipperImg);
        $('#ReceiverImg').val(transportOrder.ReceiverImg);

        drawingArray[0].resetImage( transportOrder.Car1Img );
        drawingArray[1].resetImage( transportOrder.Car2Img );
        drawingArray[2].resetImage( transportOrder.Car3Img );
        drawingArray[3].resetImage( transportOrder.Car4Img );
        drawingArray[4].resetImage( transportOrder.Car5Img );
        drawingArray[5].resetImage( transportOrder.Car6Img );

        drawingArray[6].resetImage( transportOrder.DriverImg );
        drawingArray[7].resetImage( transportOrder.ShipperImg );
        drawingArray[8].resetImage( transportOrder.ReceiverImg );

        
        $('input[name="TransportDate"]').focus();
        
    };

    CheckList.prototype.addRow = function (transportOrder) {
        
        this.removeRow(transportOrder.ID);

        var rowElement = new Row(transportOrder);

        this.$element.prepend(rowElement.$element);
    };

    CheckList.prototype.removeRow = function (ID) {
           $('#'+ID).remove();
    };

    function Row(transportOrder) {

        //var $div = $('<div></div>', {
        //    'class': 'form-group',
        //    'data-transport-order': 'button'
        //});


        var $tablerow = $('<tr></tr>', {
            'id': transportOrder.ID
        });

        var $colone = $('<td></td>');

        var $checkbox = $('<input></input>', {
            type: 'button',
            value: transportOrder.ID,
            name: transportOrder.ID,
            'class': 'btn btn-outline-primary'
        });

        var $label = $('<label></label>', {
            'for': transportOrder.ID
        });

        var description = '<td>';
        description += transportOrder.TransportDate;
        description += '</td><td>';
        description += ' [' + transportOrder.TransportFrom + '] ';
        description += '</td><td>[';
        description += transportOrder.TransportTo + ']';
        description += '</td><td>'; 

        if( transportOrder.Completed === '1' )
            description += " [Completed]";
        else
            description += " [Pending]";

        description += '</td><td style="display:none">';
        description += transportOrder.Car1Serial + " ";
        description += transportOrder.Car2Serial + " ";
        description += transportOrder.Car3Serial + " ";
        description += transportOrder.Car4Serial + " ";
        description += transportOrder.Car5Serial + " ";
        description += transportOrder.Car6Serial;

        description += '</td>';


        $checkbox.append($colone);
        $tablerow.append($checkbox);
        $tablerow.append(description);

        this.$element = $tablerow;
    }

    App.CheckList = CheckList;
    window.App = App;

})(window);