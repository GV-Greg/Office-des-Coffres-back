/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/components/rewards.js ***!
  \********************************************/
var grid = document.getElementsByClassName('grid-rewards-card');

var link = function link() {
  var id = this.getAttribute("data-id");
  window.location = '/odc-api-back/public/anim/grid-rewards/show-grid/' + id;
};

for (var i = 0; i < grid.length; i++) {
  grid[i].addEventListener('click', link, false);
}
/******/ })()
;