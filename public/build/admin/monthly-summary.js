(self["webpackChunk"] = self["webpackChunk"] || []).push([["admin/monthly-summary"],{

/***/ "./assets/admin/monthly-summary.js":
/*!*****************************************!*\
  !*** ./assets/admin/monthly-summary.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.number.to-fixed.js */ "./node_modules/core-js/modules/es.number.to-fixed.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/es.parse-float.js */ "./node_modules/core-js/modules/es.parse-float.js");
__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");
__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");
document.addEventListener('DOMContentLoaded', function () {
  var incomeInput = document.querySelector('input[name="MonthlySummary[totalIncome]"]');
  var serviceInput = document.querySelector('input[name="MonthlySummary[debt_total]"]');
  var creditOneInput = document.querySelector('input[name="MonthlySummary[bankDebtMemberOne]"]');
  var creditTwoInput = document.querySelector('input[name="MonthlySummary[bankDebtMemberTwo]"]');
  var goalInput = document.querySelector('input[name="MonthlySummary[goalTotal]"]');
  var remainingInput = document.querySelector('input[name="MonthlySummary[remainingBalance]"]');
  function parseEuropeanFloat(value) {
    return parseFloat(value.replace(/\./g, '').replace(',', '.')) || 0;
  }
  function formatToEuropean(value) {
    return value.toFixed(2).replace('.', ',');
  }
  function recalculate() {
    var income = parseEuropeanFloat((incomeInput === null || incomeInput === void 0 ? void 0 : incomeInput.value) || "0");
    var service = parseEuropeanFloat((serviceInput === null || serviceInput === void 0 ? void 0 : serviceInput.value) || "0"); // se sobrescribirá abajo
    var creditOne = parseEuropeanFloat((creditOneInput === null || creditOneInput === void 0 ? void 0 : creditOneInput.value) || "0");
    var creditTwo = parseEuropeanFloat((creditTwoInput === null || creditTwoInput === void 0 ? void 0 : creditTwoInput.value) || "0");
    var goal = parseEuropeanFloat((goalInput === null || goalInput === void 0 ? void 0 : goalInput.value) || "0");
    var newDebtTotal = creditOne + creditTwo + goal;

    // Actualizar deuda total
    if (serviceInput) {
      serviceInput.value = formatToEuropean(newDebtTotal);
    }

    // Calcular saldo restante con el nuevo valor
    var remaining = income - newDebtTotal;
    if (remainingInput) {
      remainingInput.value = formatToEuropean(remaining);
    }
  }

  // Listeners
  [incomeInput, creditOneInput, creditTwoInput, goalInput].forEach(function (input) {
    input === null || input === void 0 || input.addEventListener("input", recalculate);
  });

  // Inicial
  recalculate();
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_object-create_js-node_modules_core-js_modules_es_array-940495","vendors-node_modules_core-js_modules_es_number_to-fixed_js-node_modules_core-js_modules_es_pa-d5f033"], () => (__webpack_exec__("./assets/admin/monthly-summary.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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cmNlc0NvbnRlbnQiOlsiZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uICgpIHtcbiAgY29uc3QgaW5jb21lSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdpbnB1dFtuYW1lPVwiTW9udGhseVN1bW1hcnlbdG90YWxJbmNvbWVdXCJdJyk7XG4gIGNvbnN0IHNlcnZpY2VJbnB1dCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ2lucHV0W25hbWU9XCJNb250aGx5U3VtbWFyeVtkZWJ0X3RvdGFsXVwiXScpO1xuICBjb25zdCBjcmVkaXRPbmVJbnB1dCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ2lucHV0W25hbWU9XCJNb250aGx5U3VtbWFyeVtiYW5rRGVidE1lbWJlck9uZV1cIl0nKTtcbiAgY29uc3QgY3JlZGl0VHdvSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCdpbnB1dFtuYW1lPVwiTW9udGhseVN1bW1hcnlbYmFua0RlYnRNZW1iZXJUd29dXCJdJyk7XG4gIGNvbnN0IGdvYWxJbnB1dCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJ2lucHV0W25hbWU9XCJNb250aGx5U3VtbWFyeVtnb2FsVG90YWxdXCJdJyk7XG4gIGNvbnN0IHJlbWFpbmluZ0lucHV0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignaW5wdXRbbmFtZT1cIk1vbnRobHlTdW1tYXJ5W3JlbWFpbmluZ0JhbGFuY2VdXCJdJyk7XG5cbiAgZnVuY3Rpb24gcGFyc2VFdXJvcGVhbkZsb2F0KHZhbHVlKSB7XG4gICAgcmV0dXJuIHBhcnNlRmxvYXQodmFsdWUucmVwbGFjZSgvXFwuL2csICcnKS5yZXBsYWNlKCcsJywgJy4nKSkgfHwgMDtcbiAgfVxuXG4gIGZ1bmN0aW9uIGZvcm1hdFRvRXVyb3BlYW4odmFsdWUpIHtcbiAgICByZXR1cm4gdmFsdWUudG9GaXhlZCgyKS5yZXBsYWNlKCcuJywgJywnKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIHJlY2FsY3VsYXRlKCkge1xuICAgIGNvbnN0IGluY29tZSA9IHBhcnNlRXVyb3BlYW5GbG9hdChpbmNvbWVJbnB1dD8udmFsdWUgfHwgXCIwXCIpO1xuICAgIGNvbnN0IHNlcnZpY2UgPSBwYXJzZUV1cm9wZWFuRmxvYXQoc2VydmljZUlucHV0Py52YWx1ZSB8fCBcIjBcIik7IC8vIHNlIHNvYnJlc2NyaWJpcsOhIGFiYWpvXG4gICAgY29uc3QgY3JlZGl0T25lID0gcGFyc2VFdXJvcGVhbkZsb2F0KGNyZWRpdE9uZUlucHV0Py52YWx1ZSB8fCBcIjBcIik7XG4gICAgY29uc3QgY3JlZGl0VHdvID0gcGFyc2VFdXJvcGVhbkZsb2F0KGNyZWRpdFR3b0lucHV0Py52YWx1ZSB8fCBcIjBcIik7XG4gICAgY29uc3QgZ29hbCA9IHBhcnNlRXVyb3BlYW5GbG9hdChnb2FsSW5wdXQ/LnZhbHVlIHx8IFwiMFwiKTtcblxuICAgIGNvbnN0IG5ld0RlYnRUb3RhbCA9IGNyZWRpdE9uZSArIGNyZWRpdFR3byArIGdvYWw7XG5cbiAgICAvLyBBY3R1YWxpemFyIGRldWRhIHRvdGFsXG4gICAgaWYgKHNlcnZpY2VJbnB1dCkge1xuICAgICAgc2VydmljZUlucHV0LnZhbHVlID0gZm9ybWF0VG9FdXJvcGVhbihuZXdEZWJ0VG90YWwpO1xuICAgIH1cblxuICAgIC8vIENhbGN1bGFyIHNhbGRvIHJlc3RhbnRlIGNvbiBlbCBudWV2byB2YWxvclxuICAgIGNvbnN0IHJlbWFpbmluZyA9IGluY29tZSAtIG5ld0RlYnRUb3RhbDtcblxuICAgIGlmIChyZW1haW5pbmdJbnB1dCkge1xuICAgICAgcmVtYWluaW5nSW5wdXQudmFsdWUgPSBmb3JtYXRUb0V1cm9wZWFuKHJlbWFpbmluZyk7XG4gICAgfVxuICB9XG5cbiAgLy8gTGlzdGVuZXJzXG4gIFtpbmNvbWVJbnB1dCwgY3JlZGl0T25lSW5wdXQsIGNyZWRpdFR3b0lucHV0LCBnb2FsSW5wdXRdLmZvckVhY2goKGlucHV0KSA9PiB7XG4gICAgaW5wdXQ/LmFkZEV2ZW50TGlzdGVuZXIoXCJpbnB1dFwiLCByZWNhbGN1bGF0ZSk7XG4gIH0pO1xuXG4gIC8vIEluaWNpYWxcbiAgcmVjYWxjdWxhdGUoKTtcbn0pO1xuIl0sIm5hbWVzIjpbImRvY3VtZW50IiwiYWRkRXZlbnRMaXN0ZW5lciIsImluY29tZUlucHV0IiwicXVlcnlTZWxlY3RvciIsInNlcnZpY2VJbnB1dCIsImNyZWRpdE9uZUlucHV0IiwiY3JlZGl0VHdvSW5wdXQiLCJnb2FsSW5wdXQiLCJyZW1haW5pbmdJbnB1dCIsInBhcnNlRXVyb3BlYW5GbG9hdCIsInZhbHVlIiwicGFyc2VGbG9hdCIsInJlcGxhY2UiLCJmb3JtYXRUb0V1cm9wZWFuIiwidG9GaXhlZCIsInJlY2FsY3VsYXRlIiwiaW5jb21lIiwic2VydmljZSIsImNyZWRpdE9uZSIsImNyZWRpdFR3byIsImdvYWwiLCJuZXdEZWJ0VG90YWwiLCJyZW1haW5pbmciLCJmb3JFYWNoIiwiaW5wdXQiXSwic291cmNlUm9vdCI6IiJ9