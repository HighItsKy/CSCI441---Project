<?php
session_start();

if (!isset($_SESSION['user_id'])) {

  // Redirect them to the login page
  header("Location: ../index.php");
}
?>


(function (window) {
    'use strict'

    var App = window.App || {};
    var $ = window.jQuery;



    function DamageDraw(selector, dataTag, eraserCheck, image) {

        if (!selector) {
            throw new Error('No selector provided');
        }

        this.$canvasElement = $(selector);
        if (this.$canvasElement.length === 0) {
            throw new Error('Could not find element with selector: ' + selector);
        }

        this.context = this.$canvasElement.get(0).getContext('2d');

        this.backgroundImage = new Image();

        if (image) {
            this.backgroundImage.src = image;

            this.backgroundImage.onload = function () {
                this.context.drawImage(this.backgroundImage, 0, 0);
            }.bind(this);
        }

        this.$formElement = $(dataTag);
        if (this.$formElement.length === 0) {
            throw new Error('Could not find element with selector: ' + dataTag);
        }

        this.$eraserElement = $(eraserCheck);
        if (this.$eraserElement.length === 0) {
            throw new Error('Could not find element with selector: ' + eraserCheck);
        }

        this.initialImageSrc = image;
        this.clickX = new Array();
        this.clickY = new Array();
        this.clickDrag = new Array();
        this.paint = false;
        this.color = '#000000';
        this.linewidth = 3;
    }

    DamageDraw.prototype.addDrawHandlers = function (fn) {

        this.$canvasElement.mousedown(function (e) {

            var mouseX = e.pageX - this.$canvasElement.offset().left;
            var mouseY = e.pageY - this.$canvasElement.offset().top;

            this.startDraw( mouseX, mouseY );

        }.bind(this));

        this.$canvasElement.on('touchstart', function (e) {

            e.preventDefault();

            var mouseX = e.originalEvent.touches[0].pageX - this.$canvasElement.offset().left;
            var mouseY = e.originalEvent.touches[0].pageY - this.$canvasElement.offset().top;

            this.startDraw( mouseX, mouseY );
           
        }.bind(this));


        this.$canvasElement.mousemove(function (e) {

            var mouseX = e.pageX - this.$canvasElement.offset().left;
            var mouseY = e.pageY - this.$canvasElement.offset().top;

            this.moveDraw( mouseX, mouseY );

           
        }.bind(this));

        this.$canvasElement.on('touchmove', function (e) {

            e.preventDefault();

            var mouseX = e.originalEvent.touches[0].pageX - this.$canvasElement.offset().left;
            var mouseY = e.originalEvent.touches[0].pageY - this.$canvasElement.offset().top;

           this.moveDraw( mouseX, mouseY );
           
        }.bind(this));

        this.$canvasElement.mouseup(function (e) {
            this.paint = false;
        }.bind(this));

        this.$canvasElement.on('touchend', function (e) {
            e.preventDefault();
            this.paint = false;
        }.bind(this));

        this.$canvasElement.mouseleave(function (e) {
            this.paint = false;
        }.bind(this));

        this.$canvasElement.on('touchcancel', function (e) {
            e.preventDefault();
            this.paint = false;
        }.bind(this));

        this.$eraserElement.on('click', function (e) {
            var deleteLength = 1;
            if (this.clickX.length > 4)
                deleteLength = 4;

            if (this.clickX.length > 0) {
                this.clickX.length = this.clickX.length - deleteLength;
                this.clickY.length = this.clickY.length - deleteLength;
                this.clickDrag.length = this.clickDrag.length - deleteLength;
                this.redraw();
            }

        }.bind(this));

    };

    DamageDraw.prototype.resetImage = function (image) {

        this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height); // Clears the canvas
        this.clickX.length = 0;
        this.clickY.length = 0;
        this.clickDrag.length = 0;
        this.paint = false;
        if (image)
            this.backgroundImage.src = image;
        else if (this.initialImageSrc)
            this.backgroundImage.src = this.initialImageSrc;
        else
            this.backgroundImage.src = '';

        if (this.backgroundImage.src) {
            this.backgroundImage.onload = function () {
                this.context.drawImage(this.backgroundImage, 0, 0);
            }.bind(this);
        }
        this.$formElement.val('');

        //left off here on load image from checklist
    };

    DamageDraw.prototype.startDraw = function ( mouseX, mouseY ) {
        this.paint = true;

        this.addClick(mouseX, mouseY, false);

        var imgSrc = this.$formElement.val();
        if (imgSrc)
            this.backgroundImage.src = imgSrc;

        this.redraw();
    };

    DamageDraw.prototype.moveDraw = function ( mouseX, mouseY ) {

        if (this.paint) {
            this.addClick(mouseX, mouseY, true);
            var imgSrc = this.$formElement.val();
            if (imgSrc)
                this.backgroundImage.src = imgSrc;
            this.redraw();
        }

    };

    DamageDraw.prototype.setFormData = function () {

        this.$formElement.val(this.$canvasElement.get(0).toDataURL());
    };

    DamageDraw.prototype.addClick = function (x, y, dragging) {
        this.clickX.push(x);
        this.clickY.push(y);
        this.clickDrag.push(dragging);
    };

    DamageDraw.prototype.redraw = function () {
        this.context.clearRect(0, 0, this.context.canvas.width, this.context.canvas.height); // Clears the canvas
        if (this.backgroundImage)
            this.context.drawImage(this.backgroundImage, 0, 0);
        this.context.strokeStyle = this.color;
        this.context.lineJoin = "round";
        this.context.lineWidth = this.linewidth;
        for (var i = 0; i < this.clickX.length; i++) {
            this.context.beginPath();
            if (this.clickDrag[i] && i) {
                this.context.moveTo(this.clickX[i - 1], this.clickY[i - 1]);
            } else {
                this.context.moveTo(this.clickX[i] - 1, this.clickY[i]);
            }
            this.context.lineTo(this.clickX[i], this.clickY[i]);
            this.context.closePath();
            this.context.stroke();
        }
    };

    App.DamageDraw = DamageDraw;
    window.App = App;

})(window);