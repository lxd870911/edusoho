define(function(require, exports, module) {

	window.$ = window.jQuery = require('jquery');
	require('bootstrap');
	require('common/bootstrap-modal-hack');

	accessHref = window.location.href;
	accessPathName = window.location.pathname;
	accessSearch = window.location.search;
	  		
    $.post('/access/log', {accessHref:accessHref,accessPathName:accessPathName,accessSearch:accessSearch}, function(data){
    	
	});

});