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





// Importá tus estilos CSS para que se incluyan en el build



document.addEventListener('DOMContentLoaded', function () {
  var userCards = document.querySelectorAll('.user-card');
  var form = document.getElementById('login-form');
  var emailInput = document.getElementById('inputEmail');
  var passwordInput = document.getElementById('inputPassword');
  var loadingIndicator = document.querySelector('.spinner');

  // Verificamos si el spinner existe en la página
  if (!loadingIndicator) {
    console.error('El spinner no fue encontrado en el DOM.');
    return;
  }
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

      // Mostrar el spinner antes de enviar el formulario
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


/***/ }),

/***/ "./node_modules/bootstrap-icons/font/bootstrap-icons.css":
/*!***************************************************************!*\
  !*** ./node_modules/bootstrap-icons/font/bootstrap-icons.css ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/bootstrap/dist/css/bootstrap.min.css":
/*!***********************************************************!*\
  !*** ./node_modules/bootstrap/dist/css/bootstrap.min.css ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_obj-24d1ca","vendors-node_modules_bootstrap-icons_font_bootstrap-icons_css-node_modules_bootstrap_dist_css-b08609"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFBQTtBQUMwQjtBQUNvQjtBQUNJO0FBR2xEQSxRQUFRLENBQUNDLGdCQUFnQixDQUFDLGtCQUFrQixFQUFFLFlBQVk7RUFDdEQsSUFBTUMsU0FBUyxHQUFHRixRQUFRLENBQUNHLGdCQUFnQixDQUFDLFlBQVksQ0FBQztFQUN6RCxJQUFNQyxJQUFJLEdBQUdKLFFBQVEsQ0FBQ0ssY0FBYyxDQUFDLFlBQVksQ0FBQztFQUNsRCxJQUFNQyxVQUFVLEdBQUdOLFFBQVEsQ0FBQ0ssY0FBYyxDQUFDLFlBQVksQ0FBQztFQUV4RCxJQUFNRSxhQUFhLEdBQUdQLFFBQVEsQ0FBQ0ssY0FBYyxDQUFDLGVBQWUsQ0FBQztFQUM5RCxJQUFNRyxnQkFBZ0IsR0FBR1IsUUFBUSxDQUFDUyxhQUFhLENBQUMsVUFBVSxDQUFDOztFQUUzRDtFQUNBLElBQUksQ0FBQ0QsZ0JBQWdCLEVBQUU7SUFDbkJFLE9BQU8sQ0FBQ0MsS0FBSyxDQUFDLHlDQUF5QyxDQUFDO0lBQ3hEO0VBQ0o7RUFFQVQsU0FBUyxDQUFDVSxPQUFPLENBQUMsVUFBQUMsSUFBSSxFQUFJO0lBQ3RCLElBQU1DLFVBQVUsR0FBR0QsSUFBSSxDQUFDSixhQUFhLENBQUMsZ0JBQWdCLENBQUM7SUFDdkRLLFVBQVUsQ0FBQ2IsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFVBQVVjLENBQUMsRUFBRTtNQUM5Q0EsQ0FBQyxDQUFDQyxjQUFjLENBQUMsQ0FBQztNQUVsQmQsU0FBUyxDQUFDVSxPQUFPLENBQUMsVUFBQUssQ0FBQztRQUFBLE9BQUlBLENBQUMsQ0FBQ0MsU0FBUyxDQUFDQyxNQUFNLENBQUMsUUFBUSxDQUFDO01BQUEsRUFBQztNQUNwRE4sSUFBSSxDQUFDSyxTQUFTLENBQUNFLEdBQUcsQ0FBQyxRQUFRLENBQUM7TUFFNUJkLFVBQVUsQ0FBQ2UsS0FBSyxHQUFHUixJQUFJLENBQUNTLE9BQU8sQ0FBQ0MsS0FBSztNQUNyQ2hCLGFBQWEsQ0FBQ2MsS0FBSyxHQUFHUixJQUFJLENBQUNTLE9BQU8sQ0FBQ0UsUUFBUTs7TUFFM0M7TUFDQWhCLGdCQUFnQixDQUFDaUIsS0FBSyxDQUFDQyxPQUFPLEdBQUcsY0FBYztNQUMvQztNQUNBdEIsSUFBSSxDQUFDdUIsTUFBTSxDQUFDLENBQUM7SUFDakIsQ0FBQyxDQUFDO0VBQ04sQ0FBQyxDQUFDOztFQUVGO0VBQ0EzQixRQUFRLENBQUNDLGdCQUFnQixDQUFDLE9BQU8sRUFBRSxVQUFVMkIsS0FBSyxFQUFFO0lBQ2hELElBQUksQ0FBQ0EsS0FBSyxDQUFDQyxNQUFNLENBQUNDLE9BQU8sQ0FBQyxZQUFZLENBQUMsSUFBSSxDQUFDRixLQUFLLENBQUNDLE1BQU0sQ0FBQ0MsT0FBTyxDQUFDLGFBQWEsQ0FBQyxFQUFFO01BQzdFeEIsVUFBVSxDQUFDZSxLQUFLLEdBQUcsRUFBRTtNQUNyQmQsYUFBYSxDQUFDYyxLQUFLLEdBQUcsRUFBRTtNQUN4Qm5CLFNBQVMsQ0FBQ1UsT0FBTyxDQUFDLFVBQUFLLENBQUM7UUFBQSxPQUFJQSxDQUFDLENBQUNDLFNBQVMsQ0FBQ0MsTUFBTSxDQUFDLFFBQVEsQ0FBQztNQUFBLEVBQUM7SUFDeEQ7RUFDSixDQUFDLENBQUM7QUFDTixDQUFDLENBQUM7Ozs7Ozs7Ozs7O0FDOUNGOzs7Ozs7Ozs7Ozs7QUNBQTs7Ozs7Ozs7Ozs7O0FDQUEiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcz82YmU2Iiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9ib290c3RyYXAtaWNvbnMvZm9udC9ib290c3RyYXAtaWNvbnMuY3NzPzBkZjIiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2Jvb3RzdHJhcC9kaXN0L2Nzcy9ib290c3RyYXAubWluLmNzcz9lOTY3Il0sInNvdXJjZXNDb250ZW50IjpbIi8vIEltcG9ydMOhIHR1cyBlc3RpbG9zIENTUyBwYXJhIHF1ZSBzZSBpbmNsdXlhbiBlbiBlbCBidWlsZFxuaW1wb3J0ICcuL3N0eWxlcy9hcHAuY3NzJztcbmltcG9ydCAnYm9vdHN0cmFwL2Rpc3QvY3NzL2Jvb3RzdHJhcC5taW4uY3NzJztcbmltcG9ydCAnYm9vdHN0cmFwLWljb25zL2ZvbnQvYm9vdHN0cmFwLWljb25zLmNzcyc7XG5cblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uICgpIHtcbiAgICBjb25zdCB1c2VyQ2FyZHMgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcudXNlci1jYXJkJyk7XG4gICAgY29uc3QgZm9ybSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsb2dpbi1mb3JtJyk7XG4gICAgY29uc3QgZW1haWxJbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbnB1dEVtYWlsJyk7XG5cbiAgICBjb25zdCBwYXNzd29yZElucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2lucHV0UGFzc3dvcmQnKTtcbiAgICBjb25zdCBsb2FkaW5nSW5kaWNhdG9yID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnNwaW5uZXInKTtcblxuICAgIC8vIFZlcmlmaWNhbW9zIHNpIGVsIHNwaW5uZXIgZXhpc3RlIGVuIGxhIHDDoWdpbmFcbiAgICBpZiAoIWxvYWRpbmdJbmRpY2F0b3IpIHtcbiAgICAgICAgY29uc29sZS5lcnJvcignRWwgc3Bpbm5lciBubyBmdWUgZW5jb250cmFkbyBlbiBlbCBET00uJyk7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICB1c2VyQ2FyZHMuZm9yRWFjaChjYXJkID0+IHtcbiAgICAgICAgY29uc3Qgc2VsZWN0TGluayA9IGNhcmQucXVlcnlTZWxlY3RvcignLnNlbGVjdC1hY3Rpb24nKTtcbiAgICAgICAgc2VsZWN0TGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgICAgIHVzZXJDYXJkcy5mb3JFYWNoKGMgPT4gYy5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gICAgICAgICAgICBjYXJkLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuXG4gICAgICAgICAgICBlbWFpbElucHV0LnZhbHVlID0gY2FyZC5kYXRhc2V0LmVtYWlsO1xuICAgICAgICAgICAgcGFzc3dvcmRJbnB1dC52YWx1ZSA9IGNhcmQuZGF0YXNldC5wYXNzd29yZDtcblxuICAgICAgICAgICAgLy8gTW9zdHJhciBlbCBzcGlubmVyIGFudGVzIGRlIGVudmlhciBlbCBmb3JtdWxhcmlvXG4gICAgICAgICAgICBsb2FkaW5nSW5kaWNhdG9yLnN0eWxlLmRpc3BsYXkgPSAnaW5saW5lLWJsb2NrJztcbiAgICAgICAgICAgIC8vIEVudmlhciBlbCBmb3JtdWxhcmlvIGF1dG9tw6F0aWNhbWVudGVcbiAgICAgICAgICAgIGZvcm0uc3VibWl0KCk7XG4gICAgICAgIH0pO1xuICAgIH0pO1xuXG4gICAgLy8gTGltcGlhciBmb3JtdWxhcmlvIHNpIGhhY2VzIGNsaWMgZnVlcmFcbiAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICBpZiAoIWV2ZW50LnRhcmdldC5jbG9zZXN0KCcudXNlci1jYXJkJykgJiYgIWV2ZW50LnRhcmdldC5jbG9zZXN0KCcjbG9naW4tZm9ybScpKSB7XG4gICAgICAgICAgICBlbWFpbElucHV0LnZhbHVlID0gJyc7XG4gICAgICAgICAgICBwYXNzd29yZElucHV0LnZhbHVlID0gJyc7XG4gICAgICAgICAgICB1c2VyQ2FyZHMuZm9yRWFjaChjID0+IGMuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJykpO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJkb2N1bWVudCIsImFkZEV2ZW50TGlzdGVuZXIiLCJ1c2VyQ2FyZHMiLCJxdWVyeVNlbGVjdG9yQWxsIiwiZm9ybSIsImdldEVsZW1lbnRCeUlkIiwiZW1haWxJbnB1dCIsInBhc3N3b3JkSW5wdXQiLCJsb2FkaW5nSW5kaWNhdG9yIiwicXVlcnlTZWxlY3RvciIsImNvbnNvbGUiLCJlcnJvciIsImZvckVhY2giLCJjYXJkIiwic2VsZWN0TGluayIsImUiLCJwcmV2ZW50RGVmYXVsdCIsImMiLCJjbGFzc0xpc3QiLCJyZW1vdmUiLCJhZGQiLCJ2YWx1ZSIsImRhdGFzZXQiLCJlbWFpbCIsInBhc3N3b3JkIiwic3R5bGUiLCJkaXNwbGF5Iiwic3VibWl0IiwiZXZlbnQiLCJ0YXJnZXQiLCJjbG9zZXN0Il0sInNvdXJjZVJvb3QiOiIifQ==