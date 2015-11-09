var app = angular.module("NgAbq", ["ngMessages", "ngPassword", "ui.bootstrap"], function($interpolateProvider) {
	$interpolateProvider.startSymbol("<%angular");
	$interpolateProvider.endSymbol("%>");
});