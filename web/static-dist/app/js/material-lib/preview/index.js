webpackJsonp(["app/js/material-lib/preview/index"],[function(e,l){"use strict";var a=$("#material-preview-player"),r=a.data("url");if(a.length>0){var i="<iframe src='"+r+"' id='viewerIframe' width='100%'allowfullscreen webkitallowfullscreen height='100%' style='border:0px'></iframe>";a.html(i)}var t=$("#modal");t.on("hidden.bs.modal",function(){a.length>0&&a.html("")})}]);