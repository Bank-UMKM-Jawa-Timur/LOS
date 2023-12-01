/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

// require("./bootstrap");
// require("alpinejs");
$(".dropdown-account").on("click", function (e) {
  $(".dropdown-account-menu").toggleClass("hidden");
  e.stopPropagation();
});
$(".toggle-dp-menu").on("click", function (e) {
  $(".dropdown-menu-link").toggleClass("hidden");
  e.stopPropagation();
});
$(".toggle-menu").on("click", function (e) {
  $(".sidebar").toggleClass("hidden");
  e.stopPropagation();
});
$(".dropdown-tb-toggle").on("click", function (e) {
  $(".dropdown-tb-menu").not(this).addClass("hidden");
  $(this).next(".dropdown-tb-menu").toggleClass("hidden");
  e.stopPropagation();
});
$(document).click(function (e) {
  if (e.target.closest(".dropdown-tb-menu")) return;
  $(".dropdown-tb-menu").addClass("hidden");
});
$(document).click(function (e) {
  if (e.target.closest(".dropdown-account-menu")) return;
  $(".dropdown-account-menu").addClass("hidden");
});
$(document).click(function (e) {
  if (e.target.closest(".sidebar")) return;
  $(".sidebar").addClass("hidden");
}); // modal

$(".open-modal").on("click", function () {
  $(".modal").css("animation", "swipe-in 0.4s ease-in-out");
  $(".modal-layout").css("animation", "opacity-in 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)");
  var modalId = $(this).data("modal-id");
  $("#" + modalId).removeClass("hidden");
});
$(".modal-layout").click(function (e) {
  if (e.target.closest(".modal")) return;
  setTimeout(function () {
    $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
    $(".modal-layout").css("animation", "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)");
  }, 200);
  setTimeout(function () {
    $(".modal-layout").addClass("hidden");
  }, 400);
});
$(document).keyup(function (e) {
  if (e.key === "Escape") {
    setTimeout(function () {
      $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
      $(".modal-layout").css("animation", "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)t");
    }, 200);
    setTimeout(function () {
      $(".modal-layout").addClass("hidden");
    }, 400);
  }
});
$("[data-dismiss-id]").on("click", function () {
  var dismissId = $(this).data("dismiss-id");
  setTimeout(function () {
    $(".modal").css("animation", "swipe-out 0.2s ease-in-out");
    $(".modal-layout").css("animation", "opacity-out 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67)");
  }, 200);
  setTimeout(function () {
    $("#" + dismissId).addClass("hidden");
  }, 400);
}); // ==================================================================

var options = {
  series: [{
    name: "Disetujui",
    data: [31, 40, 28, 51, 42, 45, 58, 60, 72, 80, 109, 100]
  }, {
    name: "Ditolak",
    data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 80, 85]
  }, {
    name: "Diproses",
    data: [11, 32, 45, 32, 34, 52, 41, 43, 46, 49, 40, 65]
  }],
  colors: ["#00FF61", "#DC3545", "#F7C35C"],
  chart: {
    width: "100%",
    height: "80%",
    stacked: true,
    type: "bar",
    toolbar: {
      show: false
    },
    zoom: {
      enabled: false
    },
    fontFamily: "'Poppins', sans-serif"
  },
  plotOptions: {
    bar: {
      dataLabels: {
        position: "top"
      }
    }
  },
  stroke: {
    curve: "smooth"
  },
  legend: {
    position: "top",
    horizontalAlign: "right"
  },
  xaxis: {
    categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
  },
  tooltip: {
    x: {
      format: "dd/MM/yy HH:mm"
    }
  }
};
var chartTotalPengajuan = new ApexCharts(document.querySelector("#chart-total-pengajuan"), options);
chartTotalPengajuan.render(); // ====================================================================

Highcharts.chart("posisi-pengajuan", {
  chart: {
    type: "pie",
    width: 500,
    height: 400
  },
  title: {
    verticalAlign: "middle",
    floating: true,
    text: "<span class=\"font-bold font-poppins text-5xl flex\">\n                    <p class=\"mt-20 left-14\"><br /> <br />789<br><br></p>\n            </span>"
  },
  tooltip: {
    headerFormat: "",
    pointFormat: "<span style=\"color:{point.color}\">\u25CF</span> <b> {point.name} </b><br/><span class=\"text-gray-400\" >{point.y}</span>"
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      borderWidth: 5,
      cursor: "pointer",
      dataLabels: {
        enabled: true,
        format: "<b>{point.name}</b><br>{point.z}",
        distance: 20
      }
    }
  },
  series: [{
    minPointSize: 20,
    innerSize: "70%",
    zMin: 0,
    name: "countries",
    borderRadius: 0,
    data: [{
      name: "Pincab",
      y: 505992,
      z: 92
    }, {
      name: "PBP",
      y: 551695,
      z: 119
    }, {
      name: "PBO",
      y: 312679,
      z: 121
    }, {
      name: "Penyelia",
      y: 78865,
      z: 136
    }, {
      name: "Staff",
      y: 301336,
      z: 200
    }],
    colors: ["#67A4FF", "#FF00B8", "#FFB357", "#C300D3", "#00E0FF"]
  }]
});
Highcharts.chart("skema-kredit", {
  chart: {
    type: "pie",
    width: 500,
    height: 400
  },
  title: {
    verticalAlign: "middle",
    floating: true,
    text: "<span class=\"font-bold font-poppins text-5xl flex\">\n                <p class=\"mt-20\"><br /> <br />789<br><br></p>\n        </span>"
  },
  tooltip: {
    headerFormat: "",
    pointFormat: "<span style=\"color:{point.color}\">\u25CF</span> <b> {point.name} </b><br/><span class=\"text-gray-400\" >{point.y}</span>"
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      borderWidth: 5,
      cursor: "pointer",
      dataLabels: {
        enabled: true,
        format: "<b>{point.name}</b><br>{point.z}",
        distance: 20
      }
    }
  },
  series: [{
    minPointSize: 20,
    innerSize: "70%",
    zMin: 0,
    name: "countries",
    borderRadius: 0,
    data: [{
      name: "PKPJ",
      y: 505992,
      z: 92
    }, {
      name: "KKB",
      y: 551695,
      z: 119
    }, {
      name: "Talangan",
      y: 312679,
      z: 121
    }, {
      name: "Prokesra",
      y: 78865,
      z: 136
    }, {
      name: "Kusuma",
      y: 301336,
      z: 200
    }],
    colors: ["#FF3649", "#FFE920", "#25E76E", "#C300D3", "#4A90F9"]
  }]
});

/***/ }),

/***/ "./resources/css/app.css":
/*!*******************************!*\
  !*** ./resources/css/app.css ***!
  \*******************************/
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
/******/ 			"/assets/js/app": 0,
/******/ 			"assets/css/app": 0
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
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/css/app"], () => (__webpack_require__("./resources/css/app.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;