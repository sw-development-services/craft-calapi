/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

var createBooking = document.getElementById('add_booking');
createBooking.addEventListener('click', function () {
  // open the form
  var frmDiv = document.getElementById('new_booking_fields');
  var classes = frmDiv.classList;
  // remove the hidden class
  frmDiv.classList.toggle('hidden');
});
var getSessionInfo = function getSessionInfo() {
  return fetch('/actions/users/session-info', {
    headers: {
      'Accept': 'application/json'
    }
  }).then(function (response) {
    return response.json();
  });
};
var eventType = document.getElementById('event_type');
// const form = document.getElementById('new_booking');

eventType.addEventListener('change', function (e) {
  var request = new XMLHttpRequest();
  // const csrf = document.getElementsByName('CRAFT_CSRF_TOKEN');
  var csrfToken = document.querySelector('input[name="CRAFT_CSRF_TOKEN"]').value;
  e.preventDefault();
  var formData = new FormData();

  // console.log(csrf[1]['defaultValue']);
  request.open('POST', '/calapi/get-event-data');
  request.setRequestHeader('Content-type', 'application/json');
  request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
  request.setRequestHeader('X-CSRF-Token', csrfToken);
  formData.append('event_id', e.target.value);
  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      if (request.status === 200) {
        var obj = JSON.parse(request.responseText);
        // console.log(obj.response.link);
        var link = obj.response.link;
        // parse link
        link = link.substr(16);
        var elem = document.getElementById('schedule');
        elem.setAttribute("data-cal-link", link);
        // elem.setAttribute("data-cal-link", link);

        // ...
      } else {
        console.log("Error ".concat(request.status, ": ").concat(request.statusText));
      }
    }
  };
  request.send(JSON.stringify({
    'event_id': e.target.value
  }));
  request.onerror = function () {
    console.log('request failed');
  };
});

/***/ }),

/***/ "./resources/sass/sync-bookings.scss":
/*!*******************************************!*\
  !*** ./resources/sass/sync-bookings.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/sass/plugin-bundle.scss":
/*!*******************************************!*\
  !*** ./resources/sass/plugin-bundle.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/input.css":
/*!*****************************!*\
  !*** ./resources/input.css ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/src/web/assets/dist/PluginBundle": 0,
/******/ 			"src/web/assets/dist/input": 0,
/******/ 			"src/web/assets/dist/PluginBundle": 0,
/******/ 			"src/web/assets/dist/SyncBookingsUtility": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkcalapi"] = self["webpackChunkcalapi"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["src/web/assets/dist/input","src/web/assets/dist/PluginBundle","src/web/assets/dist/SyncBookingsUtility"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["src/web/assets/dist/input","src/web/assets/dist/PluginBundle","src/web/assets/dist/SyncBookingsUtility"], () => (__webpack_require__("./resources/sass/sync-bookings.scss")))
/******/ 	__webpack_require__.O(undefined, ["src/web/assets/dist/input","src/web/assets/dist/PluginBundle","src/web/assets/dist/SyncBookingsUtility"], () => (__webpack_require__("./resources/sass/plugin-bundle.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["src/web/assets/dist/input","src/web/assets/dist/PluginBundle","src/web/assets/dist/SyncBookingsUtility"], () => (__webpack_require__("./resources/input.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;