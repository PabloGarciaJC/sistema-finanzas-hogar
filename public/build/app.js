(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.constructor.js */ "./node_modules/core-js/modules/esnext.iterator.constructor.js");
__webpack_require__(/*! core-js/modules/esnext.iterator.for-each.js */ "./node_modules/core-js/modules/esnext.iterator.for-each.js");
__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
document.addEventListener('DOMContentLoaded', function () {
  var userCards = document.querySelectorAll('.user-card');
  var form = document.getElementById('login-form');
  var emailInput = document.getElementById('inputEmail');
  var passwordInput = document.getElementById('inputPassword');
  var loadingIndicator = document.getElementById('loading-indicator');

  //  Siempre ocultamos el loader al cargar
  if (loadingIndicator) {
    loadingIndicator.style.display = 'none';
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

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_object-create_js-node_modules_core-js_modules_es_array-940495","vendors-node_modules_core-js_modules_esnext_iterator_constructor_js-node_modules_core-js_modu-325f9b"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7QUFBQUEsUUFBUSxDQUFDQyxnQkFBZ0IsQ0FBQyxrQkFBa0IsRUFBRSxZQUFZO0VBQ3RELElBQU1DLFNBQVMsR0FBR0YsUUFBUSxDQUFDRyxnQkFBZ0IsQ0FBQyxZQUFZLENBQUM7RUFDekQsSUFBTUMsSUFBSSxHQUFHSixRQUFRLENBQUNLLGNBQWMsQ0FBQyxZQUFZLENBQUM7RUFDbEQsSUFBTUMsVUFBVSxHQUFHTixRQUFRLENBQUNLLGNBQWMsQ0FBQyxZQUFZLENBQUM7RUFDeEQsSUFBTUUsYUFBYSxHQUFHUCxRQUFRLENBQUNLLGNBQWMsQ0FBQyxlQUFlLENBQUM7RUFDOUQsSUFBTUcsZ0JBQWdCLEdBQUdSLFFBQVEsQ0FBQ0ssY0FBYyxDQUFDLG1CQUFtQixDQUFDOztFQUVyRTtFQUNBLElBQUlHLGdCQUFnQixFQUFFO0lBQ2xCQSxnQkFBZ0IsQ0FBQ0MsS0FBSyxDQUFDQyxPQUFPLEdBQUcsTUFBTTtFQUMzQztFQUVBUixTQUFTLENBQUNTLE9BQU8sQ0FBQyxVQUFBQyxJQUFJLEVBQUk7SUFDdEIsSUFBTUMsVUFBVSxHQUFHRCxJQUFJLENBQUNFLGFBQWEsQ0FBQyxnQkFBZ0IsQ0FBQztJQUN2REQsVUFBVSxDQUFDWixnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsVUFBVWMsQ0FBQyxFQUFFO01BQzlDQSxDQUFDLENBQUNDLGNBQWMsQ0FBQyxDQUFDO01BRWxCZCxTQUFTLENBQUNTLE9BQU8sQ0FBQyxVQUFBTSxDQUFDO1FBQUEsT0FBSUEsQ0FBQyxDQUFDQyxTQUFTLENBQUNDLE1BQU0sQ0FBQyxRQUFRLENBQUM7TUFBQSxFQUFDO01BQ3BEUCxJQUFJLENBQUNNLFNBQVMsQ0FBQ0UsR0FBRyxDQUFDLFFBQVEsQ0FBQztNQUU1QmQsVUFBVSxDQUFDZSxLQUFLLEdBQUdULElBQUksQ0FBQ1UsT0FBTyxDQUFDQyxLQUFLO01BQ3JDaEIsYUFBYSxDQUFDYyxLQUFLLEdBQUdULElBQUksQ0FBQ1UsT0FBTyxDQUFDRSxRQUFROztNQUUzQztNQUNBaEIsZ0JBQWdCLENBQUNDLEtBQUssQ0FBQ0MsT0FBTyxHQUFHLGNBQWM7O01BRS9DO01BQ0FOLElBQUksQ0FBQ3FCLE1BQU0sQ0FBQyxDQUFDO0lBQ2pCLENBQUMsQ0FBQztFQUNOLENBQUMsQ0FBQzs7RUFFRjtFQUNBekIsUUFBUSxDQUFDQyxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsVUFBVXlCLEtBQUssRUFBRTtJQUNoRCxJQUFJLENBQUNBLEtBQUssQ0FBQ0MsTUFBTSxDQUFDQyxPQUFPLENBQUMsWUFBWSxDQUFDLElBQUksQ0FBQ0YsS0FBSyxDQUFDQyxNQUFNLENBQUNDLE9BQU8sQ0FBQyxhQUFhLENBQUMsRUFBRTtNQUM3RXRCLFVBQVUsQ0FBQ2UsS0FBSyxHQUFHLEVBQUU7TUFDckJkLGFBQWEsQ0FBQ2MsS0FBSyxHQUFHLEVBQUU7TUFDeEJuQixTQUFTLENBQUNTLE9BQU8sQ0FBQyxVQUFBTSxDQUFDO1FBQUEsT0FBSUEsQ0FBQyxDQUFDQyxTQUFTLENBQUNDLE1BQU0sQ0FBQyxRQUFRLENBQUM7TUFBQSxFQUFDO0lBQ3hEO0VBQ0osQ0FBQyxDQUFDO0FBQ04sQ0FBQyxDQUFDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24gKCkge1xuICAgIGNvbnN0IHVzZXJDYXJkcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy51c2VyLWNhcmQnKTtcbiAgICBjb25zdCBmb3JtID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvZ2luLWZvcm0nKTtcbiAgICBjb25zdCBlbWFpbElucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2lucHV0RW1haWwnKTtcbiAgICBjb25zdCBwYXNzd29yZElucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2lucHV0UGFzc3dvcmQnKTtcbiAgICBjb25zdCBsb2FkaW5nSW5kaWNhdG9yID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2xvYWRpbmctaW5kaWNhdG9yJyk7XG5cbiAgICAvLyAgU2llbXByZSBvY3VsdGFtb3MgZWwgbG9hZGVyIGFsIGNhcmdhclxuICAgIGlmIChsb2FkaW5nSW5kaWNhdG9yKSB7XG4gICAgICAgIGxvYWRpbmdJbmRpY2F0b3Iuc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICB9XG5cbiAgICB1c2VyQ2FyZHMuZm9yRWFjaChjYXJkID0+IHtcbiAgICAgICAgY29uc3Qgc2VsZWN0TGluayA9IGNhcmQucXVlcnlTZWxlY3RvcignLnNlbGVjdC1hY3Rpb24nKTtcbiAgICAgICAgc2VsZWN0TGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbiAgICAgICAgICAgIHVzZXJDYXJkcy5mb3JFYWNoKGMgPT4gYy5jbGFzc0xpc3QucmVtb3ZlKCdhY3RpdmUnKSk7XG4gICAgICAgICAgICBjYXJkLmNsYXNzTGlzdC5hZGQoJ2FjdGl2ZScpO1xuXG4gICAgICAgICAgICBlbWFpbElucHV0LnZhbHVlID0gY2FyZC5kYXRhc2V0LmVtYWlsO1xuICAgICAgICAgICAgcGFzc3dvcmRJbnB1dC52YWx1ZSA9IGNhcmQuZGF0YXNldC5wYXNzd29yZDtcblxuICAgICAgICAgICAgLy8gTW9zdHJhciBlbCBpbmRpY2Fkb3IgZGUgY2FyZ2FcbiAgICAgICAgICAgIGxvYWRpbmdJbmRpY2F0b3Iuc3R5bGUuZGlzcGxheSA9ICdpbmxpbmUtYmxvY2snO1xuXG4gICAgICAgICAgICAvLyBFbnZpYXIgZWwgZm9ybXVsYXJpbyBhdXRvbcOhdGljYW1lbnRlXG4gICAgICAgICAgICBmb3JtLnN1Ym1pdCgpO1xuICAgICAgICB9KTtcbiAgICB9KTtcblxuICAgIC8vIExpbXBpYXIgZm9ybXVsYXJpbyBzaSBoYWNlcyBjbGljIGZ1ZXJhXG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbiAoZXZlbnQpIHtcbiAgICAgICAgaWYgKCFldmVudC50YXJnZXQuY2xvc2VzdCgnLnVzZXItY2FyZCcpICYmICFldmVudC50YXJnZXQuY2xvc2VzdCgnI2xvZ2luLWZvcm0nKSkge1xuICAgICAgICAgICAgZW1haWxJbnB1dC52YWx1ZSA9ICcnO1xuICAgICAgICAgICAgcGFzc3dvcmRJbnB1dC52YWx1ZSA9ICcnO1xuICAgICAgICAgICAgdXNlckNhcmRzLmZvckVhY2goYyA9PiBjLmNsYXNzTGlzdC5yZW1vdmUoJ2FjdGl2ZScpKTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7XG4iXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJhZGRFdmVudExpc3RlbmVyIiwidXNlckNhcmRzIiwicXVlcnlTZWxlY3RvckFsbCIsImZvcm0iLCJnZXRFbGVtZW50QnlJZCIsImVtYWlsSW5wdXQiLCJwYXNzd29yZElucHV0IiwibG9hZGluZ0luZGljYXRvciIsInN0eWxlIiwiZGlzcGxheSIsImZvckVhY2giLCJjYXJkIiwic2VsZWN0TGluayIsInF1ZXJ5U2VsZWN0b3IiLCJlIiwicHJldmVudERlZmF1bHQiLCJjIiwiY2xhc3NMaXN0IiwicmVtb3ZlIiwiYWRkIiwidmFsdWUiLCJkYXRhc2V0IiwiZW1haWwiLCJwYXNzd29yZCIsInN1Ym1pdCIsImV2ZW50IiwidGFyZ2V0IiwiY2xvc2VzdCJdLCJzb3VyY2VSb290IjoiIn0=