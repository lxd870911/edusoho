webpackJsonp(["app/js/classroom/course-list/index"],{d14d05cad9e7abf02a5d:function(e,n){"use strict";Object.defineProperty(n,"__esModule",{value:!0});n.chapterAnimate=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"body",n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:".js-task-chapter",t=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"es-icon-remove",o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"es-icon-anonymous-iconfont";$(e).on("click",n,function(e){var a=$(e.currentTarget);a.nextUntil(n).animate({height:"toggle",opacity:"toggle"},"normal");var s=a.find(".js-remove-icon"),i=a.find(".js-remove-text");s.hasClass(t)?(s.removeClass(t).addClass(o),i?i.text(Translator.trans("收起")):""):(s.removeClass(o).addClass(t),i?i.text(Translator.trans("展开")):"")})}},0:function(e,n,t){"use strict";function o(e){return e&&e.__esModule?e:{default:e}}var a=t("0b848e831f89a0e555eb"),s=o(a);new s.default($(".class-course-list"))},"0b848e831f89a0e555eb":function(e,n,t){"use strict";function o(e,n){if(!(e instanceof n))throw new TypeError("Cannot call a class as a function")}Object.defineProperty(n,"__esModule",{value:!0});var a=function(){function e(e,n){for(var t=0;t<n.length;t++){var o=n[t];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(n,t,o){return t&&e(n.prototype,t),o&&e(n,o),n}}(),s=t("d14d05cad9e7abf02a5d"),i=function(){function e(n){o(this,e),this.$element=n,(0,s.chapterAnimate)(),this.initEvent(),echo.init()}return a(e,[{key:"initEvent",value:function(){var e=this;this.$element.on("click",".es-icon-keyboardarrowdown",function(n){return e.onExpandCourse(n)}),this.$element.on("click",".es-icon-keyboardarrowup",function(n){return e.onCollapseCourse(n)})}},{key:"onExpandCourse",value:function(e){var n=$(e.currentTarget),t=n.parents(".course-item"),o=n.parents(".media").siblings(".course-detail-content");if(o.length>0)this._lessonListSHow(o);else{var a=this;$.get(n.data("lessonUrl"),{visibility:0},function(e){t.append(e),a._lessonListSHow(t.siblings(".course-detail-content"))})}n.addClass("es-icon-keyboardarrowup").removeClass("es-icon-keyboardarrowdown")}},{key:"onCollapseCourse",value:function(e){var n=$(e.currentTarget);this._lessonListSHow(n.parents(".media").siblings(".course-detail-content")),n.addClass("es-icon-keyboardarrowdown").removeClass("es-icon-keyboardarrowup")}},{key:"_lessonListSHow",value:function(e){e.length>0&&(e.animate({visibility:"toggle",opacity:"toggle",easing:"linear"}),e.height())}}]),e}();n.default=i}});