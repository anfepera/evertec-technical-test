/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/filters.js ***!
  \*********************************/
$(document).ready(function () {
  $("#email_row").hide();
  $("#product_row").show();
  $('#type_filter').change(function () {
    if ($(this).val() == "id_product") {
      $("#email_row").hide();
      $("#product_row").show();
    } else {
      $("#email_row").show();
      $("#product_row").hide();
    }
  });
});
/******/ })()
;