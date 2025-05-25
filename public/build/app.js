"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_esnext_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/esnext.iterator.constructor.js */ "./node_modules/core-js/modules/esnext.iterator.constructor.js");
/* harmony import */ var core_js_modules_esnext_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_esnext_iterator_constructor_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_esnext_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/esnext.iterator.for-each.js */ "./node_modules/core-js/modules/esnext.iterator.for-each.js");
/* harmony import */ var core_js_modules_esnext_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_esnext_iterator_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");
/* harmony import */ var bootstrap_dist_css_bootstrap_min_css__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! bootstrap/dist/css/bootstrap.min.css */ "./node_modules/bootstrap/dist/css/bootstrap.min.css");
/* harmony import */ var bootstrap_icons_font_bootstrap_icons_css__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! bootstrap-icons/font/bootstrap-icons.css */ "./node_modules/bootstrap-icons/font/bootstrap-icons.css");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.esm.js");





/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)





// Inicio de Sesion - Carga de Usuarios en Automatico
document.addEventListener('DOMContentLoaded', function () {
  var userCards = document.querySelectorAll('.user-card');
  var form = document.getElementById('login-form');
  var emailInput = document.getElementById('inputEmail');
  var passwordInput = document.getElementById('inputPassword');
  var loadingIndicator = document.getElementById('loading-indicator');
  userCards.forEach(function (card) {
    var selectLink = card.querySelector('.select-action');
    selectLink.addEventListener('click', function (e) {
      e.preventDefault();
      userCards.forEach(function (c) {
        return c.classList.remove('active');
      });
      card.classList.add('active');
      emailInput.value = card.dataset.email;
      passwordInput.value = card.dataset.password;

      // Mostrar el indicador de carga
      loadingIndicator.style.display = 'inline-block';

      // Enviar el formulario automáticamente
      form.submit();
    });
  });

  // Limpiar formulario si haces clic fuera
  document.addEventListener('click', function (event) {
    if (!event.target.closest('.user-card') && !event.target.closest('#login-form')) {
      emailInput.value = '';
      passwordInput.value = '';
      userCards.forEach(function (c) {
        return c.classList.remove('active');
      });
    }
  });
});

/***/ }),

/***/ "./assets/styles/app.css":
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_object-create_js-node_modules_core-js_modules_es_array-940495","vendors-node_modules_bootstrap_dist_js_bootstrap_esm_js-node_modules_bootstrap-icons_font_boo-7857f7"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQzBCO0FBQ29CO0FBQ0k7QUFFWDs7QUFFdkM7QUFDQUMsUUFBUSxDQUFDQyxnQkFBZ0IsQ0FBQyxrQkFBa0IsRUFBRSxZQUFZO0VBQ3RELElBQU1DLFNBQVMsR0FBR0YsUUFBUSxDQUFDRyxnQkFBZ0IsQ0FBQyxZQUFZLENBQUM7RUFDekQsSUFBTUMsSUFBSSxHQUFHSixRQUFRLENBQUNLLGNBQWMsQ0FBQyxZQUFZLENBQUM7RUFDbEQsSUFBTUMsVUFBVSxHQUFHTixRQUFRLENBQUNLLGNBQWMsQ0FBQyxZQUFZLENBQUM7RUFDeEQsSUFBTUUsYUFBYSxHQUFHUCxRQUFRLENBQUNLLGNBQWMsQ0FBQyxlQUFlLENBQUM7RUFDOUQsSUFBTUcsZ0JBQWdCLEdBQUdSLFFBQVEsQ0FBQ0ssY0FBYyxDQUFDLG1CQUFtQixDQUFDO0VBRXJFSCxTQUFTLENBQUNPLE9BQU8sQ0FBQyxVQUFBQyxJQUFJLEVBQUk7SUFDdEIsSUFBTUMsVUFBVSxHQUFHRCxJQUFJLENBQUNFLGFBQWEsQ0FBQyxnQkFBZ0IsQ0FBQztJQUN2REQsVUFBVSxDQUFDVixnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsVUFBVVksQ0FBQyxFQUFFO01BQzlDQSxDQUFDLENBQUNDLGNBQWMsQ0FBQyxDQUFDO01BRWxCWixTQUFTLENBQUNPLE9BQU8sQ0FBQyxVQUFBTSxDQUFDO1FBQUEsT0FBSUEsQ0FBQyxDQUFDQyxTQUFTLENBQUNDLE1BQU0sQ0FBQyxRQUFRLENBQUM7TUFBQSxFQUFDO01BQ3BEUCxJQUFJLENBQUNNLFNBQVMsQ0FBQ0UsR0FBRyxDQUFDLFFBQVEsQ0FBQztNQUU1QlosVUFBVSxDQUFDYSxLQUFLLEdBQUdULElBQUksQ0FBQ1UsT0FBTyxDQUFDQyxLQUFLO01BQ3JDZCxhQUFhLENBQUNZLEtBQUssR0FBR1QsSUFBSSxDQUFDVSxPQUFPLENBQUNFLFFBQVE7O01BRTNDO01BQ0FkLGdCQUFnQixDQUFDZSxLQUFLLENBQUNDLE9BQU8sR0FBRyxjQUFjOztNQUUvQztNQUNBcEIsSUFBSSxDQUFDcUIsTUFBTSxDQUFDLENBQUM7SUFDakIsQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDOztFQUVGO0VBQ0F6QixRQUFRLENBQUNDLGdCQUFnQixDQUFDLE9BQU8sRUFBRSxVQUFVeUIsS0FBSyxFQUFFO0lBQ2hELElBQUksQ0FBQ0EsS0FBSyxDQUFDQyxNQUFNLENBQUNDLE9BQU8sQ0FBQyxZQUFZLENBQUMsSUFBSSxDQUFDRixLQUFLLENBQUNDLE1BQU0sQ0FBQ0MsT0FBTyxDQUFDLGFBQWEsQ0FBQyxFQUFFO01BQzdFdEIsVUFBVSxDQUFDYSxLQUFLLEdBQUcsRUFBRTtNQUNyQlosYUFBYSxDQUFDWSxLQUFLLEdBQUcsRUFBRTtNQUN4QmpCLFNBQVMsQ0FBQ08sT0FBTyxDQUFDLFVBQUFNLENBQUM7UUFBQSxPQUFJQSxDQUFDLENBQUNDLFNBQVMsQ0FBQ0MsTUFBTSxDQUFDLFFBQVEsQ0FBQztNQUFBLEVBQUM7SUFDeEQ7RUFDSixDQUFDLENBQUM7QUFDTixDQUFDLENBQUM7Ozs7Ozs7Ozs7O0FDakRGIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5jc3M/M2ZiYSJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFdlIHJlY29tbWVuZCBpbmNsdWRpbmcgdGhlIGJ1aWx0IHZlcnNpb24gb2YgdGhpcyBKYXZhU2NyaXB0IGZpbGVcbiAqIChhbmQgaXRzIENTUyBmaWxlKSBpbiB5b3VyIGJhc2UgbGF5b3V0IChiYXNlLmh0bWwudHdpZykuXG4gKi9cblxuLy8gYW55IENTUyB5b3UgaW1wb3J0IHdpbGwgb3V0cHV0IGludG8gYSBzaW5nbGUgY3NzIGZpbGUgKGFwcC5jc3MgaW4gdGhpcyBjYXNlKVxuaW1wb3J0ICcuL3N0eWxlcy9hcHAuY3NzJztcbmltcG9ydCAnYm9vdHN0cmFwL2Rpc3QvY3NzL2Jvb3RzdHJhcC5taW4uY3NzJztcbmltcG9ydCAnYm9vdHN0cmFwLWljb25zL2ZvbnQvYm9vdHN0cmFwLWljb25zLmNzcyc7XG5cbmltcG9ydCAqIGFzIGJvb3RzdHJhcCBmcm9tICdib290c3RyYXAnO1xuXG4vLyBJbmljaW8gZGUgU2VzaW9uIC0gQ2FyZ2EgZGUgVXN1YXJpb3MgZW4gQXV0b21hdGljb1xuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uICgpIHtcbiAgICBjb25zdCB1c2VyQ2FyZHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcudXNlci1jYXJkJyk7XG4gICAgY29uc3QgZm9ybSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsb2dpbi1mb3JtJyk7XG4gICAgY29uc3QgZW1haWxJbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbnB1dEVtYWlsJyk7XG4gICAgY29uc3QgcGFzc3dvcmRJbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbnB1dFBhc3N3b3JkJyk7XG4gICAgY29uc3QgbG9hZGluZ0luZGljYXRvciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsb2FkaW5nLWluZGljYXRvcicpO1xuXG4gICAgdXNlckNhcmRzLmZvckVhY2goY2FyZCA9PiB7XG4gICAgICAgIGNvbnN0IHNlbGVjdExpbmsgPSBjYXJkLnF1ZXJ5U2VsZWN0b3IoJy5zZWxlY3QtYWN0aW9uJyk7XG4gICAgICAgIHNlbGVjdExpbmsuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuICAgICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG4gICAgICAgICAgICB1c2VyQ2FyZHMuZm9yRWFjaChjID0+IGMuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJykpO1xuICAgICAgICAgICAgY2FyZC5jbGFzc0xpc3QuYWRkKCdhY3RpdmUnKTtcblxuICAgICAgICAgICAgZW1haWxJbnB1dC52YWx1ZSA9IGNhcmQuZGF0YXNldC5lbWFpbDtcbiAgICAgICAgICAgIHBhc3N3b3JkSW5wdXQudmFsdWUgPSBjYXJkLmRhdGFzZXQucGFzc3dvcmQ7XG5cbiAgICAgICAgICAgIC8vIE1vc3RyYXIgZWwgaW5kaWNhZG9yIGRlIGNhcmdhXG4gICAgICAgICAgICBsb2FkaW5nSW5kaWNhdG9yLnN0eWxlLmRpc3BsYXkgPSAnaW5saW5lLWJsb2NrJztcblxuICAgICAgICAgICAgLy8gRW52aWFyIGVsIGZvcm11bGFyaW8gYXV0b23DoXRpY2FtZW50ZVxuICAgICAgICAgICAgZm9ybS5zdWJtaXQoKTtcbiAgICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICAvLyBMaW1waWFyIGZvcm11bGFyaW8gc2kgaGFjZXMgY2xpYyBmdWVyYVxuICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgIGlmICghZXZlbnQudGFyZ2V0LmNsb3Nlc3QoJy51c2VyLWNhcmQnKSAmJiAhZXZlbnQudGFyZ2V0LmNsb3Nlc3QoJyNsb2dpbi1mb3JtJykpIHtcbiAgICAgICAgICAgIGVtYWlsSW5wdXQudmFsdWUgPSAnJztcbiAgICAgICAgICAgIHBhc3N3b3JkSW5wdXQudmFsdWUgPSAnJztcbiAgICAgICAgICAgIHVzZXJDYXJkcy5mb3JFYWNoKGMgPT4gYy5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJib290c3RyYXAiLCJkb2N1bWVudCIsImFkZEV2ZW50TGlzdGVuZXIiLCJ1c2VyQ2FyZHMiLCJxdWVyeVNlbGVjdG9yQWxsIiwiZm9ybSIsImdldEVsZW1lbnRCeUlkIiwiZW1haWxJbnB1dCIsInBhc3N3b3JkSW5wdXQiLCJsb2FkaW5nSW5kaWNhdG9yIiwiZm9yRWFjaCIsImNhcmQiLCJzZWxlY3RMaW5rIiwicXVlcnlTZWxlY3RvciIsImUiLCJwcmV2ZW50RGVmYXVsdCIsImMiLCJjbGFzc0xpc3QiLCJyZW1vdmUiLCJhZGQiLCJ2YWx1ZSIsImRhdGFzZXQiLCJlbWFpbCIsInBhc3N3b3JkIiwic3R5bGUiLCJkaXNwbGF5Iiwic3VibWl0IiwiZXZlbnQiLCJ0YXJnZXQiLCJjbG9zZXN0Il0sInNvdXJjZVJvb3QiOiIifQ==