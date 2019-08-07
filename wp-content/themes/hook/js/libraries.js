/* jshint ignore:start */

//EXTERNAL SCRIPTS------------------------------------------

/*
 * imagesLoaded PACKAGED v4.1.0
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
!function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}(this,function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},n=i[t]=i[t]||[];return-1==n.indexOf(e)&&n.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{},n=i[t]=i[t]||[];return n[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=i.indexOf(e);return-1!=n&&i.splice(n,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=0,o=i[n];e=e||[];for(var r=this._onceEvents&&this._onceEvents[t];o;){var s=r&&r[o];s&&(this.off(t,o),delete r[o]),o.apply(this,e),n+=s?0:1,o=i[n]}return this}},t}),function(t,e){"use strict";"function"==typeof define&&define.amd?define(["ev-emitter/ev-emitter"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter")):t.imagesLoaded=e(t,t.EvEmitter)}(window,function(t,e){function i(t,e){for(var i in e)t[i]=e[i];return t}function n(t){var e=[];if(Array.isArray(t))e=t;else if("number"==typeof t.length)for(var i=0;i<t.length;i++)e.push(t[i]);else e.push(t);return e}function o(t,e,r){return this instanceof o?("string"==typeof t&&(t=document.querySelectorAll(t)),this.elements=n(t),this.options=i({},this.options),"function"==typeof e?r=e:i(this.options,e),r&&this.on("always",r),this.getImages(),h&&(this.jqDeferred=new h.Deferred),void setTimeout(function(){this.check()}.bind(this))):new o(t,e,r)}function r(t){this.img=t}function s(t,e){this.url=t,this.element=e,this.img=new Image}var h=t.jQuery,a=t.console;o.prototype=Object.create(e.prototype),o.prototype.options={},o.prototype.getImages=function(){this.images=[],this.elements.forEach(this.addElementImages,this)},o.prototype.addElementImages=function(t){"IMG"==t.nodeName&&this.addImage(t),this.options.background===!0&&this.addElementBackgroundImages(t);var e=t.nodeType;if(e&&d[e]){for(var i=t.querySelectorAll("img"),n=0;n<i.length;n++){var o=i[n];this.addImage(o)}if("string"==typeof this.options.background){var r=t.querySelectorAll(this.options.background);for(n=0;n<r.length;n++){var s=r[n];this.addElementBackgroundImages(s)}}}};var d={1:!0,9:!0,11:!0};return o.prototype.addElementBackgroundImages=function(t){var e=getComputedStyle(t);if(e)for(var i=/url\((['"])?(.*?)\1\)/gi,n=i.exec(e.backgroundImage);null!==n;){var o=n&&n[2];o&&this.addBackground(o,t),n=i.exec(e.backgroundImage)}},o.prototype.addImage=function(t){var e=new r(t);this.images.push(e)},o.prototype.addBackground=function(t,e){var i=new s(t,e);this.images.push(i)},o.prototype.check=function(){function t(t,i,n){setTimeout(function(){e.progress(t,i,n)})}var e=this;return this.progressedCount=0,this.hasAnyBroken=!1,this.images.length?void this.images.forEach(function(e){e.once("progress",t),e.check()}):void this.complete()},o.prototype.progress=function(t,e,i){this.progressedCount++,this.hasAnyBroken=this.hasAnyBroken||!t.isLoaded,this.emitEvent("progress",[this,t,e]),this.jqDeferred&&this.jqDeferred.notify&&this.jqDeferred.notify(this,t),this.progressedCount==this.images.length&&this.complete(),this.options.debug&&a&&a.log("progress: "+i,t,e)},o.prototype.complete=function(){var t=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emitEvent(t,[this]),this.emitEvent("always",[this]),this.jqDeferred){var e=this.hasAnyBroken?"reject":"resolve";this.jqDeferred[e](this)}},r.prototype=Object.create(e.prototype),r.prototype.check=function(){var t=this.getIsImageComplete();return t?void this.confirm(0!==this.img.naturalWidth,"naturalWidth"):(this.proxyImage=new Image,this.proxyImage.addEventListener("load",this),this.proxyImage.addEventListener("error",this),this.img.addEventListener("load",this),this.img.addEventListener("error",this),void(this.proxyImage.src=this.img.src))},r.prototype.getIsImageComplete=function(){return this.img.complete&&void 0!==this.img.naturalWidth},r.prototype.confirm=function(t,e){this.isLoaded=t,this.emitEvent("progress",[this,this.img,e])},r.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},r.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindEvents()},r.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindEvents()},r.prototype.unbindEvents=function(){this.proxyImage.removeEventListener("load",this),this.proxyImage.removeEventListener("error",this),this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype=Object.create(r.prototype),s.prototype.check=function(){this.img.addEventListener("load",this),this.img.addEventListener("error",this),this.img.src=this.url;var t=this.getIsImageComplete();t&&(this.confirm(0!==this.img.naturalWidth,"naturalWidth"),this.unbindEvents())},s.prototype.unbindEvents=function(){this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype.confirm=function(t,e){this.isLoaded=t,this.emitEvent("progress",[this,this.element,e])},o.makeJQueryPlugin=function(e){e=e||t.jQuery,e&&(h=e,h.fn.imagesLoaded=function(t,e){var i=new o(this,t,e);return i.jqDeferred.promise(h(this))})},o.makeJQueryPlugin(),o});


/* Modernizr 2.7.1 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-csstransitions-shiv-cssclasses-prefixed-testprop-testallprops-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function x(a){j.cssText=a}function y(a,b){return x(prefixes.join(a+";")+(b||""))}function z(a,b){return typeof a===b}function A(a,b){return!!~(""+a).indexOf(b)}function B(a,b){for(var d in a){var e=a[d];if(!A(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function C(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:z(f,"function")?f.bind(d||b):f}return!1}function D(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+n.join(d+" ")+d).split(" ");return z(b,"string")||z(b,"undefined")?B(e,b):(e=(a+" "+o.join(d+" ")+d).split(" "),C(e,b,c))}var d="2.7.1",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m="Webkit Moz O ms",n=m.split(" "),o=m.toLowerCase().split(" "),p={},q={},r={},s=[],t=s.slice,u,v={}.hasOwnProperty,w;!z(v,"undefined")&&!z(v.call,"undefined")?w=function(a,b){return v.call(a,b)}:w=function(a,b){return b in a&&z(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=t.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(t.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(t.call(arguments)))};return e}),p.csstransitions=function(){return D("transition")};for(var E in p)w(p,E)&&(u=E.toLowerCase(),e[u]=p[E](),s.push((e[u]?"":"no-")+u));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)w(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},x(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._domPrefixes=o,e._cssomPrefixes=n,e.testProp=function(a){return B([a])},e.testAllProps=D,e.prefixed=function(a,b,c){return b?D(a,b,c):D(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+s.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};

/*
 * debouncedresize: special jQuery event that happens once after a window resize
 *
 * latest version and complete README available on Github:
 * https://github.com/louisremi/jquery-smartresize
 *
 * Copyright 2012 @louis_remi
 * Licensed under the MIT license.
 *
 */

(function($) {

    var $event = $.event,
        $special,
        resizeTimeout;

    $special = $event.special.debouncedresize = {
        setup: function() {
            $( this ).on( "resize", $special.handler );
        },
        teardown: function() {
            $( this ).off( "resize", $special.handler );
        },
        handler: function( event, execAsap ) {
            var context = this,
                args = arguments,
                dispatch = function() {
                    event.type = "debouncedresize";
                    $event.dispatch.apply( context, args );
                };

            if ( resizeTimeout ) {
                clearTimeout( resizeTimeout );
            }

            execAsap ?
                dispatch() :
                resizeTimeout = setTimeout( dispatch, $special.threshold );
        },
        threshold: 150
    };

})(jQuery);

/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;(function( $ ){

    'use strict';

    $.fn.fitVids = function( options ) {
        var settings = {
            customSelector: null,
            ignore: null
        };

        if(!document.getElementById('fit-vids-style')) {
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }

        if ( options ) {
            $.extend( settings, options );
        }

        return this.each(function(){
            var selectors = [
                'iframe[src*="player.vimeo.com"]',
                'iframe[src*="youtube.com"]',
                'iframe[src*="flixel.com"]',
                'iframe[src*="youtube-nocookie.com"]',
                'iframe[src*="kickstarter.com"][src*="video.html"]',
                'object',
                'embed'
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var ignoreList = '.fitvidsignore';

            if(settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('.wpb_video_wrapper iframe');
            $allVideos = $allVideos.not('object object');
            $allVideos = $allVideos.not(ignoreList);

            $allVideos.each(function(count){
                var $this = $(this);
                if($this.parents(ignoreList).length > 0) {
                    return;
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
                {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('id')){
                    var videoID = 'fitvid' + count;
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
})( window.jQuery || window.Zepto );

/*
 *  jQuery OwlCarousel v1.3.3
 *
 *  Copyright (c) 2013 Bartosz Wojciechowski
 *  http://www.owlgraphic.com/owlcarousel/
 *
 *  Licensed under MIT
 *
 */


if (typeof Object.create !== "function") {
    Object.create = function (obj) {
        function F() {}
        F.prototype = obj;
        return new F();
    };
}
(function ($, window, document) {

    var Carousel = {
        init : function (options, el) {
            var base = this;

            base.$elem = $(el);
            base.options = $.extend({}, $.fn.owlCarousel.options, base.$elem.data(), options);

            base.userOptions = options;
            base.loadContent();
        },

        loadContent : function () {
            var base = this, url;

            function getData(data) {
                var i, content = "";
                if (typeof base.options.jsonSuccess === "function") {
                    base.options.jsonSuccess.apply(this, [data]);
                } else {
                    for (i in data.owl) {
                        if (data.owl.hasOwnProperty(i)) {
                            content += data.owl[i].item;
                        }
                    }
                    base.$elem.html(content);
                }
                base.logIn();
            }

            if (typeof base.options.beforeInit === "function") {
                base.options.beforeInit.apply(this, [base.$elem]);
            }

            if (typeof base.options.jsonPath === "string") {
                url = base.options.jsonPath;
                $.getJSON(url, getData);
            } else {
                base.logIn();
            }
        },

        logIn : function () {
            var base = this;

            base.$elem.data("owl-originalStyles", base.$elem.attr("style"));
            base.$elem.data("owl-originalClasses", base.$elem.attr("class"));

            base.orignalItems = base.options.items;
            base.checkBrowser();
            base.wrapperWidth = 0;
            base.checkVisible = null;
            base.setVars();
        },

        setVars : function () {
            var base = this;
            if (base.$elem.children().length === 0) {return false; }
            base.baseClass();
            base.eventTypes();
            base.$userItems = base.$elem.children();
            base.itemsAmount = base.$userItems.length;
            base.wrapItems();
            base.$owlItems = base.$elem.find(".owl-item");
            base.$owlWrapper = base.$elem.find(".owl-wrapper");
            base.playDirection = "next";
            base.prevItem = 0;
            base.prevArr = [0];
            base.currentItem = 0;
            base.customEvents();
            base.onStartup();
        },

        onStartup : function () {
            var base = this;
            base.updateItems();
            base.calculateAll();
            base.buildControls();
            base.updateControls();
            base.response();
            base.moveEvents();
            base.stopOnHover();
            base.owlStatus();

            if (base.options.transitionStyle !== false) {
                if (base.options.transitionStyle==="slide" || base.options.transitionStyle==="") {
                    base.options.transitionStyle=false;
                }
                else {
                    base.transitionTypes(base.options.transitionStyle);
                }
            }
            if (base.options.autoPlay === true) {
                base.options.autoPlay = 5000;
            }
            base.play();

            base.$elem.find(".owl-wrapper").css("display", "block");

            if (!base.$elem.is(":visible")) {
                base.watchVisibility();
            } else {

            }
            base.onstartup = false;
            base.eachMoveUpdate();
            if (typeof base.options.afterInit === "function") {
                base.options.afterInit.apply(this, [base.$elem]);
            }
        },

        eachMoveUpdate : function () {
            var base = this;

            if (base.options.lazyLoad === true) {
                base.lazyLoad();
            }
            if (base.options.autoHeight === true) {
                base.autoHeight();
            }
            base.onVisibleItems();

            if (typeof base.options.afterAction === "function") {
                base.options.afterAction.apply(this, [base.$elem]);
            }
        },

        updateVars : function () {
            var base = this;
            if (typeof base.options.beforeUpdate === "function") {
                base.options.beforeUpdate.apply(this, [base.$elem]);
            }
            base.watchVisibility();
            base.updateItems();
            base.calculateAll();
            base.updatePosition();
            base.updateControls();
            base.eachMoveUpdate();
            if (typeof base.options.afterUpdate === "function") {
                base.options.afterUpdate.apply(this, [base.$elem]);
            }
        },

        reload : function () {
            var base = this;
            window.setTimeout(function () {
                base.updateVars();
            }, 0);
        },

        watchVisibility : function () {
            var base = this;

            if (base.$elem.is(":visible") === false) {
                window.clearInterval(base.autoPlayInterval);
                window.clearInterval(base.checkVisible);
            } else {
                return false;
            }
            base.checkVisible = window.setInterval(function () {
                if (base.$elem.is(":visible")) {
                    base.reload();
                    window.clearInterval(base.checkVisible);
                }
            }, 500);
        },

        wrapItems : function () {
            var base = this;
            base.$userItems.wrapAll("<div class=\"owl-wrapper\">").wrap("<div class=\"owl-item\"></div>");
            base.$elem.find(".owl-wrapper").wrap("<div class=\"owl-wrapper-outer\">");
            base.wrapperOuter = base.$elem.find(".owl-wrapper-outer");
            base.$elem.css("display", "block");
        },

        baseClass : function () {
            var base = this,
                hasBaseClass = base.$elem.hasClass(base.options.baseClass),
                hasThemeClass = base.$elem.hasClass(base.options.theme);

            if (!hasBaseClass) {
                base.$elem.addClass(base.options.baseClass);
            }

            if (!hasThemeClass) {
                base.$elem.addClass(base.options.theme);
            }
        },

        updateItems : function () {
            var base = this, width, i;

            if (base.options.responsive === false) {
                return false;
            }
            if (base.options.singleItem === true) {
                base.options.items = base.orignalItems = 1;
                base.options.itemsCustom = false;
                base.options.itemsDesktop = false;
                base.options.itemsDesktopSmall = false;
                base.options.itemsTablet = false;
                base.options.itemsTabletSmall = false;
                base.options.itemsMobile = false;
                return false;
            }

            width = $(base.options.responsiveBaseWidth).width();

            if (width > (base.options.itemsDesktop[0] || base.orignalItems)) {
                base.options.items = base.orignalItems;
            }
            if (base.options.itemsCustom !== false) {
                //Reorder array by screen size
                base.options.itemsCustom.sort(function (a, b) {return a[0] - b[0]; });

                for (i = 0; i < base.options.itemsCustom.length; i += 1) {
                    if (base.options.itemsCustom[i][0] <= width) {
                        base.options.items = base.options.itemsCustom[i][1];
                    }
                }

            } else {

                if (width <= base.options.itemsDesktop[0] && base.options.itemsDesktop !== false) {
                    base.options.items = base.options.itemsDesktop[1];
                }

                if (width <= base.options.itemsDesktopSmall[0] && base.options.itemsDesktopSmall !== false) {
                    base.options.items = base.options.itemsDesktopSmall[1];
                }

                if (width <= base.options.itemsTablet[0] && base.options.itemsTablet !== false) {
                    base.options.items = base.options.itemsTablet[1];
                }

                if (width <= base.options.itemsTabletSmall[0] && base.options.itemsTabletSmall !== false) {
                    base.options.items = base.options.itemsTabletSmall[1];
                }

                if (width <= base.options.itemsMobile[0] && base.options.itemsMobile !== false) {
                    base.options.items = base.options.itemsMobile[1];
                }
            }

            //if number of items is less than declared
            if (base.options.items > base.itemsAmount && base.options.itemsScaleUp === true) {
                base.options.items = base.itemsAmount;
            }
        },

        response : function () {
            var base = this,
                smallDelay,
                lastWindowWidth;

            if (base.options.responsive !== true) {
                return false;
            }
            lastWindowWidth = $(window).width();

            base.resizer = function () {
                if ($(window).width() !== lastWindowWidth) {
                    if (base.options.autoPlay !== false) {
                        window.clearInterval(base.autoPlayInterval);
                    }
                    window.clearTimeout(smallDelay);
                    smallDelay = window.setTimeout(function () {
                        lastWindowWidth = $(window).width();
                        base.updateVars();
                    }, base.options.responsiveRefreshRate);
                }
            };
            $(window).resize(base.resizer);
        },

        updatePosition : function () {
            var base = this;
            base.jumpTo(base.currentItem);
            if (base.options.autoPlay !== false) {
                base.checkAp();
            }
        },

        appendItemsSizes : function () {
            var base = this,
                roundPages = 0,
                lastItem = base.itemsAmount - base.options.items;

            base.$owlItems.each(function (index) {
                var $this = $(this);
                $this
                    .css({"width": base.itemWidth})
                    .data("owl-item", Number(index));

                if (index % base.options.items === 0 || index === lastItem) {
                    if (!(index > lastItem)) {
                        roundPages += 1;
                    }
                }
                $this.data("owl-roundPages", roundPages);
            });
        },

        appendWrapperSizes : function () {
            var base = this,
                width = base.$owlItems.length * base.itemWidth;

            base.$owlWrapper.css({
                "width": width * 2,
                "left": 0
            });
            base.appendItemsSizes();
        },

        calculateAll : function () {
            var base = this;
            base.calculateWidth();
            base.appendWrapperSizes();
            base.loops();
            base.max();
        },

        calculateWidth : function () {
            var base = this;
            base.itemWidth = Math.round(base.$elem.width() / base.options.items);
        },

        max : function () {
            var base = this,
                maximum = ((base.itemsAmount * base.itemWidth) - base.options.items * base.itemWidth) * -1;
            if (base.options.items > base.itemsAmount) {
                base.maximumItem = 0;
                maximum = 0;
                base.maximumPixels = 0;
            } else {
                base.maximumItem = base.itemsAmount - base.options.items;
                base.maximumPixels = maximum;
            }
            return maximum;
        },

        min : function () {
            return 0;
        },

        loops : function () {
            var base = this,
                prev = 0,
                elWidth = 0,
                i,
                item,
                roundPageNum;

            base.positionsInArray = [0];
            base.pagesInArray = [];

            for (i = 0; i < base.itemsAmount; i += 1) {
                elWidth += base.itemWidth;
                base.positionsInArray.push(-elWidth);

                if (base.options.scrollPerPage === true) {
                    item = $(base.$owlItems[i]);
                    roundPageNum = item.data("owl-roundPages");
                    if (roundPageNum !== prev) {
                        base.pagesInArray[prev] = base.positionsInArray[i];
                        prev = roundPageNum;
                    }
                }
            }
        },

        buildControls : function () {
            var base = this;
            if (base.options.navigation === true || base.options.pagination === true) {
                base.owlControls = $("<div class=\"owl-controls\"/>").toggleClass("clickable", !base.browser.isTouch).appendTo(base.$elem);
            }
            if (base.options.pagination === true) {
                base.buildPagination();
            }
            if (base.options.navigation === true) {
                base.buildButtons();
            }
        },

        buildButtons : function () {
            var base = this,
                buttonsWrapper = $("<div class=\"owl-buttons\"/>");
            base.owlControls.append(buttonsWrapper);

            base.buttonPrev = $("<div/>", {
                "class" : "owl-prev",
                "html" : base.options.navigationText[0] || ""
            });

            base.buttonNext = $("<div/>", {
                "class" : "owl-next",
                "html" : base.options.navigationText[1] || ""
            });

            buttonsWrapper
                .append(base.buttonPrev)
                .append(base.buttonNext);

            buttonsWrapper.on("touchstart.owlControls mousedown.owlControls", "div[class^=\"owl\"]", function (event) {
                event.preventDefault();
            });

            buttonsWrapper.on("touchend.owlControls mouseup.owlControls", "div[class^=\"owl\"]", function (event) {
                event.preventDefault();
                if ($(this).hasClass("owl-next")) {
                    base.next();
                } else {
                    base.prev();
                }
            });
        },

        buildPagination : function () {
            var base = this;

            base.paginationWrapper = $("<div class=\"owl-pagination\"/>");
            base.owlControls.append(base.paginationWrapper);

            base.paginationWrapper.on("touchend.owlControls mouseup.owlControls", ".owl-page", function (event) {
                event.preventDefault();
                if (Number($(this).data("owl-page")) !== base.currentItem) {
                    base.goTo(Number($(this).data("owl-page")), true);
                }
            });
        },

        updatePagination : function () {
            var base = this,
                counter,
                lastPage,
                lastItem,
                i,
                paginationButton,
                paginationButtonInner;

            if (base.options.pagination === false) {
                return false;
            }

            base.paginationWrapper.html("");

            counter = 0;
            lastPage = base.itemsAmount - base.itemsAmount % base.options.items;

            for (i = 0; i < base.itemsAmount; i += 1) {
                if (i % base.options.items === 0) {
                    counter += 1;
                    if (lastPage === i) {
                        lastItem = base.itemsAmount - base.options.items;
                    }
                    paginationButton = $("<div/>", {
                        "class" : "owl-page"
                    });
                    paginationButtonInner = $("<span></span>", {
                        "text": base.options.paginationNumbers === true ? counter : "",
                        "class": base.options.paginationNumbers === true ? "owl-numbers" : ""
                    });
                    paginationButton.append(paginationButtonInner);

                    paginationButton.data("owl-page", lastPage === i ? lastItem : i);
                    paginationButton.data("owl-roundPages", counter);

                    base.paginationWrapper.append(paginationButton);
                }
            }
            base.checkPagination();
        },
        checkPagination : function () {
            var base = this;
            if (base.options.pagination === false) {
                return false;
            }
            base.paginationWrapper.find(".owl-page").each(function () {
                if ($(this).data("owl-roundPages") === $(base.$owlItems[base.currentItem]).data("owl-roundPages")) {
                    base.paginationWrapper
                        .find(".owl-page")
                        .removeClass("active");
                    $(this).addClass("active");
                }
            });
        },

        checkNavigation : function () {
            var base = this;

            if (base.options.navigation === false) {
                return false;
            }
            if (base.options.rewindNav === false) {
                if (base.currentItem === 0 && base.maximumItem === 0) {
                    base.buttonPrev.addClass("disabled");
                    base.buttonNext.addClass("disabled");
                } else if (base.currentItem === 0 && base.maximumItem !== 0) {
                    base.buttonPrev.addClass("disabled");
                    base.buttonNext.removeClass("disabled");
                } else if (base.currentItem === base.maximumItem) {
                    base.buttonPrev.removeClass("disabled");
                    base.buttonNext.addClass("disabled");
                } else if (base.currentItem !== 0 && base.currentItem !== base.maximumItem) {
                    base.buttonPrev.removeClass("disabled");
                    base.buttonNext.removeClass("disabled");
                }
            }
        },

        updateControls : function () {
            var base = this;
            base.updatePagination();
            base.checkNavigation();
            if (base.owlControls) {
                if (base.options.items >= base.itemsAmount) {
                    base.owlControls.hide();
                } else {
                    base.owlControls.show();
                }
            }
        },

        destroyControls : function () {
            var base = this;
            if (base.owlControls) {
                base.owlControls.remove();
            }
        },

        next : function (speed) {
            var base = this;

            if (base.isTransition) {
                return false;
            }

            base.currentItem += base.options.scrollPerPage === true ? base.options.items : 1;
            if (base.currentItem > base.maximumItem + (base.options.scrollPerPage === true ? (base.options.items - 1) : 0)) {
                if (base.options.rewindNav === true) {
                    base.currentItem = 0;
                    speed = "rewind";
                } else {
                    base.currentItem = base.maximumItem;
                    return false;
                }
            }
            base.goTo(base.currentItem, speed);
        },

        prev : function (speed) {
            var base = this;

            if (base.isTransition) {
                return false;
            }

            if (base.options.scrollPerPage === true && base.currentItem > 0 && base.currentItem < base.options.items) {
                base.currentItem = 0;
            } else {
                base.currentItem -= base.options.scrollPerPage === true ? base.options.items : 1;
            }
            if (base.currentItem < 0) {
                if (base.options.rewindNav === true) {
                    base.currentItem = base.maximumItem;
                    speed = "rewind";
                } else {
                    base.currentItem = 0;
                    return false;
                }
            }
            base.goTo(base.currentItem, speed);
        },

        goTo : function (position, speed, drag) {
            var base = this,
                goToPixel;

            if (base.isTransition) {
                return false;
            }
            if (typeof base.options.beforeMove === "function") {
                base.options.beforeMove.apply(this, [base.$elem]);
            }
            if (position >= base.maximumItem) {
                position = base.maximumItem;
            } else if (position <= 0) {
                position = 0;
            }

            base.currentItem = base.owl.currentItem = position;
            if (base.options.transitionStyle !== false && drag !== "drag" && base.options.items === 1 && base.browser.support3d === true) {
                base.swapSpeed(0);
                if (base.browser.support3d === true) {
                    base.transition3d(base.positionsInArray[position]);
                } else {
                    base.css2slide(base.positionsInArray[position], 1);
                }
                base.afterGo();
                base.singleItemTransition();
                return false;
            }
            goToPixel = base.positionsInArray[position];

            if (base.browser.support3d === true) {
                base.isCss3Finish = false;

                if (speed === true) {
                    base.swapSpeed("paginationSpeed");
                    window.setTimeout(function () {
                        base.isCss3Finish = true;
                    }, base.options.paginationSpeed);

                } else if (speed === "rewind") {
                    base.swapSpeed(base.options.rewindSpeed);
                    window.setTimeout(function () {
                        base.isCss3Finish = true;
                    }, base.options.rewindSpeed);

                } else {
                    base.swapSpeed("slideSpeed");
                    window.setTimeout(function () {
                        base.isCss3Finish = true;
                    }, base.options.slideSpeed);
                }
                base.transition3d(goToPixel);
            } else {
                if (speed === true) {
                    base.css2slide(goToPixel, base.options.paginationSpeed);
                } else if (speed === "rewind") {
                    base.css2slide(goToPixel, base.options.rewindSpeed);
                } else {
                    base.css2slide(goToPixel, base.options.slideSpeed);
                }
            }
            base.afterGo();
        },

        jumpTo : function (position) {
            var base = this;
            if (typeof base.options.beforeMove === "function") {
                base.options.beforeMove.apply(this, [base.$elem]);
            }
            if (position >= base.maximumItem || position === -1) {
                position = base.maximumItem;
            } else if (position <= 0) {
                position = 0;
            }
            base.swapSpeed(0);
            if (base.browser.support3d === true) {
                base.transition3d(base.positionsInArray[position]);
            } else {
                base.css2slide(base.positionsInArray[position], 1);
            }
            base.currentItem = base.owl.currentItem = position;
            base.afterGo();
        },

        afterGo : function () {
            var base = this;

            base.prevArr.push(base.currentItem);
            base.prevItem = base.owl.prevItem = base.prevArr[base.prevArr.length - 2];
            base.prevArr.shift(0);

            if (base.prevItem !== base.currentItem) {
                base.checkPagination();
                base.checkNavigation();
                base.eachMoveUpdate();

                if (base.options.autoPlay !== false) {
                    base.checkAp();
                }
            }
            if (typeof base.options.afterMove === "function" && base.prevItem !== base.currentItem) {
                base.options.afterMove.apply(this, [base.$elem]);
            }
        },

        stop : function () {
            var base = this;
            base.apStatus = "stop";
            window.clearInterval(base.autoPlayInterval);
        },

        checkAp : function () {
            var base = this;
            if (base.apStatus !== "stop") {
                base.play();
            }
        },

        play : function () {
            var base = this;
            base.apStatus = "play";
            if (base.options.autoPlay === false) {
                return false;
            }
            window.clearInterval(base.autoPlayInterval);
            base.autoPlayInterval = window.setInterval(function () {
                base.next(true);
            }, base.options.autoPlay);
        },

        swapSpeed : function (action) {
            var base = this;
            if (action === "slideSpeed") {
                base.$owlWrapper.css(base.addCssSpeed(base.options.slideSpeed));
            } else if (action === "paginationSpeed") {
                base.$owlWrapper.css(base.addCssSpeed(base.options.paginationSpeed));
            } else if (typeof action !== "string") {
                base.$owlWrapper.css(base.addCssSpeed(action));
            }
        },

        addCssSpeed : function (speed) {
            return {
                "-webkit-transition": "all " + speed + "ms ease",
                "-moz-transition": "all " + speed + "ms ease",
                "-o-transition": "all " + speed + "ms ease",
                "transition": "all " + speed + "ms ease"
            };
        },

        removeTransition : function () {
            return {
                "-webkit-transition": "",
                "-moz-transition": "",
                "-o-transition": "",
                "transition": ""
            };
        },

        doTranslate : function (pixels) {
            return {
                "-webkit-transform": "translate3d(" + pixels + "px, 0px, 0px)",
                "-moz-transform": "translate3d(" + pixels + "px, 0px, 0px)",
                "-o-transform": "translate3d(" + pixels + "px, 0px, 0px)",
                "-ms-transform": "translate3d(" + pixels + "px, 0px, 0px)",
                "transform": "translate3d(" + pixels + "px, 0px,0px)"
            };
        },

        transition3d : function (value) {
            var base = this;
            base.$owlWrapper.css(base.doTranslate(value));
        },

        css2move : function (value) {
            var base = this;
            base.$owlWrapper.css({"left" : value});
        },

        css2slide : function (value, speed) {
            var base = this;

            base.isCssFinish = false;
            base.$owlWrapper.stop(true, true).animate({
                "left" : value
            }, {
                duration : speed || base.options.slideSpeed,
                complete : function () {
                    base.isCssFinish = true;
                }
            });
        },

        checkBrowser : function () {
            var base = this,
                translate3D = "translate3d(0px, 0px, 0px)",
                tempElem = document.createElement("div"),
                regex,
                asSupport,
                support3d,
                isTouch;

            tempElem.style.cssText = "  -moz-transform:" + translate3D +
                "; -ms-transform:"     + translate3D +
                "; -o-transform:"      + translate3D +
                "; -webkit-transform:" + translate3D +
                "; transform:"         + translate3D;
            regex = /translate3d\(0px, 0px, 0px\)/g;
            asSupport = tempElem.style.cssText.match(regex);
            support3d=false;
            if (asSupport !== null && asSupport.length) {
                support3d=true;
            }

            isTouch = "ontouchstart" in window || window.navigator.msMaxTouchPoints;

            base.browser = {
                "support3d" : support3d,
                "isTouch" : isTouch
            };
        },

        moveEvents : function () {
            var base = this;
            if (base.options.mouseDrag !== false || base.options.touchDrag !== false) {
                base.gestures();
                base.disabledEvents();
            }
        },

        eventTypes : function () {
            var base = this,
                types = ["s", "e", "x"];

            base.ev_types = {};

            if (base.options.mouseDrag === true && base.options.touchDrag === true) {
                types = [
                    "touchstart.owl mousedown.owl",
                    "touchmove.owl mousemove.owl",
                    "touchend.owl touchcancel.owl mouseup.owl"
                ];
            } else if (base.options.mouseDrag === false && base.options.touchDrag === true) {
                types = [
                    "touchstart.owl",
                    "touchmove.owl",
                    "touchend.owl touchcancel.owl"
                ];
            } else if (base.options.mouseDrag === true && base.options.touchDrag === false) {
                types = [
                    "mousedown.owl",
                    "mousemove.owl",
                    "mouseup.owl"
                ];
            }

            base.ev_types.start = types[0];
            base.ev_types.move = types[1];
            base.ev_types.end = types[2];
        },

        disabledEvents :  function () {
            var base = this;
            base.$elem.on("dragstart.owl", function (event) { event.preventDefault(); });
            base.$elem.on("mousedown.disableTextSelect", function (e) {
                return $(e.target).is('input, textarea, select, option');
            });
        },

        gestures : function () {
            /*jslint unparam: true*/
            var base = this,
                locals = {
                    offsetX : 0,
                    offsetY : 0,
                    baseElWidth : 0,
                    relativePos : 0,
                    position: null,
                    minSwipe : null,
                    maxSwipe: null,
                    sliding : null,
                    dargging: null,
                    targetElement : null
                };

            base.isCssFinish = true;

            function getTouches(event) {
                if (event.touches !== undefined) {
                    return {
                        x : event.touches[0].pageX,
                        y : event.touches[0].pageY
                    };
                }

                if (event.touches === undefined) {
                    if (event.pageX !== undefined) {
                        return {
                            x : event.pageX,
                            y : event.pageY
                        };
                    }
                    if (event.pageX === undefined) {
                        return {
                            x : event.clientX,
                            y : event.clientY
                        };
                    }
                }
            }

            function swapEvents(type) {
                if (type === "on") {
                    $(document).on(base.ev_types.move, dragMove);
                    $(document).on(base.ev_types.end, dragEnd);
                } else if (type === "off") {
                    $(document).off(base.ev_types.move);
                    $(document).off(base.ev_types.end);
                }
            }

            function dragStart(event) {
                var ev = event.originalEvent || event || window.event,
                    position;

                if (ev.which === 3) {
                    return false;
                }
                if (base.itemsAmount <= base.options.items) {
                    return;
                }
                if (base.isCssFinish === false && !base.options.dragBeforeAnimFinish) {
                    return false;
                }
                if (base.isCss3Finish === false && !base.options.dragBeforeAnimFinish) {
                    return false;
                }

                if (base.options.autoPlay !== false) {
                    window.clearInterval(base.autoPlayInterval);
                }

                if (base.browser.isTouch !== true && !base.$owlWrapper.hasClass("grabbing")) {
                    base.$owlWrapper.addClass("grabbing");
                }

                base.newPosX = 0;
                base.newRelativeX = 0;

                $(this).css(base.removeTransition());

                position = $(this).position();
                locals.relativePos = position.left;

                locals.offsetX = getTouches(ev).x - position.left;
                locals.offsetY = getTouches(ev).y - position.top;

                swapEvents("on");

                locals.sliding = false;
                locals.targetElement = ev.target || ev.srcElement;
            }

            function dragMove(event) {
                var ev = event.originalEvent || event || window.event,
                    minSwipe,
                    maxSwipe;

                base.newPosX = getTouches(ev).x - locals.offsetX;
                base.newPosY = getTouches(ev).y - locals.offsetY;
                base.newRelativeX = base.newPosX - locals.relativePos;

                if (typeof base.options.startDragging === "function" && locals.dragging !== true && base.newRelativeX !== 0) {
                    locals.dragging = true;
                    base.options.startDragging.apply(base, [base.$elem]);
                }

                if ((base.newRelativeX > 8 || base.newRelativeX < -8) && (base.browser.isTouch === true)) {
                    if (ev.preventDefault !== undefined) {
                        ev.preventDefault();
                    } else {
                        ev.returnValue = false;
                    }
                    locals.sliding = true;
                }

                if ((base.newPosY > 10 || base.newPosY < -10) && locals.sliding === false) {
                    $(document).off("touchmove.owl");
                }

                minSwipe = function () {
                    return base.newRelativeX / 5;
                };

                maxSwipe = function () {
                    return base.maximumPixels + base.newRelativeX / 5;
                };

                base.newPosX = Math.max(Math.min(base.newPosX, minSwipe()), maxSwipe());
                if (base.browser.support3d === true) {
                    base.transition3d(base.newPosX);
                } else {
                    base.css2move(base.newPosX);
                }
            }

            function dragEnd(event) {
                var ev = event.originalEvent || event || window.event,
                    newPosition,
                    handlers,
                    owlStopEvent;

                ev.target = ev.target || ev.srcElement;

                locals.dragging = false;

                if (base.browser.isTouch !== true) {
                    base.$owlWrapper.removeClass("grabbing");
                }

                if (base.newRelativeX < 0) {
                    base.dragDirection = base.owl.dragDirection = "left";
                } else {
                    base.dragDirection = base.owl.dragDirection = "right";
                }

                if (base.newRelativeX !== 0) {
                    newPosition = base.getNewPosition();
                    base.goTo(newPosition, false, "drag");
                    if (locals.targetElement === ev.target && base.browser.isTouch !== true) {
                        $(ev.target).on("click.disable", function (ev) {
                            ev.stopImmediatePropagation();
                            ev.stopPropagation();
                            ev.preventDefault();
                            $(ev.target).off("click.disable");
                        });
                        handlers = $._data(ev.target, "events").click;
                        owlStopEvent = handlers.pop();
                        handlers.splice(0, 0, owlStopEvent);
                    }
                }
                swapEvents("off");
            }
            base.$elem.on(base.ev_types.start, ".owl-wrapper", dragStart);
        },

        getNewPosition : function () {
            var base = this,
                newPosition = base.closestItem();

            if (newPosition > base.maximumItem) {
                base.currentItem = base.maximumItem;
                newPosition  = base.maximumItem;
            } else if (base.newPosX >= 0) {
                newPosition = 0;
                base.currentItem = 0;
            }
            return newPosition;
        },
        closestItem : function () {
            var base = this,
                array = base.options.scrollPerPage === true ? base.pagesInArray : base.positionsInArray,
                goal = base.newPosX,
                closest = null;

            $.each(array, function (i, v) {
                if (goal - (base.itemWidth / 20) > array[i + 1] && goal - (base.itemWidth / 20) < v && base.moveDirection() === "left") {
                    closest = v;
                    if (base.options.scrollPerPage === true) {
                        base.currentItem = $.inArray(closest, base.positionsInArray);
                    } else {
                        base.currentItem = i;
                    }
                } else if (goal + (base.itemWidth / 20) < v && goal + (base.itemWidth / 20) > (array[i + 1] || array[i] - base.itemWidth) && base.moveDirection() === "right") {
                    if (base.options.scrollPerPage === true) {
                        closest = array[i + 1] || array[array.length - 1];
                        base.currentItem = $.inArray(closest, base.positionsInArray);
                    } else {
                        closest = array[i + 1];
                        base.currentItem = i + 1;
                    }
                }
            });
            return base.currentItem;
        },

        moveDirection : function () {
            var base = this,
                direction;
            if (base.newRelativeX < 0) {
                direction = "right";
                base.playDirection = "next";
            } else {
                direction = "left";
                base.playDirection = "prev";
            }
            return direction;
        },

        customEvents : function () {
            /*jslint unparam: true*/
            var base = this;
            base.$elem.on("owl.next", function () {
                base.next();
            });
            base.$elem.on("owl.prev", function () {
                base.prev();
            });
            base.$elem.on("owl.play", function (event, speed) {
                base.options.autoPlay = speed;
                base.play();
                base.hoverStatus = "play";
            });
            base.$elem.on("owl.stop", function () {
                base.stop();
                base.hoverStatus = "stop";
            });
            base.$elem.on("owl.goTo", function (event, item) {
                base.goTo(item);
            });
            base.$elem.on("owl.jumpTo", function (event, item) {
                base.jumpTo(item);
            });
        },

        stopOnHover : function () {
            var base = this;
            if (base.options.stopOnHover === true && base.browser.isTouch !== true && base.options.autoPlay !== false) {
                base.$elem.on("mouseover", function () {
                    base.stop();
                });
                base.$elem.on("mouseout", function () {
                    if (base.hoverStatus !== "stop") {
                        base.play();
                    }
                });
            }
        },

        lazyLoad : function () {
            var base = this,
                i,
                $item,
                itemNumber,
                $lazyImg,
                follow;

            if (base.options.lazyLoad === false) {
                return false;
            }
            for (i = 0; i < base.itemsAmount; i += 1) {
                $item = $(base.$owlItems[i]);

                if ($item.data("owl-loaded") === "loaded") {
                    continue;
                }

                itemNumber = $item.data("owl-item");
                $lazyImg = $item.find(".lazyOwl");

                if (typeof $lazyImg.data("src") !== "string") {
                    $item.data("owl-loaded", "loaded");
                    continue;
                }
                if ($item.data("owl-loaded") === undefined) {
                    $lazyImg.hide();
                    $item.addClass("loading").data("owl-loaded", "checked");
                }
                if (base.options.lazyFollow === true) {
                    follow = itemNumber >= base.currentItem;
                } else {
                    follow = true;
                }
                if (follow && itemNumber < base.currentItem + base.options.items && $lazyImg.length) {
                    base.lazyPreload($item, $lazyImg);
                }
            }
        },

        lazyPreload : function ($item, $lazyImg) {
            var base = this,
                iterations = 0,
                isBackgroundImg;

            if ($lazyImg.prop("tagName") === "DIV") {
                $lazyImg.css("background-image", "url(" + $lazyImg.data("src") + ")");
                isBackgroundImg = true;
            } else {
                $lazyImg[0].src = $lazyImg.data("src");
            }

            function showImage() {
                $item.data("owl-loaded", "loaded").removeClass("loading");
                $lazyImg.removeAttr("data-src");
                if (base.options.lazyEffect === "fade") {
                    $lazyImg.fadeIn(400);
                } else {
                    $lazyImg.show();
                }
                if (typeof base.options.afterLazyLoad === "function") {
                    base.options.afterLazyLoad.apply(this, [base.$elem]);
                }
            }

            function checkLazyImage() {
                iterations += 1;
                if (base.completeImg($lazyImg.get(0)) || isBackgroundImg === true) {
                    showImage();
                } else if (iterations <= 100) {//if image loads in less than 10 seconds
                    window.setTimeout(checkLazyImage, 100);
                } else {
                    showImage();
                }
            }

            checkLazyImage();
        },

        autoHeight : function () {
            var base = this,
                $currentimg = $(base.$owlItems[base.currentItem]).find("img"),
                iterations;

            function addHeight() {
                var $currentItem = $(base.$owlItems[base.currentItem]).height();
                base.wrapperOuter.css("height", $currentItem + "px");
                if (!base.wrapperOuter.hasClass("autoHeight")) {
                    window.setTimeout(function () {
                        base.wrapperOuter.addClass("autoHeight");
                    }, 0);
                }
            }

            function checkImage() {
                iterations += 1;
                if (base.completeImg($currentimg.get(0))) {
                    addHeight();
                } else if (iterations <= 100) { //if image loads in less than 10 seconds
                    window.setTimeout(checkImage, 100);
                } else {
                    base.wrapperOuter.css("height", ""); //Else remove height attribute
                }
            }

            if ($currentimg.get(0) !== undefined) {
                iterations = 0;
                checkImage();
            } else {
                addHeight();
            }
        },

        completeImg : function (img) {
            var naturalWidthType;

            if (!img.complete) {
                return false;
            }
            naturalWidthType = typeof img.naturalWidth;
            if (naturalWidthType !== "undefined" && img.naturalWidth === 0) {
                return false;
            }
            return true;
        },

        onVisibleItems : function () {
            var base = this,
                i;

            if (base.options.addClassActive === true) {
                base.$owlItems.removeClass("active");
            }
            base.visibleItems = [];
            for (i = base.currentItem; i < base.currentItem + base.options.items; i += 1) {
                base.visibleItems.push(i);

                if (base.options.addClassActive === true) {
                    $(base.$owlItems[i]).addClass("active");
                }
            }
            base.owl.visibleItems = base.visibleItems;
        },

        transitionTypes : function (className) {
            var base = this;
            //Currently available: "fade", "backSlide", "goDown", "fadeUp"
            base.outClass = "owl-" + className + "-out";
            base.inClass = "owl-" + className + "-in";
        },

        singleItemTransition : function () {
            var base = this,
                outClass = base.outClass,
                inClass = base.inClass,
                $currentItem = base.$owlItems.eq(base.currentItem),
                $prevItem = base.$owlItems.eq(base.prevItem),
                prevPos = Math.abs(base.positionsInArray[base.currentItem]) + base.positionsInArray[base.prevItem],
                origin = Math.abs(base.positionsInArray[base.currentItem]) + base.itemWidth / 2,
                animEnd = 'webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend';

            base.isTransition = true;

            base.$owlWrapper
                .addClass('owl-origin')
                .css({
                    "-webkit-transform-origin" : origin + "px",
                    "-moz-perspective-origin" : origin + "px",
                    "perspective-origin" : origin + "px"
                });
            function transStyles(prevPos) {
                return {
                    "position" : "relative",
                    "left" : prevPos + "px"
                };
            }

            $prevItem
                .css(transStyles(prevPos, 10))
                .addClass(outClass)
                .on(animEnd, function () {
                    base.endPrev = true;
                    $prevItem.off(animEnd);
                    base.clearTransStyle($prevItem, outClass);
                });

            $currentItem
                .addClass(inClass)
                .on(animEnd, function () {
                    base.endCurrent = true;
                    $currentItem.off(animEnd);
                    base.clearTransStyle($currentItem, inClass);
                });
        },

        clearTransStyle : function (item, classToRemove) {
            var base = this;
            item.css({
                "position" : "",
                "left" : ""
            }).removeClass(classToRemove);

            if (base.endPrev && base.endCurrent) {
                base.$owlWrapper.removeClass('owl-origin');
                base.endPrev = false;
                base.endCurrent = false;
                base.isTransition = false;
            }
        },

        owlStatus : function () {
            var base = this;
            base.owl = {
                "userOptions"   : base.userOptions,
                "baseElement"   : base.$elem,
                "userItems"     : base.$userItems,
                "owlItems"      : base.$owlItems,
                "currentItem"   : base.currentItem,
                "prevItem"      : base.prevItem,
                "visibleItems"  : base.visibleItems,
                "isTouch"       : base.browser.isTouch,
                "browser"       : base.browser,
                "dragDirection" : base.dragDirection
            };
        },

        clearEvents : function () {
            var base = this;
            base.$elem.off(".owl owl mousedown.disableTextSelect");
            $(document).off(".owl owl");
            $(window).off("resize", base.resizer);
        },

        unWrap : function () {
            var base = this;
            if (base.$elem.children().length !== 0) {
                base.$owlWrapper.unwrap();
                base.$userItems.unwrap().unwrap();
                if (base.owlControls) {
                    base.owlControls.remove();
                }
            }
            base.clearEvents();
            base.$elem
                .attr("style", base.$elem.data("owl-originalStyles") || "")
                .attr("class", base.$elem.data("owl-originalClasses"));
        },

        destroy : function () {
            var base = this;
            base.stop();
            window.clearInterval(base.checkVisible);
            base.unWrap();
            base.$elem.removeData();
        },

        reinit : function (newOptions) {
            var base = this,
                options = $.extend({}, base.userOptions, newOptions);
            base.unWrap();
            base.init(options, base.$elem);
        },

        addItem : function (htmlString, targetPosition) {
            var base = this,
                position;

            if (!htmlString) {return false; }

            if (base.$elem.children().length === 0) {
                base.$elem.append(htmlString);
                base.setVars();
                return false;
            }
            base.unWrap();
            if (targetPosition === undefined || targetPosition === -1) {
                position = -1;
            } else {
                position = targetPosition;
            }
            if (position >= base.$userItems.length || position === -1) {
                base.$userItems.eq(-1).after(htmlString);
            } else {
                base.$userItems.eq(position).before(htmlString);
            }

            base.setVars();
        },

        removeItem : function (targetPosition) {
            var base = this,
                position;

            if (base.$elem.children().length === 0) {
                return false;
            }
            if (targetPosition === undefined || targetPosition === -1) {
                position = -1;
            } else {
                position = targetPosition;
            }

            base.unWrap();
            base.$userItems.eq(position).remove();
            base.setVars();
        }

    };

    $.fn.owlCarousel = function (options) {
        return this.each(function () {
            if ($(this).data("owl-init") === true) {
                return false;
            }
            $(this).data("owl-init", true);
            var carousel = Object.create(Carousel);
            carousel.init(options, this);
            $.data(this, "owlCarousel", carousel);
        });
    };

    $.fn.owlCarousel.options = {

        items : 5,
        itemsCustom : false,
        itemsDesktop : [1199, 4],
        itemsDesktopSmall : [979, 3],
        itemsTablet : [768, 2],
        itemsTabletSmall : false,
        itemsMobile : [479, 1],
        singleItem : false,
        itemsScaleUp : false,

        slideSpeed : 200,
        paginationSpeed : 800,
        rewindSpeed : 1000,

        autoPlay : false,
        stopOnHover : false,

        navigation : false,
        navigationText : ["prev", "next"],
        rewindNav : true,
        scrollPerPage : false,

        pagination : true,
        paginationNumbers : false,

        responsive : true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth : window,

        baseClass : "owl-carousel",
        theme : "owl-theme",

        lazyLoad : false,
        lazyFollow : true,
        lazyEffect : "fade",

        autoHeight : false,

        jsonPath : false,
        jsonSuccess : false,

        dragBeforeAnimFinish : true,
        mouseDrag : true,
        touchDrag : true,

        addClassActive : false,
        transitionStyle : false,

        beforeUpdate : false,
        afterUpdate : false,
        beforeInit : false,
        afterInit : false,
        beforeMove : false,
        afterMove : false,
        afterAction : false,
        startDragging : false,
        afterLazyLoad: false
    };
}(jQuery, window, document));


//
// SmoothScroll for websites v1.4.4 (Balazs Galambosi)
// http://www.smoothscroll.net/
//
// Licensed under the terms of the MIT license.
//

(function () {

// Scroll Variables (tweakable)
    var defaultOptions = {

        // Scrolling Core
        frameRate        : 150, // [Hz]
        animationTime    : 850, // [ms]
        stepSize         : 120, // [px]

        // Pulse (less tweakable)
        // ratio of "tail" to "acceleration"
        pulseAlgorithm   : true,
        pulseScale       : 4,
        pulseNormalize   : 1,

        // Acceleration
        accelerationDelta : 50,  // 50
        accelerationMax   : 3,   // 3

        // Keyboard Settings
        keyboardSupport   : true,  // option
        arrowScroll       : 50,    // [px]

        // Other
        touchpadSupport   : false, // ignore touchpad by default
        fixedBackground   : true,
        excluded          : ''
    };

    var options = defaultOptions;


// Other Variables
    var isExcluded = false;
    var isFrame = false;
    var direction = { x: 0, y: 0 };
    var initDone  = false;
    var root = document.documentElement;
    var activeElement;
    var observer;
    var refreshSize;
    var deltaBuffer = [];
    var isMac = /^Mac/.test(navigator.platform);

    var key = { left: 37, up: 38, right: 39, down: 40, spacebar: 32,
        pageup: 33, pagedown: 34, end: 35, home: 36 };
    var arrowKeys = { 37: 1, 38: 1, 39: 1, 40: 1 };

    /***********************************************
     * INITIALIZE
     ***********************************************/

    /**
     * Tests if smooth scrolling is allowed. Shuts down everything if not.
     */
    function initTest() {
        if (options.keyboardSupport) {
            addEvent('keydown', keydown);
        }
    }

    /**
     * Sets up scrolls array, determines if frames are involved.
     */
    function init() {

        if (initDone || !document.body) return;

        initDone = true;

        var body = document.body;
        var html = document.documentElement;
        var windowHeight = window.innerHeight;
        var scrollHeight = body.scrollHeight;

        // check compat mode for root element
        root = (document.compatMode.indexOf('CSS') >= 0) ? html : body;
        activeElement = body;

        initTest();

        // Checks if this script is running in a frame
        if (top != self) {
            isFrame = true;
        }

        else if (scrollHeight > windowHeight &&
            (body.offsetHeight <= windowHeight ||
                html.offsetHeight <= windowHeight)) {

            var fullPageElem = document.createElement('div');
            fullPageElem.style.cssText = 'position:absolute; z-index:-10000; ' +
                'top:0; left:0; right:0; height:' +
                root.scrollHeight + 'px';
            document.body.appendChild(fullPageElem);

            // DOM changed (throttled) to fix height
            var pendingRefresh;
            refreshSize = function () {
                if (pendingRefresh) return; // could also be: clearTimeout(pendingRefresh);
                pendingRefresh = setTimeout(function () {
                    if (isExcluded) return; // could be running after cleanup
                    fullPageElem.style.height = '0';
                    fullPageElem.style.height = root.scrollHeight + 'px';
                    pendingRefresh = null;
                }, 500); // act rarely to stay fast
            };

            setTimeout(refreshSize, 10);

            addEvent('resize', refreshSize);

            var config = {
                attributes: true,
                childList: true,
                characterData: false
            };

            observer = new MutationObserver(refreshSize);
            observer.observe(body, config);

            if (root.offsetHeight <= windowHeight) {
                var clearfix = document.createElement('div');
                clearfix.style.clear = 'both';
                body.appendChild(clearfix);
            }
        }

        // disable fixed background
        if (!options.fixedBackground && !isExcluded) {
            body.style.backgroundAttachment = 'scroll';
            html.style.backgroundAttachment = 'scroll';
        }
    }

    /**
     * Removes event listeners and other traces left on the page.
     */
    function cleanup() {
        observer && observer.disconnect();
        removeEvent(wheelEvent, wheel);
        removeEvent('mousedown', mousedown);
        removeEvent('keydown', keydown);
        removeEvent('resize', refreshSize);
        removeEvent('load', init);
    }


    /************************************************
     * SCROLLING
     ************************************************/

    var que = [];
    var pending = false;
    var lastScroll = Date.now();

    /**
     * Pushes scroll actions to the scrolling queue.
     */
    function scrollArray(elem, left, top) {

        directionCheck(left, top);

        if (options.accelerationMax != 1) {
            var now = Date.now();
            var elapsed = now - lastScroll;
            if (elapsed < options.accelerationDelta) {
                var factor = (1 + (50 / elapsed)) / 2;
                if (factor > 1) {
                    factor = Math.min(factor, options.accelerationMax);
                    left *= factor;
                    top  *= factor;
                }
            }
            lastScroll = Date.now();
        }

        // push a scroll command
        que.push({
            x: left,
            y: top,
            lastX: (left < 0) ? 0.99 : -0.99,
            lastY: (top  < 0) ? 0.99 : -0.99,
            start: Date.now()
        });

        // don't act if there's a pending queue
        if (pending) {
            return;
        }

        var scrollWindow = (elem === document.body);

        var step = function (time) {

            var now = Date.now();
            var scrollX = 0;
            var scrollY = 0;

            for (var i = 0; i < que.length; i++) {

                var item = que[i];
                var elapsed  = now - item.start;
                var finished = (elapsed >= options.animationTime);

                var position = (finished) ? 1 : elapsed / options.animationTime;

                // easing [optional]
                if (options.pulseAlgorithm) {
                    position = pulse(position);
                }

                // only need the difference
                var x = (item.x * position - item.lastX) >> 0;
                var y = (item.y * position - item.lastY) >> 0;

                // add this to the total scrolling
                scrollX += x;
                scrollY += y;

                // update last values
                item.lastX += x;
                item.lastY += y;

                // delete and step back if it's over
                if (finished) {
                    que.splice(i, 1); i--;
                }
            }

            // scroll left and top
            if (scrollWindow) {
                window.scrollBy(scrollX, scrollY);
            }
            else {
                if (scrollX) elem.scrollLeft += scrollX;
                if (scrollY) elem.scrollTop  += scrollY;
            }

            // clean up if there's nothing left to do
            if (!left && !top) {
                que = [];
            }

            if (que.length) {
                requestFrame(step, elem, (1000 / options.frameRate + 1));
            } else {
                pending = false;
            }
        };

        // start a new queue of actions
        requestFrame(step, elem, 0);
        pending = true;
    }


    /***********************************************
     * EVENTS
     ***********************************************/

    /**
     * Mouse wheel handler.
     * @param {Object} event
     */
    function wheel(event) {
        if (!initDone) {
            init();
        }

        var target = event.target;
        var overflowing = overflowingAncestor(target);

        // use default if there's no overflowing
        // element or default action is prevented
        // or it's a zooming event with CTRL
        if (!overflowing || event.defaultPrevented || event.ctrlKey) {
            return true;
        }

        // leave embedded content alone (flash & pdf)
        if (isNodeName(activeElement, 'embed') ||
            (isNodeName(target, 'embed') && /\.pdf/i.test(target.src)) ||
            isNodeName(activeElement, 'object') ||
            target.shadowRoot) {
            return true;
        }

        var deltaX = -event.wheelDeltaX || event.deltaX || 0;
        var deltaY = -event.wheelDeltaY || event.deltaY || 0;

        if (isMac) {
            if (event.wheelDeltaX && isDivisible(event.wheelDeltaX, 120)) {
                deltaX = -120 * (event.wheelDeltaX / Math.abs(event.wheelDeltaX));
            }
            if (event.wheelDeltaY && isDivisible(event.wheelDeltaY, 120)) {
                deltaY = -120 * (event.wheelDeltaY / Math.abs(event.wheelDeltaY));
            }
        }
        //console.log(deltaX);
        //console.log(deltaY);
        // use wheelDelta if deltaX/Y is not available
        if ((Math.floor(deltaY)===deltaY && deltaY>0 && deltaY<120) || (!deltaX && !deltaY)) {
            //KILL EFFECT IF IT IS A MAGIC MOUSE OR A TRACKPAD
            //console.log("KILL");
            cleanup();
            return true;
        }
        else { }

        // line based scrolling (Firefox mostly)
        if (event.deltaMode === 1) {
            deltaX *= 40;
            deltaY *= 40;
        }

        //THIS IS NEW
        if (!options.touchpadSupport && isTouchpad(deltaY)) {
            //console.log("KILL LOW");
            cleanup();
            return true;
        }

        // scale by step size
        // delta is 120 most of the time
        // synaptics seems to send 1 sometimes
        if (Math.abs(deltaX) > 1.2) {
            deltaX *= options.stepSize / 120;
        }
        if (Math.abs(deltaY) > 1.2) {
            deltaY *= options.stepSize / 120;
        }
        scrollArray(overflowing, deltaX, deltaY);
        event.preventDefault();
        scheduleClearCache();
    }

    /**
     * Keydown event handler.
     * @param {Object} event
     */
    function keydown(event) {

        var target   = event.target;
        var modifier = event.ctrlKey || event.altKey || event.metaKey ||
            (event.shiftKey && event.keyCode !== key.spacebar);

        // our own tracked active element could've been removed from the DOM
        if (!document.body.contains(activeElement)) {
            activeElement = document.activeElement;
        }

        // do nothing if user is editing text
        // or using a modifier key (except shift)
        // or in a dropdown
        // or inside interactive elements
        var inputNodeNames = /^(textarea|select|embed|object)$/i;
        var buttonTypes = /^(button|submit|radio|checkbox|file|color|image)$/i;
        if ( event.defaultPrevented ||
            inputNodeNames.test(target.nodeName) ||
            isNodeName(target, 'input') && !buttonTypes.test(target.type) ||
            isNodeName(activeElement, 'video') ||
            isInsideYoutubeVideo(event) ||
            target.isContentEditable ||
            modifier ) {
            return true;
        }

        // [spacebar] should trigger button press, leave it alone
        if ((isNodeName(target, 'button') ||
            isNodeName(target, 'input') && buttonTypes.test(target.type)) &&
            event.keyCode === key.spacebar) {
            return true;
        }

        // [arrwow keys] on radio buttons should be left alone
        if (isNodeName(target, 'input') && target.type == 'radio' &&
            arrowKeys[event.keyCode])  {
            return true;
        }

        var shift, x = 0, y = 0;
        var elem = overflowingAncestor(activeElement);
        var clientHeight = elem.clientHeight;

        if (elem == document.body) {
            clientHeight = window.innerHeight;
        }

        switch (event.keyCode) {
            case key.up:
                y = -options.arrowScroll;
                break;
            case key.down:
                y = options.arrowScroll;
                break;
            case key.spacebar:
                shift = event.shiftKey ? 1 : -1;
                y = -shift * clientHeight * 0.9;
                break;
            case key.pageup:
                y = -clientHeight * 0.9;
                break;
            case key.pagedown:
                y = clientHeight * 0.9;
                break;
            case key.home:
                y = -elem.scrollTop;
                break;
            case key.end:
                var damt = elem.scrollHeight - elem.scrollTop - clientHeight;
                y = (damt > 0) ? damt+10 : 0;
                break;
            case key.left:
                x = -options.arrowScroll;
                break;
            case key.right:
                x = options.arrowScroll;
                break;
            default:
                return true;
        }

        scrollArray(elem, x, y);
        event.preventDefault();
        scheduleClearCache();
    }

    /**
     * Mousedown event only for updating activeElement
     */
    function mousedown(event) {
        activeElement = event.target;
    }


    /***********************************************
     * OVERFLOW
     ***********************************************/

    var uniqueID = (function () {
        var i = 0;
        return function (el) {
            return el.uniqueID || (el.uniqueID = i++);
        };
    })();

    var cache = {};
    var clearCacheTimer;

    function scheduleClearCache() {
        clearTimeout(clearCacheTimer);
        clearCacheTimer = setInterval(function () { cache = {}; }, 1*1000);
    }

    function setCache(elems, overflowing) {
        for (var i = elems.length; i--;)
            cache[uniqueID(elems[i])] = overflowing;
        return overflowing;
    }

//  (body)                (root)
//         | hidden | visible | scroll |  auto  |
// hidden  |   no   |    no   |   YES  |   YES  |
// visible |   no   |   YES   |   YES  |   YES  |
// scroll  |   no   |   YES   |   YES  |   YES  |
// auto    |   no   |   YES   |   YES  |   YES  |

    function overflowingAncestor(el) {
        var elems = [];
        var body = document.body;
        var rootScrollHeight = root.scrollHeight;
        do {
            var cached = cache[uniqueID(el)];
            if (cached) {
                return setCache(elems, cached);
            }
            elems.push(el);
            if (rootScrollHeight === el.scrollHeight) {
                var topOverflowsNotHidden = overflowNotHidden(root) && overflowNotHidden(body);
                var isOverflowCSS = topOverflowsNotHidden || overflowAutoOrScroll(root);
                if (isFrame && isContentOverflowing(root) ||
                    !isFrame && isOverflowCSS) {
                    return setCache(elems, getScrollRoot());
                }
            } else if (isContentOverflowing(el) && overflowAutoOrScroll(el)) {
                return setCache(elems, el);
            }
        } while (el = el.parentElement);
    }

    function isContentOverflowing(el) {
        return (el.clientHeight + 10 < el.scrollHeight);
    }

    function overflowNotHidden(el) {
        var overflow = getComputedStyle(el, '').getPropertyValue('overflow-y');
        return (overflow !== 'hidden');
    }

// for all other elements
    function overflowAutoOrScroll(el) {
        var overflow = getComputedStyle(el, '').getPropertyValue('overflow-y');
        return (overflow === 'scroll' || overflow === 'auto');
    }


    /***********************************************
     * HELPERS
     ***********************************************/

    function addEvent(type, fn) {
        window.addEventListener(type, fn, false);
    }

    function removeEvent(type, fn) {
        window.removeEventListener(type, fn, false);
    }

    function isNodeName(el, tag) {
        return (el.nodeName||'').toLowerCase() === tag.toLowerCase();
    }

    function directionCheck(x, y) {
        x = (x > 0) ? 1 : -1;
        y = (y > 0) ? 1 : -1;
        if (direction.x !== x || direction.y !== y) {
            direction.x = x;
            direction.y = y;
            que = [];
            lastScroll = 0;
        }
    }

    var deltaBufferTimer;

    if (window.localStorage && localStorage.SS_deltaBuffer) {
        deltaBuffer = localStorage.SS_deltaBuffer.split(',');
    }

    function isTouchpad(deltaY) {
        if (!deltaY) return;
        if (!deltaBuffer.length) {
            deltaBuffer = [deltaY, deltaY, deltaY];
        }
        deltaY = Math.abs(deltaY);
        deltaBuffer.push(deltaY);
        deltaBuffer.shift();
        clearTimeout(deltaBufferTimer);
        deltaBufferTimer = setTimeout(function () {
            if (window.localStorage) {
                localStorage.SS_deltaBuffer = deltaBuffer.join(',');
            }
        }, 1000);
        return !allDeltasDivisableBy(120) && !allDeltasDivisableBy(100);
    }

    function isDivisible(n, divisor) {
        return (Math.floor(n / divisor) == n / divisor);
    }

    function allDeltasDivisableBy(divisor) {
        return (isDivisible(deltaBuffer[0], divisor) &&
            isDivisible(deltaBuffer[1], divisor) &&
            isDivisible(deltaBuffer[2], divisor));
    }

    function isInsideYoutubeVideo(event) {
        var elem = event.target;
        var isControl = false;
        if (document.URL.indexOf ('www.youtube.com/watch') != -1) {
            do {
                isControl = (elem.classList &&
                    elem.classList.contains('html5-video-controls'));
                if (isControl) break;
            } while (elem = elem.parentNode);
        }
        return isControl;
    }

    var requestFrame = (function () {
        return (window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame    ||
            function (callback, element, delay) {
                window.setTimeout(callback, delay || (1000/60));
            });
    })();

    var MutationObserver = (window.MutationObserver ||
        window.WebKitMutationObserver ||
        window.MozMutationObserver);

    var getScrollRoot = (function() {
        var SCROLL_ROOT;
        return function() {
            if (!SCROLL_ROOT) {
                var dummy = document.createElement('div');
                dummy.style.cssText = 'height:10000px;width:1px;';
                document.body.appendChild(dummy);
                var bodyScrollTop  = document.body.scrollTop;
                var docElScrollTop = document.documentElement.scrollTop;
                window.scrollBy(0, 3);
                if (document.body.scrollTop != bodyScrollTop)
                    (SCROLL_ROOT = document.body);
                else
                    (SCROLL_ROOT = document.documentElement);
                window.scrollBy(0, -3);
                document.body.removeChild(dummy);
            }
            return SCROLL_ROOT;
        };
    })();


    /***********************************************
     * PULSE (by Michael Herf)
     ***********************************************/

    function pulse_(x) {
        var val, start, expx;
        x = x * options.pulseScale;
        if (x < 1) { // acceleartion
            val = x - (1 - Math.exp(-x));
        } else {     // tail
            // the previous animation ended here:
            start = Math.exp(-1);
            // simple viscous drag
            x -= 1;
            expx = 1 - Math.exp(-x);
            val = start + (expx * (1 - start));
        }
        return val * options.pulseNormalize;
    }

    function pulse(x) {
        if (x >= 1) return 1;
        if (x <= 0) return 0;

        if (options.pulseNormalize == 1) {
            options.pulseNormalize /= pulse_(1);
        }
        return pulse_(x);
    }


    /***********************************************
     * FIRST RUN
     ***********************************************/

    var userAgent = window.navigator.userAgent;
    var isEdge    = /Edge/.test(userAgent);
    var isChrome  = /chrome/i.test(userAgent) && !isEdge;
    var isSafari  = /safari/i.test(userAgent) && !isEdge;
    var isMobile  = /mobile/i.test(userAgent);
    var isIEWin7  = /Windows NT 6.1/i.test(userAgent) && /rv:11/i.test(userAgent);
    var isEnabledForBrowser = (isChrome || isSafari || isIEWin7) && !isMobile;

    var wheelEvent;
    if ('onwheel' in document.createElement('div')) {
        wheelEvent = 'wheel';
    }
    else if ('onmousewheel' in document.createElement('div')) {
        wheelEvent = 'mousewheel';
    }

    if (wheelEvent && isEnabledForBrowser && theme_options.smooth_scroll==="1") {
        addEvent(wheelEvent, wheel);
        addEvent('mousedown', mousedown);
        addEvent('load', init);
    }


    /***********************************************
     * PUBLIC INTERFACE
     ***********************************************/

    function SmoothScroll(optionsToSet) {
        for (var key in optionsToSet)
            if (defaultOptions.hasOwnProperty(key))
                options[key] = optionsToSet[key];
    }
    SmoothScroll.destroy = cleanup;

    if (window.SmoothScrollOptions)
        SmoothScroll(window.SmoothScrollOptions);

    if (typeof define === 'function' && define.amd)
        define(function() {
            return SmoothScroll;
        });
    else if ('object' == typeof exports)
        module.exports = SmoothScroll;
    else
        window.SmoothScroll = SmoothScroll;

})();

/*
 * jQuery Superfish Menu Plugin - v1.7.9
 * Copyright (c) 2016 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 */

;(function ($, w) {
    "use strict";

    var methods = (function () {
        // private properties and methods go here
        var c = {
                bcClass: 'sf-breadcrumb',
                menuClass: 'sf-js-enabled',
                anchorClass: 'sf-with-ul',
                menuArrowClass: 'sf-arrows'
            },
            ios = (function () {
                var ios = /^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);
                if (ios) {
                    // tap anywhere on iOS to unfocus a submenu
                    $('html').css('cursor', 'pointer').on('click', $.noop);
                }
                return ios;
            })(),
            wp7 = (function () {
                var style = document.documentElement.style;
                return ('behavior' in style && 'fill' in style && /iemobile/i.test(navigator.userAgent));
            })(),
            unprefixedPointerEvents = (function () {
                return (!!w.PointerEvent);
            })(),
            toggleMenuClasses = function ($menu, o, add) {
                var classes = c.menuClass,
                    method;
                if (o.cssArrows) {
                    classes += ' ' + c.menuArrowClass;
                }
                method = (add) ? 'addClass' : 'removeClass';
                $menu[method](classes);
            },
            setPathToCurrent = function ($menu, o) {
                return $menu.find('li.' + o.pathClass).slice(0, o.pathLevels)
                    .addClass(o.hoverClass + ' ' + c.bcClass)
                    .filter(function () {
                        return ($(this).children(o.popUpSelector).hide().show().length);
                    }).removeClass(o.pathClass);
            },
            toggleAnchorClass = function ($li, add) {
                var method = (add) ? 'addClass' : 'removeClass';
                $li.children('a')[method](c.anchorClass);
            },
            toggleTouchAction = function ($menu) {
                var msTouchAction = $menu.css('ms-touch-action');
                var touchAction = $menu.css('touch-action');
                touchAction = touchAction || msTouchAction;
                touchAction = (touchAction === 'pan-y') ? 'auto' : 'pan-y';
                $menu.css({
                    'ms-touch-action': touchAction,
                    'touch-action': touchAction
                });
            },
            getMenu = function ($el) {
                return $el.closest('.' + c.menuClass);
            },
            getOptions = function ($el) {
                return getMenu($el).data('sfOptions');
            },
            over = function () {
                var $this = $(this),
                    o = getOptions($this);
                clearTimeout(o.sfTimer);
                $this.siblings().superfish('hide').end().superfish('show');
            },
            close = function (o) {
                o.retainPath = ($.inArray(this[0], o.$path) > -1);
                this.superfish('hide');

                if (!this.parents('.' + o.hoverClass).length) {
                    o.onIdle.call(getMenu(this));
                    if (o.$path.length) {
                        $.proxy(over, o.$path)();
                    }
                }
            },
            out = function () {
                var $this = $(this),
                    o = getOptions($this);
                if (ios) {
                    $.proxy(close, $this, o)();
                }
                else {
                    clearTimeout(o.sfTimer);
                    o.sfTimer = setTimeout($.proxy(close, $this, o), o.delay);
                }
            },
            touchHandler = function (e) {
                var $this = $(this),
                    o = getOptions($this),
                    $ul = $this.siblings(e.data.popUpSelector);

                if (o.onHandleTouch.call($ul) === false) {
                    return this;
                }

                if ($ul.length > 0 && $ul.is(':hidden')) {
                    $this.one('click.superfish', false);
                    if (e.type === 'MSPointerDown' || e.type === 'pointerdown') {
                        $this.trigger('focus');
                    } else {
                        $.proxy(over, $this.parent('li'))();
                    }
                }
            },
            applyHandlers = function ($menu, o) {
                var targets = 'li:has(' + o.popUpSelector + ')';
                if ($.fn.hoverIntent && !o.disableHI) {
                    $menu.hoverIntent(over, out, targets);
                }
                else {
                    $menu
                        .on('mouseenter.superfish', targets, over)
                        .on('mouseleave.superfish', targets, out);
                }
                var touchevent = 'MSPointerDown.superfish';
                if (unprefixedPointerEvents) {
                    touchevent = 'pointerdown.superfish';
                }
                if (!ios) {
                    touchevent += ' touchend.superfish';
                }
                if (wp7) {
                    touchevent += ' mousedown.superfish';
                }
                $menu
                    .on('focusin.superfish', 'li', over)
                    .on('focusout.superfish', 'li', out)
                    .on(touchevent, 'a', o, touchHandler);
            };

        return {
            // public methods
            hide: function (instant) {
                if (this.length) {
                    var $this = this,
                        o = getOptions($this);
                    if (!o) {
                        return this;
                    }
                    var not = (o.retainPath === true) ? o.$path : '',
                        $ul = $this.find('li.' + o.hoverClass).add(this).not(not).removeClass(o.hoverClass).children(o.popUpSelector),
                        speed = o.speedOut;

                    if (instant) {
                        $ul.show();
                        speed = 0;
                    }
                    o.retainPath = false;

                    if (o.onBeforeHide.call($ul) === false) {
                        return this;
                    }

                    $ul.stop(true, true).animate(o.animationOut, speed, function () {
                        var $this = $(this);
                        o.onHide.call($this);
                    });
                }
                return this;
            },
            show: function () {
                var o = getOptions(this);
                if (!o) {
                    return this;
                }
                var $this = this.addClass(o.hoverClass),
                    $ul = $this.children(o.popUpSelector);

                if (o.onBeforeShow.call($ul) === false) {
                    return this;
                }

                $ul.stop(true, true).animate(o.animation, o.speed, function () {
                    o.onShow.call($ul);
                });
                return this;
            },
            destroy: function () {
                return this.each(function () {
                    var $this = $(this),
                        o = $this.data('sfOptions'),
                        $hasPopUp;
                    if (!o) {
                        return false;
                    }
                    $hasPopUp = $this.find(o.popUpSelector).parent('li');
                    clearTimeout(o.sfTimer);
                    toggleMenuClasses($this, o);
                    toggleAnchorClass($hasPopUp);
                    toggleTouchAction($this);
                    // remove event handlers
                    $this.off('.superfish').off('.hoverIntent');
                    // clear animation's inline display style
                    $hasPopUp.children(o.popUpSelector).attr('style', function (i, style) {
                        return style.replace(/display[^;]+;?/g, '');
                    });
                    // reset 'current' path classes
                    o.$path.removeClass(o.hoverClass + ' ' + c.bcClass).addClass(o.pathClass);
                    $this.find('.' + o.hoverClass).removeClass(o.hoverClass);
                    o.onDestroy.call($this);
                    $this.removeData('sfOptions');
                });
            },
            init: function (op) {
                return this.each(function () {
                    var $this = $(this);
                    if ($this.data('sfOptions')) {
                        return false;
                    }
                    var o = $.extend({}, $.fn.superfish.defaults, op),
                        $hasPopUp = $this.find(o.popUpSelector).parent('li');
                    o.$path = setPathToCurrent($this, o);

                    $this.data('sfOptions', o);

                    toggleMenuClasses($this, o, true);
                    toggleAnchorClass($hasPopUp, true);
                    toggleTouchAction($this);
                    applyHandlers($this, o);

                    $hasPopUp.not('.' + c.bcClass).superfish('hide', true);

                    o.onInit.call(this);
                });
            }
        };
    })();

    $.fn.superfish = function (method, args) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === 'object' || ! method) {
            return methods.init.apply(this, arguments);
        }
        else {
            return $.error('Method ' +  method + ' does not exist on jQuery.fn.superfish');
        }
    };

    $.fn.superfish.defaults = {
        popUpSelector: 'ul,.sf-mega',
        hoverClass: 'sfHover',
        pathClass: 'overrideThisToUse',
        pathLevels: 1,
        delay: 800,
        animation: {opacity: 'show'},
        animationOut: {opacity: 'hide'},
        speed: 'normal',
        speedOut: 'fast',
        cssArrows: true,
        disableHI: false,
        onInit: $.noop,
        onBeforeShow: $.noop,
        onShow: $.noop,
        onBeforeHide: $.noop,
        onHide: $.noop,
        onIdle: $.noop,
        onDestroy: $.noop,
        onHandleTouch: $.noop
    };

})(jQuery, window);


/**
 * hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2013 Brian Cherne
 *
 **/
(function($) {
    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {

        // default configuration values
        var cfg = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };

        if ( typeof handlerIn === "object" ) {
            cfg = $.extend(cfg, handlerIn );
        } else if ($.isFunction(handlerOut)) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // instantiate variables
        // cX, cY = current X and Y position of mouse, updated by mousemove event
        // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
        var cX, cY, pX, pY;

        var track = function(ev) {
            cX = ev.pageX;
            cY = ev.pageY;
        };

        var compare = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            // compare mouse positions to see if they've crossed the threshold
            if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
                $(ob).off("mousemove.hoverIntent",track);
                // set hoverIntent state to true (so mouseOut can be called)
                ob.hoverIntent_s = 1;
                return cfg.over.apply(ob,[ev]);
            } else {
                // set previous coordinates for next time
                pX = cX; pY = cY;
                // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
                ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
            }
        };

        // A private function for delaying the mouseOut function
        var delay = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            ob.hoverIntent_s = 0;
            return cfg.out.apply(ob,[ev]);
        };

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // copy objects to be passed into t (required for event object to be passed in IE)
            var ev = jQuery.extend({},e);
            var ob = this;

            // cancel hoverIntent timer if it exists
            if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

            // if e.type == "mouseenter"
            if (e.type == "mouseenter") {
                // set "previous" X and Y position based on initial entry point
                pX = ev.pageX; pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $(ob).on("mousemove.hoverIntent",track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

            } else {
                // unbind expensive mousemove event
                $(ob).off("mousemove.hoverIntent",track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
})(jQuery);

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 *
 * Open source under the BSD License.
 *
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list
 * of conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 *
 * Neither the name of the author nor the names of contributors may be used to endorse
 * or promote products derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

jQuery.easing['jswing']=jQuery.easing['swing'];jQuery.extend(jQuery.easing,{def:'easeOutQuad',swing:function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x,t,b,c,d)},easeInQuad:function(x,t,b,c,d){return c*(t/=d)*t+b},easeOutQuad:function(x,t,b,c,d){return-c*(t/=d)*(t-2)+b},easeInOutQuad:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b},easeInCubic:function(x,t,b,c,d){return c*(t/=d)*t*t+b},easeOutCubic:function(x,t,b,c,d){return c*((t=t/d-1)*t*t+1)+b},easeInOutCubic:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b},easeInQuart:function(x,t,b,c,d){return c*(t/=d)*t*t*t+b},easeOutQuart:function(x,t,b,c,d){return-c*((t=t/d-1)*t*t*t-1)+b},easeInOutQuart:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t+b;return-c/2*((t-=2)*t*t*t-2)+b},easeInQuint:function(x,t,b,c,d){return c*(t/=d)*t*t*t*t+b},easeOutQuint:function(x,t,b,c,d){return c*((t=t/d-1)*t*t*t*t+1)+b},easeInOutQuint:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b},easeInSine:function(x,t,b,c,d){return-c*Math.cos(t/d*(Math.PI/2))+c+b},easeOutSine:function(x,t,b,c,d){return c*Math.sin(t/d*(Math.PI/2))+b},easeInOutSine:function(x,t,b,c,d){return-c/2*(Math.cos(Math.PI*t/d)-1)+b},easeInExpo:function(x,t,b,c,d){return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b},easeOutExpo:function(x,t,b,c,d){return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b},easeInOutExpo:function(x,t,b,c,d){if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b},easeInCirc:function(x,t,b,c,d){return-c*(Math.sqrt(1-(t/=d)*t)-1)+b},easeOutCirc:function(x,t,b,c,d){return c*Math.sqrt(1-(t=t/d-1)*t)+b},easeInOutCirc:function(x,t,b,c,d){if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b},easeInElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b},easeOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},easeInOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b},easeInBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b},easeOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},easeInOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b},easeInBounce:function(x,t,b,c,d){return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b},easeOutBounce:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b}},easeInOutBounce:function(x,t,b,c,d){if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b}});


/*!
Waypoints - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blob/master/licenses.txt
*/
(function() {
    'use strict'

    var keyCounter = 0
    var allWaypoints = {}

    function Waypoint(options) {
        if (!options) {
            throw new Error('No options passed to Waypoint constructor')
        }
        if (!options.element) {
            throw new Error('No element option passed to Waypoint constructor')
        }
        if (!options.handler) {
            throw new Error('No handler option passed to Waypoint constructor')
        }

        this.key = 'waypoint-' + keyCounter
        this.options = Waypoint.Adapter.extend({}, Waypoint.defaults, options)
        this.element = this.options.element
        this.adapter = new Waypoint.Adapter(this.element)
        this.callback = options.handler
        this.axis = this.options.horizontal ? 'horizontal' : 'vertical'
        this.enabled = this.options.enabled
        this.triggerPoint = null
        this.group = Waypoint.Group.findOrCreate({
            name: this.options.group,
            axis: this.axis
        })
        this.context = Waypoint.Context.findOrCreateByElement(this.options.context)

        if (Waypoint.offsetAliases[this.options.offset]) {
            this.options.offset = Waypoint.offsetAliases[this.options.offset]
        }
        this.group.add(this)
        this.context.add(this)
        allWaypoints[this.key] = this
        keyCounter += 1
    }

    /* Private */
    Waypoint.prototype.queueTrigger = function(direction) {
        this.group.queueTrigger(this, direction)
    }

    /* Private */
    Waypoint.prototype.trigger = function(args) {
        if (!this.enabled) {
            return
        }
        if (this.callback) {
            this.callback.apply(this, args)
        }
    }

    /* Public */
    Waypoint.prototype.destroy = function() {
        this.context.remove(this)
        this.group.remove(this)
        delete allWaypoints[this.key]
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/disable */
    Waypoint.prototype.disable = function() {
        this.enabled = false
        return this
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/enable */
    Waypoint.prototype.enable = function() {
        this.context.refresh()
        this.enabled = true
        return this
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/next */
    Waypoint.prototype.next = function() {
        return this.group.next(this)
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/previous */
    Waypoint.prototype.previous = function() {
        return this.group.previous(this)
    }

    /* Private */
    Waypoint.invokeAll = function(method) {
        var allWaypointsArray = []
        for (var waypointKey in allWaypoints) {
            allWaypointsArray.push(allWaypoints[waypointKey])
        }
        for (var i = 0, end = allWaypointsArray.length; i < end; i++) {
            allWaypointsArray[i][method]()
        }
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/destroy-all */
    Waypoint.destroyAll = function() {
        Waypoint.invokeAll('destroy')
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/disable-all */
    Waypoint.disableAll = function() {
        Waypoint.invokeAll('disable')
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/enable-all */
    Waypoint.enableAll = function() {
        Waypoint.invokeAll('enable')
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/refresh-all */
    Waypoint.refreshAll = function() {
        Waypoint.Context.refreshAll()
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/viewport-height */
    Waypoint.viewportHeight = function() {
        return window.innerHeight || document.documentElement.clientHeight
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/viewport-width */
    Waypoint.viewportWidth = function() {
        return document.documentElement.clientWidth
    }

    Waypoint.adapters = []

    Waypoint.defaults = {
        context: window,
        continuous: true,
        enabled: true,
        group: 'default',
        horizontal: false,
        offset: 0
    }

    Waypoint.offsetAliases = {
        'bottom-in-view': function() {
            return this.context.innerHeight() - this.adapter.outerHeight()
        },
        'right-in-view': function() {
            return this.context.innerWidth() - this.adapter.outerWidth()
        }
    }

    window.Waypoint = Waypoint
}())
;(function() {
    'use strict'

    function requestAnimationFrameShim(callback) {
        window.setTimeout(callback, 1000 / 60)
    }

    var keyCounter = 0
    var contexts = {}
    var Waypoint = window.Waypoint
    var oldWindowLoad = window.onload

    /* http://imakewebthings.com/waypoints/api/context */
    function Context(element) {
        this.element = element
        this.Adapter = Waypoint.Adapter
        this.adapter = new this.Adapter(element)
        this.key = 'waypoint-context-' + keyCounter
        this.didScroll = false
        this.didResize = false
        this.oldScroll = {
            x: this.adapter.scrollLeft(),
            y: this.adapter.scrollTop()
        }
        this.waypoints = {
            vertical: {},
            horizontal: {}
        }

        element.waypointContextKey = this.key
        contexts[element.waypointContextKey] = this
        keyCounter += 1

        this.createThrottledScrollHandler()
        this.createThrottledResizeHandler()
    }

    /* Private */
    Context.prototype.add = function(waypoint) {
        var axis = waypoint.options.horizontal ? 'horizontal' : 'vertical'
        this.waypoints[axis][waypoint.key] = waypoint
        this.refresh()
    }

    /* Private */
    Context.prototype.checkEmpty = function() {
        var horizontalEmpty = this.Adapter.isEmptyObject(this.waypoints.horizontal)
        var verticalEmpty = this.Adapter.isEmptyObject(this.waypoints.vertical)
        if (horizontalEmpty && verticalEmpty) {
            this.adapter.off('.waypoints')
            delete contexts[this.key]
        }
    }

    /* Private */
    Context.prototype.createThrottledResizeHandler = function() {
        var self = this

        function resizeHandler() {
            self.handleResize()
            self.didResize = false
        }

        this.adapter.on('resize.waypoints', function() {
            if (!self.didResize) {
                self.didResize = true
                Waypoint.requestAnimationFrame(resizeHandler)
            }
        })
    }

    /* Private */
    Context.prototype.createThrottledScrollHandler = function() {
        var self = this
        function scrollHandler() {
            self.handleScroll()
            self.didScroll = false
        }

        this.adapter.on('scroll.waypoints', function() {
            if (!self.didScroll || Waypoint.isTouch) {
                self.didScroll = true
                Waypoint.requestAnimationFrame(scrollHandler)
            }
        })
    }

    /* Private */
    Context.prototype.handleResize = function() {
        Waypoint.Context.refreshAll()
    }

    /* Private */
    Context.prototype.handleScroll = function() {
        var triggeredGroups = {}
        var axes = {
            horizontal: {
                newScroll: this.adapter.scrollLeft(),
                oldScroll: this.oldScroll.x,
                forward: 'right',
                backward: 'left'
            },
            vertical: {
                newScroll: this.adapter.scrollTop(),
                oldScroll: this.oldScroll.y,
                forward: 'down',
                backward: 'up'
            }
        }

        for (var axisKey in axes) {
            var axis = axes[axisKey]
            var isForward = axis.newScroll > axis.oldScroll
            var direction = isForward ? axis.forward : axis.backward

            for (var waypointKey in this.waypoints[axisKey]) {
                var waypoint = this.waypoints[axisKey][waypointKey]
                var wasBeforeTriggerPoint = axis.oldScroll < waypoint.triggerPoint
                var nowAfterTriggerPoint = axis.newScroll >= waypoint.triggerPoint
                var crossedForward = wasBeforeTriggerPoint && nowAfterTriggerPoint
                var crossedBackward = !wasBeforeTriggerPoint && !nowAfterTriggerPoint
                if (crossedForward || crossedBackward) {
                    waypoint.queueTrigger(direction)
                    triggeredGroups[waypoint.group.id] = waypoint.group
                }
            }
        }

        for (var groupKey in triggeredGroups) {
            triggeredGroups[groupKey].flushTriggers()
        }

        this.oldScroll = {
            x: axes.horizontal.newScroll,
            y: axes.vertical.newScroll
        }
    }

    /* Private */
    Context.prototype.innerHeight = function() {
        if (this.element == this.element.window) {
            return Waypoint.viewportHeight()
        }
        return this.adapter.innerHeight()
    }

    /* Private */
    Context.prototype.remove = function(waypoint) {
        delete this.waypoints[waypoint.axis][waypoint.key]
        this.checkEmpty()
    }

    /* Private */
    Context.prototype.innerWidth = function() {
        if (this.element == this.element.window) {
            return Waypoint.viewportWidth()
        }
        return this.adapter.innerWidth()
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/context-destroy */
    Context.prototype.destroy = function() {
        var allWaypoints = []
        for (var axis in this.waypoints) {
            for (var waypointKey in this.waypoints[axis]) {
                allWaypoints.push(this.waypoints[axis][waypointKey])
            }
        }
        for (var i = 0, end = allWaypoints.length; i < end; i++) {
            allWaypoints[i].destroy()
        }
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/context-refresh */
    Context.prototype.refresh = function() {
        var isWindow = this.element == this.element.window
        var contextOffset = isWindow ? undefined : this.adapter.offset()
        var triggeredGroups = {}
        var axes

        this.handleScroll()
        axes = {
            horizontal: {
                contextOffset: isWindow ? 0 : contextOffset.left,
                contextScroll: isWindow ? 0 : this.oldScroll.x,
                contextDimension: this.innerWidth(),
                oldScroll: this.oldScroll.x,
                forward: 'right',
                backward: 'left',
                offsetProp: 'left'
            },
            vertical: {
                contextOffset: isWindow ? 0 : contextOffset.top,
                contextScroll: isWindow ? 0 : this.oldScroll.y,
                contextDimension: this.innerHeight(),
                oldScroll: this.oldScroll.y,
                forward: 'down',
                backward: 'up',
                offsetProp: 'top'
            }
        }

        for (var axisKey in axes) {
            var axis = axes[axisKey]
            for (var waypointKey in this.waypoints[axisKey]) {
                var waypoint = this.waypoints[axisKey][waypointKey]
                var adjustment = waypoint.options.offset
                var oldTriggerPoint = waypoint.triggerPoint
                var elementOffset = 0
                var freshWaypoint = oldTriggerPoint == null
                var contextModifier, wasBeforeScroll, nowAfterScroll
                var triggeredBackward, triggeredForward

                if (waypoint.element !== waypoint.element.window) {
                    elementOffset = waypoint.adapter.offset()[axis.offsetProp]
                }

                if (typeof adjustment === 'function') {
                    adjustment = adjustment.apply(waypoint)
                }
                else if (typeof adjustment === 'string') {
                    adjustment = parseFloat(adjustment)
                    if (waypoint.options.offset.indexOf('%') > - 1) {
                        adjustment = Math.ceil(axis.contextDimension * adjustment / 100)
                    }
                }

                contextModifier = axis.contextScroll - axis.contextOffset
                waypoint.triggerPoint = elementOffset + contextModifier - adjustment
                wasBeforeScroll = oldTriggerPoint < axis.oldScroll
                nowAfterScroll = waypoint.triggerPoint >= axis.oldScroll
                triggeredBackward = wasBeforeScroll && nowAfterScroll
                triggeredForward = !wasBeforeScroll && !nowAfterScroll

                if (!freshWaypoint && triggeredBackward) {
                    waypoint.queueTrigger(axis.backward)
                    triggeredGroups[waypoint.group.id] = waypoint.group
                }
                else if (!freshWaypoint && triggeredForward) {
                    waypoint.queueTrigger(axis.forward)
                    triggeredGroups[waypoint.group.id] = waypoint.group
                }
                else if (freshWaypoint && axis.oldScroll >= waypoint.triggerPoint) {
                    waypoint.queueTrigger(axis.forward)
                    triggeredGroups[waypoint.group.id] = waypoint.group
                }
            }
        }

        Waypoint.requestAnimationFrame(function() {
            for (var groupKey in triggeredGroups) {
                triggeredGroups[groupKey].flushTriggers()
            }
        })

        return this
    }

    /* Private */
    Context.findOrCreateByElement = function(element) {
        return Context.findByElement(element) || new Context(element)
    }

    /* Private */
    Context.refreshAll = function() {
        for (var contextId in contexts) {
            contexts[contextId].refresh()
        }
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/context-find-by-element */
    Context.findByElement = function(element) {
        return contexts[element.waypointContextKey]
    }

    window.onload = function() {
        if (oldWindowLoad) {
            oldWindowLoad()
        }
        Context.refreshAll()
    }

    Waypoint.requestAnimationFrame = function(callback) {
        var requestFn = window.requestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            requestAnimationFrameShim
        requestFn.call(window, callback)
    }
    Waypoint.Context = Context
}())
;(function() {
    'use strict'

    function byTriggerPoint(a, b) {
        return a.triggerPoint - b.triggerPoint
    }

    function byReverseTriggerPoint(a, b) {
        return b.triggerPoint - a.triggerPoint
    }

    var groups = {
        vertical: {},
        horizontal: {}
    }
    var Waypoint = window.Waypoint

    /* http://imakewebthings.com/waypoints/api/group */
    function Group(options) {
        this.name = options.name
        this.axis = options.axis
        this.id = this.name + '-' + this.axis
        this.waypoints = []
        this.clearTriggerQueues()
        groups[this.axis][this.name] = this
    }

    /* Private */
    Group.prototype.add = function(waypoint) {
        this.waypoints.push(waypoint)
    }

    /* Private */
    Group.prototype.clearTriggerQueues = function() {
        this.triggerQueues = {
            up: [],
            down: [],
            left: [],
            right: []
        }
    }

    /* Private */
    Group.prototype.flushTriggers = function() {
        for (var direction in this.triggerQueues) {
            var waypoints = this.triggerQueues[direction]
            var reverse = direction === 'up' || direction === 'left'
            waypoints.sort(reverse ? byReverseTriggerPoint : byTriggerPoint)
            for (var i = 0, end = waypoints.length; i < end; i += 1) {
                var waypoint = waypoints[i]
                if (waypoint.options.continuous || i === waypoints.length - 1) {
                    waypoint.trigger([direction])
                }
            }
        }
        this.clearTriggerQueues()
    }

    /* Private */
    Group.prototype.next = function(waypoint) {
        this.waypoints.sort(byTriggerPoint)
        var index = Waypoint.Adapter.inArray(waypoint, this.waypoints)
        var isLast = index === this.waypoints.length - 1
        return isLast ? null : this.waypoints[index + 1]
    }

    /* Private */
    Group.prototype.previous = function(waypoint) {
        this.waypoints.sort(byTriggerPoint)
        var index = Waypoint.Adapter.inArray(waypoint, this.waypoints)
        return index ? this.waypoints[index - 1] : null
    }

    /* Private */
    Group.prototype.queueTrigger = function(waypoint, direction) {
        this.triggerQueues[direction].push(waypoint)
    }

    /* Private */
    Group.prototype.remove = function(waypoint) {
        var index = Waypoint.Adapter.inArray(waypoint, this.waypoints)
        if (index > -1) {
            this.waypoints.splice(index, 1)
        }
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/first */
    Group.prototype.first = function() {
        return this.waypoints[0]
    }

    /* Public */
    /* http://imakewebthings.com/waypoints/api/last */
    Group.prototype.last = function() {
        return this.waypoints[this.waypoints.length - 1]
    }

    /* Private */
    Group.findOrCreate = function(options) {
        return groups[options.axis][options.name] || new Group(options)
    }

    Waypoint.Group = Group
}())
;(function() {
    'use strict'

    var $ = window.jQuery
    var Waypoint = window.Waypoint

    function JQueryAdapter(element) {
        this.$element = $(element)
    }

    $.each([
        'innerHeight',
        'innerWidth',
        'off',
        'offset',
        'on',
        'outerHeight',
        'outerWidth',
        'scrollLeft',
        'scrollTop'
    ], function(i, method) {
        JQueryAdapter.prototype[method] = function() {
            var args = Array.prototype.slice.call(arguments)
            return this.$element[method].apply(this.$element, args)
        }
    })

    $.each([
        'extend',
        'inArray',
        'isEmptyObject'
    ], function(i, method) {
        JQueryAdapter[method] = $[method]
    })

    Waypoint.adapters.push({
        name: 'jquery',
        Adapter: JQueryAdapter
    })
    Waypoint.Adapter = JQueryAdapter
}())
;(function() {
    'use strict'

    var Waypoint = window.Waypoint

    function createExtension(framework) {
        return function() {
            var waypoints = []
            var overrides = arguments[0]

            if (framework.isFunction(arguments[0])) {
                overrides = framework.extend({}, arguments[1])
                overrides.handler = arguments[0]
            }

            this.each(function() {
                var options = framework.extend({}, overrides, {
                    element: this
                })
                if (typeof options.context === 'string') {
                    options.context = framework(this).closest(options.context)[0]
                }
                waypoints.push(new Waypoint(options))
            })

            return waypoints
        }
    }

    if (window.jQuery) {
        window.jQuery.fn.waypoint = createExtension(window.jQuery)
    }
    if (window.Zepto) {
        window.Zepto.fn.waypoint = createExtension(window.Zepto)
    }
}())
;


/*! skrollr 0.6.29 (2014-11-17) | Alexander Prinzhorn - https://github.com/Prinzhorn/skrollr | Free to use under terms of MIT license */
(function(e,t,r){"use strict";function n(r){if(o=t.documentElement,a=t.body,Y(),lt=this,r=r||{},mt=r.constants||{},r.easing)for(var n in r.easing)X[n]=r.easing[n];Tt=r.edgeStrategy||"set",ft={beforerender:r.beforerender,render:r.render,keyframe:r.keyframe},ut=r.forceHeight!==!1,ut&&(zt=r.scale||1),pt=r.mobileDeceleration||x,gt=r.smoothScrolling!==!1,vt=r.smoothScrollingDuration||A,ht={targetTop:lt.getScrollTop()},Kt=(r.mobileCheck||function(){return/Android|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent||navigator.vendor||e.opera)})(),Kt?(ct=t.getElementById(r.skrollrBody||E),ct&&it(),j(),Dt(o,[y,S],[T])):Dt(o,[y,b],[T]),lt.refresh(),kt(e,"resize orientationchange",function(){var e=o.clientWidth,t=o.clientHeight;(t!==Bt||e!==$t)&&(Bt=t,$t=e,_t=!0)});var i=R();return function l(){J(),St=i(l)}(),lt}var o,a,i={get:function(){return lt},init:function(e){return lt||new n(e)},VERSION:"0.6.29"},l=Object.prototype.hasOwnProperty,s=e.Math,c=e.getComputedStyle,f="touchstart",u="touchmove",m="touchcancel",p="touchend",d="skrollable",g=d+"-before",v=d+"-between",h=d+"-after",y="skrollr",T="no-"+y,b=y+"-desktop",S=y+"-mobile",k="linear",w=1e3,x=.004,E="skrollr-body",A=200,F="start",C="end",H="center",D="bottom",I="___skrollable_id",P=/^(?:input|textarea|button|select)$/i,N=/^\s+|\s+$/g,O=/^data(?:-(_\w+))?(?:-?(-?\d*\.?\d+p?))?(?:-?(start|end|top|center|bottom))?(?:-?(top|center|bottom))?$/,V=/\s*(@?[\w\-\[\]]+)\s*:\s*(.+?)\s*(?:;|$)/gi,z=/^(@?[a-z\-]+)\[(\w+)\]$/,q=/-([a-z0-9_])/g,L=function(e,t){return t.toUpperCase()},M=/[\-+]?[\d]*\.?[\d]+/g,$=/\{\?\}/g,B=/rgba?\(\s*-?\d+\s*,\s*-?\d+\s*,\s*-?\d+/g,_=/[a-z\-]+-gradient/g,G="",K="",Y=function(){var e=/^(?:O|Moz|webkit|ms)|(?:-(?:o|moz|webkit|ms)-)/;if(c){var t=c(a,null);for(var n in t)if(G=n.match(e)||+n==n&&t[n].match(e))break;if(!G)return G=K="",r;G=G[0],"-"===G.slice(0,1)?(K=G,G={"-webkit-":"webkit","-moz-":"Moz","-ms-":"ms","-o-":"O"}[G]):K="-"+G.toLowerCase()+"-"}},R=function(){var t=e.requestAnimationFrame||e[G.toLowerCase()+"RequestAnimationFrame"],r=Nt();return(Kt||!t)&&(t=function(t){var n=Nt()-r,o=s.max(0,1e3/60-n);return e.setTimeout(function(){r=Nt(),t()},o)}),t},U=function(){var t=e.cancelAnimationFrame||e[G.toLowerCase()+"CancelAnimationFrame"];return(Kt||!t)&&(t=function(t){return e.clearTimeout(t)}),t},X={begin:function(){return 0},end:function(){return 1},linear:function(e){return e},quadratic:function(e){return e*e},cubic:function(e){return e*e*e},swing:function(e){return-s.cos(e*s.PI)/2+.5},sqrt:function(e){return s.sqrt(e)},outCubic:function(e){return s.pow(e-1,3)+1},bounce:function(e){var t;if(.5083>=e)t=3;else if(.8489>=e)t=9;else if(.96208>=e)t=27;else{if(!(.99981>=e))return 1;t=91}return 1-s.abs(3*s.cos(1.028*e*t)/t)}};n.prototype.refresh=function(e){var n,o,a=!1;for(e===r?(a=!0,st=[],Gt=0,e=t.getElementsByTagName("*")):e.length===r&&(e=[e]),n=0,o=e.length;o>n;n++){var i=e[n],l=i,s=[],c=gt,f=Tt,u=!1;if(a&&I in i&&delete i[I],i.attributes){for(var m=0,p=i.attributes.length;p>m;m++){var g=i.attributes[m];if("data-anchor-target"!==g.name)if("data-smooth-scrolling"!==g.name)if("data-edge-strategy"!==g.name)if("data-emit-events"!==g.name){var v=g.name.match(O);if(null!==v){var h={props:g.value,element:i,eventType:g.name.replace(q,L)};s.push(h);var y=v[1];y&&(h.constant=y.substr(1));var T=v[2];/p$/.test(T)?(h.isPercentage=!0,h.offset=(0|T.slice(0,-1))/100):h.offset=0|T;var b=v[3],S=v[4]||b;b&&b!==F&&b!==C?(h.mode="relative",h.anchors=[b,S]):(h.mode="absolute",b===C?h.isEnd=!0:h.isPercentage||(h.offset=h.offset*zt))}}else u=!0;else f=g.value;else c="off"!==g.value;else if(l=t.querySelector(g.value),null===l)throw'Unable to find anchor target "'+g.value+'"'}if(s.length){var k,w,x;!a&&I in i?(x=i[I],k=st[x].styleAttr,w=st[x].classAttr):(x=i[I]=Gt++,k=i.style.cssText,w=Ht(i)),st[x]={element:i,styleAttr:k,classAttr:w,anchorTarget:l,keyFrames:s,smoothScrolling:c,edgeStrategy:f,emitEvents:u,lastFrameIndex:-1},Dt(i,[d],[])}}}for(At(),n=0,o=e.length;o>n;n++){var E=st[e[n][I]];E!==r&&(Q(E),tt(E))}return lt},n.prototype.relativeToAbsolute=function(e,t,r){var n=o.clientHeight,a=e.getBoundingClientRect(),i=a.top,l=a.bottom-a.top;return t===D?i-=n:t===H&&(i-=n/2),r===D?i+=l:r===H&&(i+=l/2),i+=lt.getScrollTop(),0|i+.5},n.prototype.animateTo=function(e,t){t=t||{};var n=Nt(),o=lt.getScrollTop();return dt={startTop:o,topDiff:e-o,targetTop:e,duration:t.duration||w,startTime:n,endTime:n+(t.duration||w),easing:X[t.easing||k],done:t.done},dt.topDiff||(dt.done&&dt.done.call(lt,!1),dt=r),lt},n.prototype.stopAnimateTo=function(){dt&&dt.done&&dt.done.call(lt,!0),dt=r},n.prototype.isAnimatingTo=function(){return!!dt},n.prototype.isMobile=function(){return Kt},n.prototype.setScrollTop=function(t,r){return yt=r===!0,Kt?Yt=s.min(s.max(t,0),Vt):e.scrollTo(0,t),lt},n.prototype.getScrollTop=function(){return Kt?Yt:e.pageYOffset||o.scrollTop||a.scrollTop||0},n.prototype.getMaxScrollTop=function(){return Vt},n.prototype.on=function(e,t){return ft[e]=t,lt},n.prototype.off=function(e){return delete ft[e],lt},n.prototype.destroy=function(){var e=U();e(St),xt(),Dt(o,[T],[y,b,S]);for(var t=0,n=st.length;n>t;t++)at(st[t].element);o.style.overflow=a.style.overflow="",o.style.height=a.style.height="",ct&&i.setStyle(ct,"transform","none"),lt=r,ct=r,ft=r,ut=r,Vt=0,zt=1,mt=r,pt=r,qt="down",Lt=-1,$t=0,Bt=0,_t=!1,dt=r,gt=r,vt=r,ht=r,yt=r,Gt=0,Tt=r,Kt=!1,Yt=0,bt=r};var j=function(){var n,i,l,c,d,g,v,h,y,T,b,S;kt(o,[f,u,m,p].join(" "),function(e){var o=e.changedTouches[0];for(c=e.target;3===c.nodeType;)c=c.parentNode;switch(d=o.clientY,g=o.clientX,T=e.timeStamp,P.test(c.tagName)||e.preventDefault(),e.type){case f:n&&n.blur(),lt.stopAnimateTo(),n=c,i=v=d,l=g,y=T;break;case u:P.test(c.tagName)&&t.activeElement!==c&&e.preventDefault(),h=d-v,S=T-b,lt.setScrollTop(Yt-h,!0),v=d,b=T;break;default:case m:case p:var a=i-d,k=l-g,w=k*k+a*a;if(49>w){if(!P.test(n.tagName)){n.focus();var x=t.createEvent("MouseEvents");x.initMouseEvent("click",!0,!0,e.view,1,o.screenX,o.screenY,o.clientX,o.clientY,e.ctrlKey,e.altKey,e.shiftKey,e.metaKey,0,null),n.dispatchEvent(x)}return}n=r;var E=h/S;E=s.max(s.min(E,3),-3);var A=s.abs(E/pt),F=E*A+.5*pt*A*A,C=lt.getScrollTop()-F,H=0;C>Vt?(H=(Vt-C)/F,C=Vt):0>C&&(H=-C/F,C=0),A*=1-H,lt.animateTo(0|C+.5,{easing:"outCubic",duration:A})}}),e.scrollTo(0,0),o.style.overflow=a.style.overflow="hidden"},W=function(){var e,t,r,n,a,i,l,c,f,u,m,p=o.clientHeight,d=Ft();for(c=0,f=st.length;f>c;c++)for(e=st[c],t=e.element,r=e.anchorTarget,n=e.keyFrames,a=0,i=n.length;i>a;a++)l=n[a],u=l.offset,m=d[l.constant]||0,l.frame=u,l.isPercentage&&(u*=p,l.frame=u),"relative"===l.mode&&(at(t),l.frame=lt.relativeToAbsolute(r,l.anchors[0],l.anchors[1])-u,at(t,!0)),l.frame+=m,ut&&!l.isEnd&&l.frame>Vt&&(Vt=l.frame);for(Vt=s.max(Vt,Ct()),c=0,f=st.length;f>c;c++){for(e=st[c],n=e.keyFrames,a=0,i=n.length;i>a;a++)l=n[a],m=d[l.constant]||0,l.isEnd&&(l.frame=Vt-l.offset+m);e.keyFrames.sort(Ot)}},Z=function(e,t){for(var r=0,n=st.length;n>r;r++){var o,a,s=st[r],c=s.element,f=s.smoothScrolling?e:t,u=s.keyFrames,m=u.length,p=u[0],y=u[u.length-1],T=p.frame>f,b=f>y.frame,S=T?p:y,k=s.emitEvents,w=s.lastFrameIndex;if(T||b){if(T&&-1===s.edge||b&&1===s.edge)continue;switch(T?(Dt(c,[g],[h,v]),k&&w>-1&&(Et(c,p.eventType,qt),s.lastFrameIndex=-1)):(Dt(c,[h],[g,v]),k&&m>w&&(Et(c,y.eventType,qt),s.lastFrameIndex=m)),s.edge=T?-1:1,s.edgeStrategy){case"reset":at(c);continue;case"ease":f=S.frame;break;default:case"set":var x=S.props;for(o in x)l.call(x,o)&&(a=ot(x[o].value),0===o.indexOf("@")?c.setAttribute(o.substr(1),a):i.setStyle(c,o,a));continue}}else 0!==s.edge&&(Dt(c,[d,v],[g,h]),s.edge=0);for(var E=0;m-1>E;E++)if(f>=u[E].frame&&u[E+1].frame>=f){var A=u[E],F=u[E+1];for(o in A.props)if(l.call(A.props,o)){var C=(f-A.frame)/(F.frame-A.frame);C=A.props[o].easing(C),a=nt(A.props[o].value,F.props[o].value,C),a=ot(a),0===o.indexOf("@")?c.setAttribute(o.substr(1),a):i.setStyle(c,o,a)}k&&w!==E&&("down"===qt?Et(c,A.eventType,qt):Et(c,F.eventType,qt),s.lastFrameIndex=E);break}}},J=function(){_t&&(_t=!1,At());var e,t,n=lt.getScrollTop(),o=Nt();if(dt)o>=dt.endTime?(n=dt.targetTop,e=dt.done,dt=r):(t=dt.easing((o-dt.startTime)/dt.duration),n=0|dt.startTop+t*dt.topDiff),lt.setScrollTop(n,!0);else if(!yt){var a=ht.targetTop-n;a&&(ht={startTop:Lt,topDiff:n-Lt,targetTop:n,startTime:Mt,endTime:Mt+vt}),ht.endTime>=o&&(t=X.sqrt((o-ht.startTime)/vt),n=0|ht.startTop+t*ht.topDiff)}if(Kt&&ct&&i.setStyle(ct,"transform","translate(0, "+-Yt+"px) "+bt),yt||Lt!==n){qt=n>Lt?"down":Lt>n?"up":qt,yt=!1;var l={curTop:n,lastTop:Lt,maxTop:Vt,direction:qt},s=ft.beforerender&&ft.beforerender.call(lt,l);s!==!1&&(Z(n,lt.getScrollTop()),Lt=n,ft.render&&ft.render.call(lt,l)),e&&e.call(lt,!1)}Mt=o},Q=function(e){for(var t=0,r=e.keyFrames.length;r>t;t++){for(var n,o,a,i,l=e.keyFrames[t],s={};null!==(i=V.exec(l.props));)a=i[1],o=i[2],n=a.match(z),null!==n?(a=n[1],n=n[2]):n=k,o=o.indexOf("!")?et(o):[o.slice(1)],s[a]={value:o,easing:X[n]};l.props=s}},et=function(e){var t=[];return B.lastIndex=0,e=e.replace(B,function(e){return e.replace(M,function(e){return 100*(e/255)+"%"})}),K&&(_.lastIndex=0,e=e.replace(_,function(e){return K+e})),e=e.replace(M,function(e){return t.push(+e),"{?}"}),t.unshift(e),t},tt=function(e){var t,r,n={};for(t=0,r=e.keyFrames.length;r>t;t++)rt(e.keyFrames[t],n);for(n={},t=e.keyFrames.length-1;t>=0;t--)rt(e.keyFrames[t],n)},rt=function(e,t){var r;for(r in t)l.call(e.props,r)||(e.props[r]=t[r]);for(r in e.props)t[r]=e.props[r]},nt=function(e,t,r){var n,o=e.length;if(o!==t.length)throw"Can't interpolate between \""+e[0]+'" and "'+t[0]+'"';var a=[e[0]];for(n=1;o>n;n++)a[n]=e[n]+(t[n]-e[n])*r;return a},ot=function(e){var t=1;return $.lastIndex=0,e[0].replace($,function(){return e[t++]})},at=function(e,t){e=[].concat(e);for(var r,n,o=0,a=e.length;a>o;o++)n=e[o],r=st[n[I]],r&&(t?(n.style.cssText=r.dirtyStyleAttr,Dt(n,r.dirtyClassAttr)):(r.dirtyStyleAttr=n.style.cssText,r.dirtyClassAttr=Ht(n),n.style.cssText=r.styleAttr,Dt(n,r.classAttr)))},it=function(){bt="translateZ(0)",i.setStyle(ct,"transform",bt);var e=c(ct),t=e.getPropertyValue("transform"),r=e.getPropertyValue(K+"transform"),n=t&&"none"!==t||r&&"none"!==r;n||(bt="")};i.setStyle=function(e,t,r){var n=e.style;if(t=t.replace(q,L).replace("-",""),"zIndex"===t)n[t]=isNaN(r)?r:""+(0|r);else if("float"===t)n.styleFloat=n.cssFloat=r;else try{G&&(n[G+t.slice(0,1).toUpperCase()+t.slice(1)]=r),n[t]=r}catch(o){}};var lt,st,ct,ft,ut,mt,pt,dt,gt,vt,ht,yt,Tt,bt,St,kt=i.addEvent=function(t,r,n){var o=function(t){return t=t||e.event,t.target||(t.target=t.srcElement),t.preventDefault||(t.preventDefault=function(){t.returnValue=!1,t.defaultPrevented=!0}),n.call(this,t)};r=r.split(" ");for(var a,i=0,l=r.length;l>i;i++)a=r[i],t.addEventListener?t.addEventListener(a,n,!1):t.attachEvent("on"+a,o),Rt.push({element:t,name:a,listener:n})},wt=i.removeEvent=function(e,t,r){t=t.split(" ");for(var n=0,o=t.length;o>n;n++)e.removeEventListener?e.removeEventListener(t[n],r,!1):e.detachEvent("on"+t[n],r)},xt=function(){for(var e,t=0,r=Rt.length;r>t;t++)e=Rt[t],wt(e.element,e.name,e.listener);Rt=[]},Et=function(e,t,r){ft.keyframe&&ft.keyframe.call(lt,e,t,r)},At=function(){var e=lt.getScrollTop();Vt=0,ut&&!Kt&&(a.style.height=""),W(),ut&&!Kt&&(a.style.height=Vt+o.clientHeight+"px"),Kt?lt.setScrollTop(s.min(lt.getScrollTop(),Vt)):lt.setScrollTop(e,!0),yt=!0},Ft=function(){var e,t,r=o.clientHeight,n={};for(e in mt)t=mt[e],"function"==typeof t?t=t.call(lt):/p$/.test(t)&&(t=t.slice(0,-1)/100*r),n[e]=t;return n},Ct=function(){var e,t=0;return ct&&(t=s.max(ct.offsetHeight,ct.scrollHeight)),e=s.max(t,a.scrollHeight,a.offsetHeight,o.scrollHeight,o.offsetHeight,o.clientHeight),e-o.clientHeight},Ht=function(t){var r="className";return e.SVGElement&&t instanceof e.SVGElement&&(t=t[r],r="baseVal"),t[r]},Dt=function(t,n,o){var a="className";if(e.SVGElement&&t instanceof e.SVGElement&&(t=t[a],a="baseVal"),o===r)return t[a]=n,r;for(var i=t[a],l=0,s=o.length;s>l;l++)i=Pt(i).replace(Pt(o[l])," ");i=It(i);for(var c=0,f=n.length;f>c;c++)-1===Pt(i).indexOf(Pt(n[c]))&&(i+=" "+n[c]);t[a]=It(i)},It=function(e){return e.replace(N,"")},Pt=function(e){return" "+e+" "},Nt=Date.now||function(){return+new Date},Ot=function(e,t){return e.frame-t.frame},Vt=0,zt=1,qt="down",Lt=-1,Mt=Nt(),$t=0,Bt=0,_t=!1,Gt=0,Kt=!1,Yt=0,Rt=[];"function"==typeof define&&define.amd?define([],function(){return i}):"undefined"!=typeof module&&module.exports?module.exports=i:e.skrollr=i})(window,document);

/*CUSTOM SCROLLBAR */

/*! Copyright (c) 2013 Brandon Aaron (http://brandon.aaron.sh)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 3.1.12
 *
 * Requires: jQuery 1.2.2+
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});


(function(c){var b={init:function(e){var f={set_width:false,set_height:false,horizontalScroll:false,scrollInertia:950,mouseWheel:true,mouseWheelPixels:"auto",autoDraggerLength:true,autoHideScrollbar:false,snapAmount:null,snapOffset:0,scrollButtons:{enable:false,scrollType:"continuous",scrollSpeed:"auto",scrollAmount:40},advanced:{updateOnBrowserResize:true,updateOnContentResize:false,autoExpandHorizontalScroll:false,autoScrollOnFocus:true,normalizeMouseWheelDelta:false},contentTouchScroll:true,callbacks:{onScrollStart:function(){},onScroll:function(){},onTotalScroll:function(){},onTotalScrollBack:function(){},onTotalScrollOffset:0,onTotalScrollBackOffset:0,whileScrolling:function(){}},theme:"light"},e=c.extend(true,f,e);return this.each(function(){var m=c(this);if(e.set_width){m.css("width",e.set_width)}if(e.set_height){m.css("height",e.set_height)}if(!c(document).data("mCustomScrollbar-index")){c(document).data("mCustomScrollbar-index","1")}else{var t=parseInt(c(document).data("mCustomScrollbar-index"));c(document).data("mCustomScrollbar-index",t+1)}m.wrapInner("<div class='mCustomScrollBox mCS-"+e.theme+"' id='mCSB_"+c(document).data("mCustomScrollbar-index")+"' style='position:relative; height:100%; overflow:hidden; max-width:100%;' />").addClass("mCustomScrollbar _mCS_"+c(document).data("mCustomScrollbar-index"));var g=m.children(".mCustomScrollBox");if(e.horizontalScroll){g.addClass("mCSB_horizontal").wrapInner("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />");var k=g.children(".mCSB_h_wrapper");k.wrapInner("<div class='mCSB_container' style='position:absolute; left:0;' />").children(".mCSB_container").css({width:k.children().outerWidth(),position:"relative"}).unwrap()}else{g.wrapInner("<div class='mCSB_container' style='position:relative; top:0;' />")}var o=g.children(".mCSB_container");if(c.support.touch){o.addClass("mCS_touch")}o.after("<div class='mCSB_scrollTools' style='position:absolute;'><div class='mCSB_draggerContainer'><div class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' style='position:relative;'></div></div><div class='mCSB_draggerRail'></div></div></div>");var l=g.children(".mCSB_scrollTools"),h=l.children(".mCSB_draggerContainer"),q=h.children(".mCSB_dragger");if(e.horizontalScroll){q.data("minDraggerWidth",q.width())}else{q.data("minDraggerHeight",q.height())}if(e.scrollButtons.enable){if(e.horizontalScroll){l.prepend("<a class='mCSB_buttonLeft' oncontextmenu='return false;'></a>").append("<a class='mCSB_buttonRight' oncontextmenu='return false;'></a>")}else{l.prepend("<a class='mCSB_buttonUp' oncontextmenu='return false;'></a>").append("<a class='mCSB_buttonDown' oncontextmenu='return false;'></a>")}}g.bind("scroll",function(){if(!m.is(".mCS_disabled")){g.scrollTop(0).scrollLeft(0)}});m.data({mCS_Init:true,mCustomScrollbarIndex:c(document).data("mCustomScrollbar-index"),horizontalScroll:e.horizontalScroll,scrollInertia:e.scrollInertia,scrollEasing:"mcsEaseOut",mouseWheel:e.mouseWheel,mouseWheelPixels:e.mouseWheelPixels,autoDraggerLength:e.autoDraggerLength,autoHideScrollbar:e.autoHideScrollbar,snapAmount:e.snapAmount,snapOffset:e.snapOffset,scrollButtons_enable:e.scrollButtons.enable,scrollButtons_scrollType:e.scrollButtons.scrollType,scrollButtons_scrollSpeed:e.scrollButtons.scrollSpeed,scrollButtons_scrollAmount:e.scrollButtons.scrollAmount,autoExpandHorizontalScroll:e.advanced.autoExpandHorizontalScroll,autoScrollOnFocus:e.advanced.autoScrollOnFocus,normalizeMouseWheelDelta:e.advanced.normalizeMouseWheelDelta,contentTouchScroll:e.contentTouchScroll,onScrollStart_Callback:e.callbacks.onScrollStart,onScroll_Callback:e.callbacks.onScroll,onTotalScroll_Callback:e.callbacks.onTotalScroll,onTotalScrollBack_Callback:e.callbacks.onTotalScrollBack,onTotalScroll_Offset:e.callbacks.onTotalScrollOffset,onTotalScrollBack_Offset:e.callbacks.onTotalScrollBackOffset,whileScrolling_Callback:e.callbacks.whileScrolling,bindEvent_scrollbar_drag:false,bindEvent_content_touch:false,bindEvent_scrollbar_click:false,bindEvent_mousewheel:false,bindEvent_buttonsContinuous_y:false,bindEvent_buttonsContinuous_x:false,bindEvent_buttonsPixels_y:false,bindEvent_buttonsPixels_x:false,bindEvent_focusin:false,bindEvent_autoHideScrollbar:false,mCSB_buttonScrollRight:false,mCSB_buttonScrollLeft:false,mCSB_buttonScrollDown:false,mCSB_buttonScrollUp:false});if(e.horizontalScroll){if(m.css("max-width")!=="none"){if(!e.advanced.updateOnContentResize){e.advanced.updateOnContentResize=true}}}else{if(m.css("max-height")!=="none"){var s=false,r=parseInt(m.css("max-height"));if(m.css("max-height").indexOf("%")>=0){s=r,r=m.parent().height()*s/100}m.css("overflow","hidden");g.css("max-height",r)}}m.mCustomScrollbar("update");if(e.advanced.updateOnBrowserResize){var i,j=c(window).width(),u=c(window).height();c(window).bind("resize."+m.data("mCustomScrollbarIndex"),function(){if(i){clearTimeout(i)}i=setTimeout(function(){if(!m.is(".mCS_disabled")&&!m.is(".mCS_destroyed")){var w=c(window).width(),v=c(window).height();if(j!==w||u!==v){if(m.css("max-height")!=="none"&&s){g.css("max-height",m.parent().height()*s/100)}m.mCustomScrollbar("update");j=w;u=v}}},150)})}if(e.advanced.updateOnContentResize){var p;if(e.horizontalScroll){var n=o.outerWidth()}else{var n=o.outerHeight()}p=setInterval(function(){if(e.horizontalScroll){if(e.advanced.autoExpandHorizontalScroll){o.css({position:"absolute",width:"auto"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:o.outerWidth(),position:"relative"}).unwrap()}var v=o.outerWidth()}else{var v=o.outerHeight()}if(v!=n){m.mCustomScrollbar("update");n=v}},300)}})},update:function(){var n=c(this),k=n.children(".mCustomScrollBox"),q=k.children(".mCSB_container");q.removeClass("mCS_no_scrollbar");n.removeClass("mCS_disabled mCS_destroyed");k.scrollTop(0).scrollLeft(0);var y=k.children(".mCSB_scrollTools"),o=y.children(".mCSB_draggerContainer"),m=o.children(".mCSB_dragger");if(n.data("horizontalScroll")){var A=y.children(".mCSB_buttonLeft"),t=y.children(".mCSB_buttonRight"),f=k.width();if(n.data("autoExpandHorizontalScroll")){q.css({position:"absolute",width:"auto"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:q.outerWidth(),position:"relative"}).unwrap()}var z=q.outerWidth()}else{var w=y.children(".mCSB_buttonUp"),g=y.children(".mCSB_buttonDown"),r=k.height(),i=q.outerHeight()}if(i>r&&!n.data("horizontalScroll")){y.css("display","block");var s=o.height();if(n.data("autoDraggerLength")){var u=Math.round(r/i*s),l=m.data("minDraggerHeight");if(u<=l){m.css({height:l})}else{if(u>=s-10){var p=s-10;m.css({height:p})}else{m.css({height:u})}}m.children(".mCSB_dragger_bar").css({"line-height":m.height()+"px"})}var B=m.height(),x=(i-r)/(s-B);n.data("scrollAmount",x).mCustomScrollbar("scrolling",k,q,o,m,w,g,A,t);var D=Math.abs(q.position().top);n.mCustomScrollbar("scrollTo",D,{scrollInertia:0,trigger:"internal"})}else{if(z>f&&n.data("horizontalScroll")){y.css("display","block");var h=o.width();if(n.data("autoDraggerLength")){var j=Math.round(f/z*h),C=m.data("minDraggerWidth");if(j<=C){m.css({width:C})}else{if(j>=h-10){var e=h-10;m.css({width:e})}else{m.css({width:j})}}}var v=m.width(),x=(z-f)/(h-v);n.data("scrollAmount",x).mCustomScrollbar("scrolling",k,q,o,m,w,g,A,t);var D=Math.abs(q.position().left);n.mCustomScrollbar("scrollTo",D,{scrollInertia:0,trigger:"internal"})}else{k.unbind("mousewheel focusin");if(n.data("horizontalScroll")){m.add(q).css("left",0)}else{m.add(q).css("top",0)}y.css("display","none");q.addClass("mCS_no_scrollbar");n.data({bindEvent_mousewheel:false,bindEvent_focusin:false})}}},scrolling:function(h,p,m,j,w,e,A,v){var k=c(this);if(!k.data("bindEvent_scrollbar_drag")){var n,o;if(c.support.msPointer){j.bind("MSPointerDown",function(H){H.preventDefault();k.data({on_drag:true});j.addClass("mCSB_dragger_onDrag");var G=c(this),J=G.offset(),F=H.originalEvent.pageX-J.left,I=H.originalEvent.pageY-J.top;if(F<G.width()&&F>0&&I<G.height()&&I>0){n=I;o=F}});c(document).bind("MSPointerMove."+k.data("mCustomScrollbarIndex"),function(H){H.preventDefault();if(k.data("on_drag")){var G=j,J=G.offset(),F=H.originalEvent.pageX-J.left,I=H.originalEvent.pageY-J.top;D(n,o,I,F)}}).bind("MSPointerUp."+k.data("mCustomScrollbarIndex"),function(x){k.data({on_drag:false});j.removeClass("mCSB_dragger_onDrag")})}else{j.bind("mousedown touchstart",function(H){H.preventDefault();H.stopImmediatePropagation();var G=c(this),K=G.offset(),F,J;if(H.type==="touchstart"){var I=H.originalEvent.touches[0]||H.originalEvent.changedTouches[0];F=I.pageX-K.left;J=I.pageY-K.top}else{k.data({on_drag:true});j.addClass("mCSB_dragger_onDrag");F=H.pageX-K.left;J=H.pageY-K.top}if(F<G.width()&&F>0&&J<G.height()&&J>0){n=J;o=F}}).bind("touchmove",function(H){H.preventDefault();H.stopImmediatePropagation();var K=H.originalEvent.touches[0]||H.originalEvent.changedTouches[0],G=c(this),J=G.offset(),F=K.pageX-J.left,I=K.pageY-J.top;D(n,o,I,F)});c(document).bind("mousemove."+k.data("mCustomScrollbarIndex"),function(H){if(k.data("on_drag")){var G=j,J=G.offset(),F=H.pageX-J.left,I=H.pageY-J.top;D(n,o,I,F)}}).bind("mouseup."+k.data("mCustomScrollbarIndex"),function(x){k.data({on_drag:false});j.removeClass("mCSB_dragger_onDrag")})}k.data({bindEvent_scrollbar_drag:true})}function D(G,H,I,F){if(k.data("horizontalScroll")){k.mCustomScrollbar("scrollTo",(j.position().left-(H))+F,{moveDragger:true,trigger:"internal"})}else{k.mCustomScrollbar("scrollTo",(j.position().top-(G))+I,{moveDragger:true,trigger:"internal"})}}if(c.support.touch&&k.data("contentTouchScroll")){if(!k.data("bindEvent_content_touch")){var l,B,r,s,u,C,E;p.bind("touchstart",function(x){x.stopImmediatePropagation();l=x.originalEvent.touches[0]||x.originalEvent.changedTouches[0];B=c(this);r=B.offset();u=l.pageX-r.left;s=l.pageY-r.top;C=s;E=u});p.bind("touchmove",function(x){x.preventDefault();x.stopImmediatePropagation();l=x.originalEvent.touches[0]||x.originalEvent.changedTouches[0];B=c(this).parent();r=B.offset();u=l.pageX-r.left;s=l.pageY-r.top;if(k.data("horizontalScroll")){k.mCustomScrollbar("scrollTo",E-u,{trigger:"internal"})}else{k.mCustomScrollbar("scrollTo",C-s,{trigger:"internal"})}})}}if(!k.data("bindEvent_scrollbar_click")){m.bind("click",function(F){var x=(F.pageY-m.offset().top)*k.data("scrollAmount"),y=c(F.target);if(k.data("horizontalScroll")){x=(F.pageX-m.offset().left)*k.data("scrollAmount")}if(y.hasClass("mCSB_draggerContainer")||y.hasClass("mCSB_draggerRail")){k.mCustomScrollbar("scrollTo",x,{trigger:"internal",scrollEasing:"draggerRailEase"})}});k.data({bindEvent_scrollbar_click:true})}if(k.data("mouseWheel")){if(!k.data("bindEvent_mousewheel")){h.bind("mousewheel",function(H,J){var G,F=k.data("mouseWheelPixels"),x=Math.abs(p.position().top),I=j.position().top,y=m.height()-j.height();if(k.data("normalizeMouseWheelDelta")){if(J<0){J=-1}else{J=1}}if(F==="auto"){F=100+Math.round(k.data("scrollAmount")/2)}if(k.data("horizontalScroll")){I=j.position().left;y=m.width()-j.width();x=Math.abs(p.position().left)}if((J>0&&I!==0)||(J<0&&I!==y)){H.preventDefault();H.stopImmediatePropagation()}G=x-(J*F);k.mCustomScrollbar("scrollTo",G,{trigger:"internal"})});k.data({bindEvent_mousewheel:true})}}if(k.data("scrollButtons_enable")){if(k.data("scrollButtons_scrollType")==="pixels"){if(k.data("horizontalScroll")){v.add(A).unbind("mousedown touchstart MSPointerDown mouseup MSPointerUp mouseout MSPointerOut touchend",i,g);k.data({bindEvent_buttonsContinuous_x:false});if(!k.data("bindEvent_buttonsPixels_x")){v.bind("click",function(x){x.preventDefault();q(Math.abs(p.position().left)+k.data("scrollButtons_scrollAmount"))});A.bind("click",function(x){x.preventDefault();q(Math.abs(p.position().left)-k.data("scrollButtons_scrollAmount"))});k.data({bindEvent_buttonsPixels_x:true})}}else{e.add(w).unbind("mousedown touchstart MSPointerDown mouseup MSPointerUp mouseout MSPointerOut touchend",i,g);k.data({bindEvent_buttonsContinuous_y:false});if(!k.data("bindEvent_buttonsPixels_y")){e.bind("click",function(x){x.preventDefault();q(Math.abs(p.position().top)+k.data("scrollButtons_scrollAmount"))});w.bind("click",function(x){x.preventDefault();q(Math.abs(p.position().top)-k.data("scrollButtons_scrollAmount"))});k.data({bindEvent_buttonsPixels_y:true})}}function q(x){if(!j.data("preventAction")){j.data("preventAction",true);k.mCustomScrollbar("scrollTo",x,{trigger:"internal"})}}}else{if(k.data("horizontalScroll")){v.add(A).unbind("click");k.data({bindEvent_buttonsPixels_x:false});if(!k.data("bindEvent_buttonsContinuous_x")){v.bind("mousedown touchstart MSPointerDown",function(y){y.preventDefault();var x=z();k.data({mCSB_buttonScrollRight:setInterval(function(){k.mCustomScrollbar("scrollTo",Math.abs(p.position().left)+x,{trigger:"internal",scrollEasing:"easeOutCirc"})},17)})});var i=function(x){x.preventDefault();clearInterval(k.data("mCSB_buttonScrollRight"))};v.bind("mouseup touchend MSPointerUp mouseout MSPointerOut",i);A.bind("mousedown touchstart MSPointerDown",function(y){y.preventDefault();var x=z();k.data({mCSB_buttonScrollLeft:setInterval(function(){k.mCustomScrollbar("scrollTo",Math.abs(p.position().left)-x,{trigger:"internal",scrollEasing:"easeOutCirc"})},17)})});var g=function(x){x.preventDefault();clearInterval(k.data("mCSB_buttonScrollLeft"))};A.bind("mouseup touchend MSPointerUp mouseout MSPointerOut",g);k.data({bindEvent_buttonsContinuous_x:true})}}else{e.add(w).unbind("click");k.data({bindEvent_buttonsPixels_y:false});if(!k.data("bindEvent_buttonsContinuous_y")){e.bind("mousedown touchstart MSPointerDown",function(y){y.preventDefault();var x=z();k.data({mCSB_buttonScrollDown:setInterval(function(){k.mCustomScrollbar("scrollTo",Math.abs(p.position().top)+x,{trigger:"internal",scrollEasing:"easeOutCirc"})},17)})});var t=function(x){x.preventDefault();clearInterval(k.data("mCSB_buttonScrollDown"))};e.bind("mouseup touchend MSPointerUp mouseout MSPointerOut",t);w.bind("mousedown touchstart MSPointerDown",function(y){y.preventDefault();var x=z();k.data({mCSB_buttonScrollUp:setInterval(function(){k.mCustomScrollbar("scrollTo",Math.abs(p.position().top)-x,{trigger:"internal",scrollEasing:"easeOutCirc"})},17)})});var f=function(x){x.preventDefault();clearInterval(k.data("mCSB_buttonScrollUp"))};w.bind("mouseup touchend MSPointerUp mouseout MSPointerOut",f);k.data({bindEvent_buttonsContinuous_y:true})}}function z(){var x=k.data("scrollButtons_scrollSpeed");if(k.data("scrollButtons_scrollSpeed")==="auto"){x=Math.round((k.data("scrollInertia")+100)/40)}return x}}}if(k.data("autoScrollOnFocus")){if(!k.data("bindEvent_focusin")){h.bind("focusin",function(){h.scrollTop(0).scrollLeft(0);var x=c(document.activeElement);if(x.is("input,textarea,select,button,a[tabindex],area,object")){var G=p.position().top,y=x.position().top,F=h.height()-x.outerHeight();if(k.data("horizontalScroll")){G=p.position().left;y=x.position().left;F=h.width()-x.outerWidth()}if(G+y<0||G+y>F){k.mCustomScrollbar("scrollTo",y,{trigger:"internal"})}}});k.data({bindEvent_focusin:true})}}if(k.data("autoHideScrollbar")){if(!k.data("bindEvent_autoHideScrollbar")){h.bind("mouseenter",function(x){h.addClass("mCS-mouse-over");d.showScrollbar.call(h.children(".mCSB_scrollTools"))}).bind("mouseleave touchend",function(x){h.removeClass("mCS-mouse-over");if(x.type==="mouseleave"){d.hideScrollbar.call(h.children(".mCSB_scrollTools"))}});k.data({bindEvent_autoHideScrollbar:true})}}},scrollTo:function(e,f){var i=c(this),o={moveDragger:false,trigger:"external",callbacks:true,scrollInertia:i.data("scrollInertia"),scrollEasing:i.data("scrollEasing")},f=c.extend(o,f),p,g=i.children(".mCustomScrollBox"),k=g.children(".mCSB_container"),r=g.children(".mCSB_scrollTools"),j=r.children(".mCSB_draggerContainer"),h=j.children(".mCSB_dragger"),t=draggerSpeed=f.scrollInertia,q,s,m,l;if(!k.hasClass("mCS_no_scrollbar")){i.data({mCS_trigger:f.trigger});if(i.data("mCS_Init")){f.callbacks=false}if(e||e===0){if(typeof(e)==="number"){if(f.moveDragger){p=e;if(i.data("horizontalScroll")){e=h.position().left*i.data("scrollAmount")}else{e=h.position().top*i.data("scrollAmount")}draggerSpeed=0}else{p=e/i.data("scrollAmount")}}else{if(typeof(e)==="string"){var v;if(e==="top"){v=0}else{if(e==="bottom"&&!i.data("horizontalScroll")){v=k.outerHeight()-g.height()}else{if(e==="left"){v=0}else{if(e==="right"&&i.data("horizontalScroll")){v=k.outerWidth()-g.width()}else{if(e==="first"){v=i.find(".mCSB_container").find(":first")}else{if(e==="last"){v=i.find(".mCSB_container").find(":last")}else{v=i.find(e)}}}}}}if(v.length===1){if(i.data("horizontalScroll")){e=v.position().left}else{e=v.position().top}p=e/i.data("scrollAmount")}else{p=e=v}}}if(i.data("horizontalScroll")){if(i.data("onTotalScrollBack_Offset")){s=-i.data("onTotalScrollBack_Offset")}if(i.data("onTotalScroll_Offset")){l=g.width()-k.outerWidth()+i.data("onTotalScroll_Offset")}if(p<0){p=e=0;clearInterval(i.data("mCSB_buttonScrollLeft"));if(!s){q=true}}else{if(p>=j.width()-h.width()){p=j.width()-h.width();e=g.width()-k.outerWidth();clearInterval(i.data("mCSB_buttonScrollRight"));if(!l){m=true}}else{e=-e}}var n=i.data("snapAmount");if(n){e=Math.round(e/n)*n-i.data("snapOffset")}d.mTweenAxis.call(this,h[0],"left",Math.round(p),draggerSpeed,f.scrollEasing);d.mTweenAxis.call(this,k[0],"left",Math.round(e),t,f.scrollEasing,{onStart:function(){if(f.callbacks&&!i.data("mCS_tweenRunning")){u("onScrollStart")}if(i.data("autoHideScrollbar")){d.showScrollbar.call(r)}},onUpdate:function(){if(f.callbacks){u("whileScrolling")}},onComplete:function(){if(f.callbacks){u("onScroll");if(q||(s&&k.position().left>=s)){u("onTotalScrollBack")}if(m||(l&&k.position().left<=l)){u("onTotalScroll")}}h.data("preventAction",false);i.data("mCS_tweenRunning",false);if(i.data("autoHideScrollbar")){if(!g.hasClass("mCS-mouse-over")){d.hideScrollbar.call(r)}}}})}else{if(i.data("onTotalScrollBack_Offset")){s=-i.data("onTotalScrollBack_Offset")}if(i.data("onTotalScroll_Offset")){l=g.height()-k.outerHeight()+i.data("onTotalScroll_Offset")}if(p<0){p=e=0;clearInterval(i.data("mCSB_buttonScrollUp"));if(!s){q=true}}else{if(p>=j.height()-h.height()){p=j.height()-h.height();e=g.height()-k.outerHeight();clearInterval(i.data("mCSB_buttonScrollDown"));if(!l){m=true}}else{e=-e}}var n=i.data("snapAmount");if(n){e=Math.round(e/n)*n-i.data("snapOffset")}d.mTweenAxis.call(this,h[0],"top",Math.round(p),draggerSpeed,f.scrollEasing);d.mTweenAxis.call(this,k[0],"top",Math.round(e),t,f.scrollEasing,{onStart:function(){if(f.callbacks&&!i.data("mCS_tweenRunning")){u("onScrollStart")}if(i.data("autoHideScrollbar")){d.showScrollbar.call(r)}},onUpdate:function(){if(f.callbacks){u("whileScrolling")}},onComplete:function(){if(f.callbacks){u("onScroll");if(q||(s&&k.position().top>=s)){u("onTotalScrollBack")}if(m||(l&&k.position().top<=l)){u("onTotalScroll")}}h.data("preventAction",false);i.data("mCS_tweenRunning",false);if(i.data("autoHideScrollbar")){if(!g.hasClass("mCS-mouse-over")){d.hideScrollbar.call(r)}}}})}if(i.data("mCS_Init")){i.data({mCS_Init:false})}}}function u(w){this.mcs={top:k.position().top,left:k.position().left,draggerTop:h.position().top,draggerLeft:h.position().left,topPct:Math.round((100*Math.abs(k.position().top))/Math.abs(k.outerHeight()-g.height())),leftPct:Math.round((100*Math.abs(k.position().left))/Math.abs(k.outerWidth()-g.width()))};switch(w){case"onScrollStart":i.data("mCS_tweenRunning",true).data("onScrollStart_Callback").call(i,this.mcs);break;case"whileScrolling":i.data("whileScrolling_Callback").call(i,this.mcs);break;case"onScroll":i.data("onScroll_Callback").call(i,this.mcs);break;case"onTotalScrollBack":i.data("onTotalScrollBack_Callback").call(i,this.mcs);break;case"onTotalScroll":i.data("onTotalScroll_Callback").call(i,this.mcs);break}}},stop:function(){var g=c(this),e=g.children().children(".mCSB_container"),f=g.children().children().children().children(".mCSB_dragger");d.mTweenAxisStop.call(this,e[0]);d.mTweenAxisStop.call(this,f[0])},disable:function(e){var j=c(this),f=j.children(".mCustomScrollBox"),h=f.children(".mCSB_container"),g=f.children(".mCSB_scrollTools"),i=g.children().children(".mCSB_dragger");f.unbind("mousewheel focusin mouseenter mouseleave touchend");h.unbind("touchstart touchmove");if(e){if(j.data("horizontalScroll")){i.add(h).css("left",0)}else{i.add(h).css("top",0)}}g.css("display","none");h.addClass("mCS_no_scrollbar");j.data({bindEvent_mousewheel:false,bindEvent_focusin:false,bindEvent_content_touch:false,bindEvent_autoHideScrollbar:false}).addClass("mCS_disabled")},destroy:function(){var e=c(this);e.removeClass("mCustomScrollbar _mCS_"+e.data("mCustomScrollbarIndex")).addClass("mCS_destroyed").children().children(".mCSB_container").unwrap().children().unwrap().siblings(".mCSB_scrollTools").remove();c(document).unbind("mousemove."+e.data("mCustomScrollbarIndex")+" mouseup."+e.data("mCustomScrollbarIndex")+" MSPointerMove."+e.data("mCustomScrollbarIndex")+" MSPointerUp."+e.data("mCustomScrollbarIndex"));c(window).unbind("resize."+e.data("mCustomScrollbarIndex"))}},d={showScrollbar:function(){this.stop().animate({opacity:1},"fast")},hideScrollbar:function(){this.stop().animate({opacity:0},"fast")},mTweenAxis:function(g,i,h,f,o,y){var y=y||{},v=y.onStart||function(){},p=y.onUpdate||function(){},w=y.onComplete||function(){};var n=t(),l,j=0,r=g.offsetTop,s=g.style;if(i==="left"){r=g.offsetLeft}var m=h-r;q();e();function t(){if(window.performance&&window.performance.now){return window.performance.now()}else{if(window.performance&&window.performance.webkitNow){return window.performance.webkitNow()}else{if(Date.now){return Date.now()}else{return new Date().getTime()}}}}function x(){if(!j){v.call()}j=t()-n;u();if(j>=g._time){g._time=(j>g._time)?j+l-(j-g._time):j+l-1;if(g._time<j+1){g._time=j+1}}if(g._time<f){g._id=_request(x)}else{w.call()}}function u(){if(f>0){g.currVal=k(g._time,r,m,f,o);s[i]=Math.round(g.currVal)+"px"}else{s[i]=h+"px"}p.call()}function e(){l=1000/60;g._time=j+l;_request=(!window.requestAnimationFrame)?function(z){u();return setTimeout(z,0.01)}:window.requestAnimationFrame;g._id=_request(x)}function q(){if(g._id==null){return}if(!window.requestAnimationFrame){clearTimeout(g._id)}else{window.cancelAnimationFrame(g._id)}g._id=null}function k(B,A,F,E,C){switch(C){case"linear":return F*B/E+A;break;case"easeOutQuad":B/=E;return -F*B*(B-2)+A;break;case"easeInOutQuad":B/=E/2;if(B<1){return F/2*B*B+A}B--;return -F/2*(B*(B-2)-1)+A;break;case"easeOutCubic":B/=E;B--;return F*(B*B*B+1)+A;break;case"easeOutQuart":B/=E;B--;return -F*(B*B*B*B-1)+A;break;case"easeOutQuint":B/=E;B--;return F*(B*B*B*B*B+1)+A;break;case"easeOutCirc":B/=E;B--;return F*Math.sqrt(1-B*B)+A;break;case"easeOutSine":return F*Math.sin(B/E*(Math.PI/2))+A;break;case"easeOutExpo":return F*(-Math.pow(2,-10*B/E)+1)+A;break;case"mcsEaseOut":var D=(B/=E)*B,z=D*B;return A+F*(0.499999999999997*z*D+-2.5*D*D+5.5*z+-6.5*D+4*B);break;case"draggerRailEase":B/=E/2;if(B<1){return F/2*B*B*B+A}B-=2;return F/2*(B*B*B+2)+A;break}}},mTweenAxisStop:function(e){if(e._id==null){return}if(!window.requestAnimationFrame){clearTimeout(e._id)}else{window.cancelAnimationFrame(e._id)}e._id=null},rafPolyfill:function(){var f=["ms","moz","webkit","o"],e=f.length;while(--e>-1&&!window.requestAnimationFrame){window.requestAnimationFrame=window[f[e]+"RequestAnimationFrame"];window.cancelAnimationFrame=window[f[e]+"CancelAnimationFrame"]||window[f[e]+"CancelRequestAnimationFrame"]}}};d.rafPolyfill.call();c.support.touch=!!("ontouchstart" in window);c.support.msPointer=window.navigator.msPointerEnabled;var a=("https:"==document.location.protocol)?"https:":"http:";c.event.special.mousewheel;c.fn.mCustomScrollbar=function(e){if(b[e]){return b[e].apply(this,Array.prototype.slice.call(arguments,1))}else{if(typeof e==="object"||!e){return b.init.apply(this,arguments)}else{c.error("Method "+e+" does not exist")}}}})(jQuery);

var deBouncer = function($,cf,of, interval){
    var debounce = function (func, threshold, execAsap) {
        var timeout;
        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }
            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);
            timeout = setTimeout(delayed, threshold || interval);
        };
    };
    jQuery.fn[cf] = function(fn){  return fn ? this.bind(of, debounce(fn)) : this.trigger(cf); };
};

/* http://keith-wood.name/countdown.html
   Countdown for jQuery v2.0.2.
   Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
   Available under the MIT (http://keith-wood.name/licence.html) license.
   */
/* http://keith-wood.name/countdown.html
      French initialisation for the jQuery countdown extension
      Written by Keith Wood (wood.keith{at}optusnet.com.au) Jan 2008. */


(function(){
    var initializing = false;

    // The base JQClass implementation
    window.JQClass = function(){};

    // Collection of derived classes
    JQClass.classes = {};

    // Create a new JQClass that inherits from this class
    JQClass.extend = function extender(prop) {
        var base = this.prototype;

        initializing = true;
        var prototype = new this();
        initializing = false;

        // Copy the properties over onto the new prototype
        for (var name in prop) {
            // Check if we're overwriting an existing function
            prototype[name] = typeof prop[name] == 'function' &&
            typeof base[name] == 'function' ?
                (function(name, fn){
                    return function() {
                        var __super = this._super;

                        this._super = function(args) {
                            return base[name].apply(this, args || []);
                        };

                        var ret = fn.apply(this, arguments);

                        this._super = __super;

                        return ret;
                    };
                })(name, prop[name]) :
                prop[name];
        }

        // The dummy class constructor
        function JQClass() {
            // All construction is actually done in the init method
            if (!initializing && this._init) {
                this._init.apply(this, arguments);
            }
        }

        // Populate our constructed prototype object
        JQClass.prototype = prototype;

        // Enforce the constructor to be what we expect
        JQClass.prototype.constructor = JQClass;

        // And make this class extendable
        JQClass.extend = extender;

        return JQClass;
    };
})();

(function($) {

    JQClass.classes.JQPlugin = JQClass.extend({

        name: 'plugin',

        defaultOptions: {},

        regionalOptions: {},

        _getters: [],

        _getMarker: function() {
            return 'is-' + this.name;
        },

        _init: function() {
            // Apply default localisations
            $.extend(this.defaultOptions, (this.regionalOptions && this.regionalOptions['']) || {});
            // Camel-case the name
            var jqName = camelCase(this.name);
            // Expose jQuery singleton manager
            $[jqName] = this;
            // Expose jQuery collection plugin
            $.fn[jqName] = function(options) {
                var otherArgs = Array.prototype.slice.call(arguments, 1);
                if ($[jqName]._isNotChained(options, otherArgs)) {
                    return $[jqName][options].apply($[jqName], [this[0]].concat(otherArgs));
                }
                return this.each(function() {
                    if (typeof options === 'string') {
                        if (options[0] === '_' || !$[jqName][options]) {
                            throw 'Unknown method: ' + options;
                        }
                        $[jqName][options].apply($[jqName], [this].concat(otherArgs));
                    }
                    else {
                        $[jqName]._attach(this, options);
                    }
                });
            };
        },

        setDefaults: function(options) {
            $.extend(this.defaultOptions, options || {});
        },

        _isNotChained: function(name, otherArgs) {
            if (name === 'option' && (otherArgs.length === 0 ||
                (otherArgs.length === 1 && typeof otherArgs[0] === 'string'))) {
                return true;
            }
            return $.inArray(name, this._getters) > -1;
        },

        _attach: function(elem, options) {
            elem = $(elem);
            if (elem.hasClass(this._getMarker())) {
                return;
            }
            elem.addClass(this._getMarker());
            options = $.extend({}, this.defaultOptions, this._getMetadata(elem), options || {});
            var inst = $.extend({name: this.name, elem: elem, options: options},
                this._instSettings(elem, options));
            elem.data(this.name, inst);
            this._postAttach(elem, inst);
            this.option(elem, options);
        },

        _instSettings: function(elem, options) {
            return {};
        },

        _postAttach: function(elem, inst) {
        },

        _getMetadata: function(elem) {
            try {
                var data = elem.data(this.name.toLowerCase()) || '';
                data = data.replace(/'/g, '"');
                data = data.replace(/([a-zA-Z0-9]+):/g, function(match, group, i) {
                    var count = data.substring(0, i).match(/"/g);
                    return (!count || count.length % 2 === 0 ? '"' + group + '":' : group + ':');
                });
                data = $.parseJSON('{' + data + '}');
                for (var name in data) {
                    var value = data[name];
                    if (typeof value === 'string' && value.match(/^new Date\((.*)\)$/)) {
                        data[name] = eval(value);
                    }
                }
                return data;
            }
            catch (e) {
                return {};
            }
        },

        _getInst: function(elem) {
            return $(elem).data(this.name) || {};
        },

        option: function(elem, name, value) {
            elem = $(elem);
            var inst = elem.data(this.name);
            if  (!name || (typeof name === 'string' && value == null)) {
                var options = (inst || {}).options;
                return (options && name ? options[name] : options);
            }
            if (!elem.hasClass(this._getMarker())) {
                return;
            }
            var options = name || {};
            if (typeof name === 'string') {
                options = {};
                options[name] = value;
            }
            this._optionsChanged(elem, inst, options);
            $.extend(inst.options, options);
        },

        _optionsChanged: function(elem, inst, options) {
        },

        destroy: function(elem) {
            elem = $(elem);
            if (!elem.hasClass(this._getMarker())) {
                return;
            }
            this._preDestroy(elem, this._getInst(elem));
            elem.removeData(this.name).removeClass(this._getMarker());
        },

        _preDestroy: function(elem, inst) {
        }
    });

    function camelCase(name) {
        return name.replace(/-([a-z])/g, function(match, group) {
            return group.toUpperCase();
        });
    }

    $.JQPlugin = {

        createPlugin: function(superClass, overrides) {
            if (typeof superClass === 'object') {
                overrides = superClass;
                superClass = 'JQPlugin';
            }
            superClass = camelCase(superClass);
            var className = camelCase(overrides.name);
            JQClass.classes[className] = JQClass.classes[superClass].extend(overrides);
            new JQClass.classes[className]();
        }
    };

})(jQuery);
(function($){var w='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.JQPlugin.createPlugin({name:w,defaultOptions:{until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,padZeroes:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1},regionalOptions:{'':{labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,digits:['0','1','2','3','4','5','6','7','8','9'],timeSeparator:':',isRTL:false}},_getters:['getTimes'],_rtlClass:w+'-rtl',_sectionClass:w+'-section',_amountClass:w+'-amount',_periodClass:w+'-period',_rowClass:w+'-row',_holdingClass:w+'-holding',_showClass:w+'-show',_descrClass:w+'-descr',_timerElems:[],_init:function(){var c=this;this._super();this._serverSyncs=[];var d=(typeof Date.now=='function'?Date.now:function(){return new Date().getTime()});var e=(window.performance&&typeof window.performance.now=='function');function timerCallBack(a){var b=(a<1e12?(e?(performance.now()+performance.timing.navigationStart):d()):a||d());if(b-g>=1000){c._updateElems();g=b}f(timerCallBack)}var f=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var g=0;if(!f||$.noRequestAnimationFrame){$.noRequestAnimationFrame=null;setInterval(function(){c._updateElems()},980)}else{g=window.animationStartTime||window.webkitAnimationStartTime||window.mozAnimationStartTime||window.oAnimationStartTime||window.msAnimationStartTime||d();f(timerCallBack)}},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},resync:function(){var d=this;$('.'+this._getMarker()).each(function(){var a=$.data(this,d.name);if(a.options.serverSync){var b=null;for(var i=0;i<d._serverSyncs.length;i++){if(d._serverSyncs[i][0]==a.options.serverSync){b=d._serverSyncs[i];break}}if(b[2]==null){var c=($.isFunction(a.options.serverSync)?a.options.serverSync.apply(this,[]):null);b[2]=(c?new Date().getTime()-c.getTime():0)-b[1]}if(a._since){a._since.setMilliseconds(a._since.getMilliseconds()+b[2])}a._until.setMilliseconds(a._until.getMilliseconds()+b[2])}});for(var i=0;i<d._serverSyncs.length;i++){if(d._serverSyncs[i][2]!=null){d._serverSyncs[i][1]+=d._serverSyncs[i][2];delete d._serverSyncs[i][2]}}},_instSettings:function(a,b){return{_periods:[0,0,0,0,0,0,0]}},_addElem:function(a){if(!this._hasElem(a)){this._timerElems.push(a)}},_hasElem:function(a){return($.inArray(a,this._timerElems)>-1)},_removeElem:function(b){this._timerElems=$.map(this._timerElems,function(a){return(a==b?null:a)})},_updateElems:function(){for(var i=this._timerElems.length-1;i>=0;i--){this._updateCountdown(this._timerElems[i])}},_optionsChanged:function(a,b,c){if(c.layout){c.layout=c.layout.replace(/&lt;/g,'<').replace(/&gt;/g,'>')}this._resetExtraLabels(b.options,c);var d=(b.options.timezone!=c.timezone);$.extend(b.options,c);this._adjustSettings(a,b,c.until!=null||c.since!=null||d);var e=new Date();if((b._since&&b._since<e)||(b._until&&b._until>e)){this._addElem(a[0])}this._updateCountdown(a,b)},_updateCountdown:function(a,b){a=a.jquery?a:$(a);b=b||this._getInst(a);if(!b){return}a.html(this._generateHTML(b)).toggleClass(this._rtlClass,b.options.isRTL);if($.isFunction(b.options.onTick)){var c=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date());if(b.options.tickInterval==1||this.periodsToSeconds(c)%b.options.tickInterval==0){b.options.onTick.apply(a[0],[c])}}var d=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(d&&!b._expiring){b._expiring=true;if(this._hasElem(a[0])||b.options.alwaysExpire){this._removeElem(a[0]);if($.isFunction(b.options.onExpiry)){b.options.onExpiry.apply(a[0],[])}if(b.options.expiryText){var e=b.options.layout;b.options.layout=b.options.expiryText;this._updateCountdown(a[0],b);b.options.layout=e}if(b.options.expiryUrl){window.location=b.options.expiryUrl}}b._expiring=false}else if(b._hold=='pause'){this._removeElem(a[0])}},_resetExtraLabels:function(a,b){for(var n in b){if(n.match(/[Ll]abels[02-9]|compactLabels1/)){a[n]=b[n]}}for(var n in a){if(n.match(/[Ll]abels[02-9]|compactLabels1/)&&typeof b[n]==='undefined'){a[n]=null}}},_adjustSettings:function(a,b,c){var d=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==b.options.serverSync){d=this._serverSyncs[i][1];break}}if(d!=null){var e=(b.options.serverSync?d:0);var f=new Date()}else{var g=($.isFunction(b.options.serverSync)?b.options.serverSync.apply(a[0],[]):null);var f=new Date();var e=(g?f.getTime()-g.getTime():0);this._serverSyncs.push([b.options.serverSync,e])}var h=b.options.timezone;h=(h==null?-f.getTimezoneOffset():h);if(c||(!c&&b._until==null&&b._since==null)){b._since=b.options.since;if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(b.options.until,f));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}}b._show=this._determineShow(b)},_preDestroy:function(a,b){this._removeElem(a[0]);a.empty()},pause:function(a){this._hold(a,'pause')},lap:function(a){this._hold(a,'lap')},resume:function(a){this._hold(a,null)},toggle:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'pause':'resume'](a)},toggleLap:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'lap':'resume'](a)},_hold:function(a,b){var c=$.data(a,this.name);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addElem(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,this.name,c);this._updateCountdown(a,c)}},getTimes:function(a){var b=$.data(a,this.name);return(!b?null:(b._hold=='pause'?b._savePeriods:(!b._hold?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date()))))},_determineTime:function(k,l){var m=this;var n=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var o=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var p=(k==null?l:(typeof k=='string'?o(k):(typeof k=='number'?n(k):k)));if(p)p.setMilliseconds(0);return p},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this;c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,c.options.significant,new Date()));var e=false;var f=0;var g=c.options.significant;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=(c.options.compact?c.options.compactLabels:c.options.labels);var l=c.options.whichLabels||this._normalLabels;var m=function(a){var b=c.options['compactLabels'+l(c._periods[a])];return(h[a]?d._translateDigits(c,c._periods[a])+(b?b[a]:k[a])+' ':'')};var n=(c.options.padZeroes?2:1);var o=function(a){var b=c.options['labels'+l(c._periods[a])];return((!c.options.significant&&h[a])||(c.options.significant&&j[a])?'<span class="'+d._sectionClass+'">'+'<span class="'+d._amountClass+'">'+d._minDigits(c,c._periods[a],n)+'</span>'+'<span class="'+d._periodClass+'">'+(b?b[a]:k[a])+'</span></span>':'')};return(c.options.layout?this._buildLayout(c,h,c.options.layout,c.options.compact,c.options.significant,j):((c.options.compact?'<span class="'+this._rowClass+' '+this._amountClass+(c._hold?' '+this._holdingClass:'')+'">'+m(Y)+m(O)+m(W)+m(D)+(h[H]?this._minDigits(c,c._periods[H],2):'')+(h[M]?(h[H]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[M],2):'')+(h[S]?(h[H]||h[M]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[S],2):''):'<span class="'+this._rowClass+' '+this._showClass+(c.options.significant||f)+(c._hold?' '+this._holdingClass:'')+'">'+o(Y)+o(O)+o(W)+o(D)+o(H)+o(M)+o(S))+'</span>'+(c.options.description?'<span class="'+this._rowClass+' '+this._descrClass+'">'+c.options.description+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=c.options[f?'compactLabels':'labels'];var k=c.options.whichLabels||this._normalLabels;var l=function(a){return(c.options[(f?'compactLabels':'labels')+k(c._periods[a])]||j)[a]};var m=function(a,b){return c.options.digits[Math.floor(a/b)%10]};var o={desc:c.options.description,sep:c.options.timeSeparator,yl:l(Y),yn:this._minDigits(c,c._periods[Y],1),ynn:this._minDigits(c,c._periods[Y],2),ynnn:this._minDigits(c,c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:this._minDigits(c,c._periods[O],1),onn:this._minDigits(c,c._periods[O],2),onnn:this._minDigits(c,c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:this._minDigits(c,c._periods[W],1),wnn:this._minDigits(c,c._periods[W],2),wnnn:this._minDigits(c,c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:this._minDigits(c,c._periods[D],1),dnn:this._minDigits(c,c._periods[D],2),dnnn:this._minDigits(c,c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:this._minDigits(c,c._periods[H],1),hnn:this._minDigits(c,c._periods[H],2),hnnn:this._minDigits(c,c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:this._minDigits(c,c._periods[M],1),mnn:this._minDigits(c,c._periods[M],2),mnnn:this._minDigits(c,c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:this._minDigits(c,c._periods[S],1),snn:this._minDigits(c,c._periods[S],2),snnn:this._minDigits(c,c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}([\\s\\S]*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b,c){b=''+b;if(b.length>=c){return this._translateDigits(a,b)}b='0000000000'+b;return this._translateDigits(a,b.substr(b.length-c))},_translateDigits:function(b,c){return(''+c).replace(/[0-9]/g,function(a){return b.options.digits[a]})},_determineShow:function(a){var b=a.options.format;var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=this._getDaysInMonth(f.getFullYear(),f.getMonth());var j=this._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=this._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}})})(jQuery);



/*
 *  Sharrre.com - Make your sharing widget!
 *  Version: beta 1.3.3
 *  Author: Julien Hany
 *  License: MIT http://en.wikipedia.org/wiki/MIT_License or GPLv2 http://en.wikipedia.org/wiki/GNU_General_Public_License
 */

;(function ( $, window, document, undefined ) {
    /* Defaults
  ================================================== */
    var pluginName = 'sharrre',
        defaults = {
            className: 'sharrre',
            share: {
                googlePlus: false,
                facebook: false,
                twitter: false,
                digg: false,
                delicious: false,
                stumbleupon: false,
                linkedin: false,
                pinterest: false
            },
            shareTotal: 0,
            template: '',
            title: '',
            url: document.location.href,
            text: document.title,
            urlCurl: theme_options.sharrre_dir_prk+'/inc/modules/sharrre/sharrre.php',
            count: {}, //counter by social network
            total: 0,  //total of sharing
            shorterTotal: true, //show total by k or M when number is to big
            enableHover: true, //disable if you want to personalize hover event with callback
            enableCounter: true, //disable if you just want use buttons
            enableTracking: false, //tracking with google analitycs
            hover: function(){}, //personalize hover event with this callback function
            hide: function(){}, //personalize hide event with this callback function
            click: function(){}, //personalize click event with this callback function
            render: function(){}, //personalize render event with this callback function
            buttons: {  //settings for buttons
                googlePlus : {  //http://www.google.com/webmasters/+1/button/
                    url: '',  //if you need to personnalize button url
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    size: 'medium',
                    lang: 'en-US',
                    annotation: ''
                },
                facebook: { //http://developers.facebook.com/docs/reference/plugins/like/
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    action: 'like',
                    layout: 'button_count',
                    width: '',
                    send: 'false',
                    faces: 'false',
                    colorscheme: '',
                    font: '',
                    lang: 'en_US'
                },
                twitter: {  //http://twitter.com/about/resources/tweetbutton
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    count: 'horizontal',
                    hashtags: '',
                    via: '',
                    related: '',
                    lang: 'en'
                },
                digg: { //http://about.digg.com/downloads/button/smart
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    type: 'DiggCompact'
                },
                delicious: {
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    size: 'medium' //medium or tall
                },
                stumbleupon: {  //http://www.stumbleupon.com/badges/
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    layout: '1'
                },
                linkedin: {  //http://developer.linkedin.com/plugins/share-button
                    url: '',  //if you need to personalize url button
                    urlCount: false,  //if you want to use personnalize button url on global counter
                    counter: ''
                },
                pinterest: { //http://pinterest.com/about/goodies/
                    url: '',  //if you need to personalize url button
                    media: '',
                    description: '',
                    layout: 'horizontal'
                }
            }
        },
        /* Json URL to get count number
  ================================================== */
        urlJson = {
            googlePlus: "",
            facebook: "https://graph.facebook.com/fql?q=SELECT%20url,%20normalized_url,%20share_count,%20like_count,%20comment_count,%20total_count,commentsbox_count,%20comments_fbid,%20click_count%20FROM%20link_stat%20WHERE%20url=%27{url}%27&callback=?",
            twitter: "https://cdn.api.twitter.com/1/urls/count.json?url={url}&callback=?",
            digg: "https://services.digg.com/2.0/story.getInfo?links={url}&type=javascript&callback=?",
            delicious: 'https://feeds.delicious.com/v2/json/urlinfo/data?url={url}&callback=?',
            stumbleupon: "",
            linkedin: "https://www.linkedin.com/countserv/count/share?format=jsonp&url={url}&callback=?",
            pinterest: ""
        },
        /* Load share buttons asynchronously
  ================================================== */
        loadButton = {
            googlePlus : function(self){
                var sett = self.options.buttons.googlePlus;
                $(self.element).find('.buttons').append('<div class="button googleplus"><div class="g-plusone" data-size="'+sett.size+'" data-href="'+(sett.url !== '' ? sett.url : self.options.url)+'" data-annotation="'+sett.annotation+'"></div></div>');
                window.___gcfg = {
                    lang: self.options.buttons.googlePlus.lang
                };
                var loading = 0;
                if(typeof gapi === 'undefined' && loading == 0){
                    loading = 1;
                    (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = '//apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                    })();
                }
                else{
                    gapi.plusone.go();
                }
            },
            facebook : function(self){
                var sett = self.options.buttons.facebook;
                $(self.element).find('.buttons').append('<div class="button facebook"><div id="fb-root"></div><div class="fb-like" data-href="'+(sett.url !== '' ? sett.url : self.options.url)+'" data-send="'+sett.send+'" data-layout="'+sett.layout+'" data-width="'+sett.width+'" data-show-faces="'+sett.faces+'" data-action="'+sett.action+'" data-colorscheme="'+sett.colorscheme+'" data-font="'+sett.font+'" data-via="'+sett.via+'"></div></div>');
                var loading = 0;
                if(typeof FB === 'undefined' && loading == 0){
                    loading = 1;
                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) {return;}
                        js = d.createElement(s); js.id = id;
                        js.src = '//connect.facebook.net/'+sett.lang+'/all.js#xfbml=1';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                }
                else{
                    FB.XFBML.parse();
                }
            },
            twitter : function(self){
                var sett = self.options.buttons.twitter;
                $(self.element).find('.buttons').append('<div class="button twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'+(sett.url !== '' ? sett.url : self.options.url)+'" data-count="'+sett.count+'" data-text="'+self.options.text+'" data-via="'+sett.via+'" data-hashtags="'+sett.hashtags+'" data-related="'+sett.related+'" data-lang="'+sett.lang+'">Tweet</a></div>');
                var loading = 0;
                if(typeof twttr === 'undefined' && loading == 0){
                    loading = 1;
                    (function() {
                        var twitterScriptTag = document.createElement('script');
                        twitterScriptTag.type = 'text/javascript';
                        twitterScriptTag.async = true;
                        twitterScriptTag.src = '//platform.twitter.com/widgets.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(twitterScriptTag, s);
                    })();
                }
                else{
                    $.ajax({ url: '//platform.twitter.com/widgets.js', dataType: 'script', cache:true});
                }
            },
            digg : function(self){
                var sett = self.options.buttons.digg;
                $(self.element).find('.buttons').append('<div class="button digg"><a class="DiggThisButton '+sett.type+'" rel="nofollow external" href="http://digg.com/submit?url='+encodeURIComponent((sett.url !== '' ? sett.url : self.options.url))+'"></a></div>');
                var loading = 0;
                if(typeof __DBW === 'undefined' && loading == 0){
                    loading = 1;
                    (function() {
                        var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
                        s.type = 'text/javascript';
                        s.async = true;
                        s.src = '//widgets.digg.com/buttons.js';
                        s1.parentNode.insertBefore(s, s1);
                    })();
                }
            },
            delicious : function(self){
                if(self.options.buttons.delicious.size == 'tall'){
                    var css = 'width:50px;',
                        cssCount = 'height:35px;width:50px;font-size:15px;line-height:35px;',
                        cssShare = 'height:18px;line-height:18px;margin-top:3px;';
                }
                else{
                    var css = 'width:93px;',
                        cssCount = 'float:right;padding:0 3px;height:20px;width:26px;line-height:20px;',
                        cssShare = 'float:left;height:20px;line-height:20px;';
                }
                var count = self.shorterTotal(self.options.count.delicious);
                if(typeof count === "undefined"){
                    count = 0;
                }
                $(self.element).find('.buttons').append(
                    '<div class="button delicious"><div style="'+css+'font:12px Arial,Helvetica,sans-serif;cursor:pointer;color:#666666;display:inline-block;float:none;height:20px;line-height:normal;margin:0;padding:0;text-indent:0;vertical-align:baseline;">'+
                    '<div style="'+cssCount+'background-color:#fff;margin-bottom:5px;overflow:hidden;text-align:center;border:1px solid #ccc;border-radius:3px;">'+count+'</div>'+
                    '<div style="'+cssShare+'display:block;padding:0;text-align:center;text-decoration:none;width:50px;background-color:#7EACEE;border:1px solid #40679C;border-radius:3px;color:#fff;">'+
                    '<img src="http://www.delicious.com/static/img/delicious.small.gif" height="10" width="10" alt="Delicious" /> Add</div></div></div>');

                $(self.element).find('.delicious').on('click', function(){
                    self.openPopup('delicious');
                });
            },
            stumbleupon : function(self){
                var sett = self.options.buttons.stumbleupon;
                $(self.element).find('.buttons').append('<div class="button stumbleupon"><su:badge layout="'+sett.layout+'" location="'+(sett.url !== '' ? sett.url : self.options.url)+'"></su:badge></div>');
                var loading = 0;
                if(typeof STMBLPN === 'undefined' && loading == 0){
                    loading = 1;
                    (function() {
                        var li = document.createElement('script');li.type = 'text/javascript';li.async = true;
                        li.src = '//platform.stumbleupon.com/1/widgets.js';
                        var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(li, s);
                    })();
                    s = window.setTimeout(function(){
                        if(typeof STMBLPN !== 'undefined'){
                            STMBLPN.processWidgets();
                            clearInterval(s);
                        }
                    },500);
                }
                else{
                    STMBLPN.processWidgets();
                }
            },
            linkedin : function(self){
                var sett = self.options.buttons.linkedin;
                $(self.element).find('.buttons').append('<div class="button linkedin"><script type="in/share" data-url="'+(sett.url !== '' ? sett.url : self.options.url)+'" data-counter="'+sett.counter+'"></script></div>');
                var loading = 0;
                if(typeof window.IN === 'undefined' && loading == 0){
                    loading = 1;
                    (function() {
                        var li = document.createElement('script');li.type = 'text/javascript';li.async = true;
                        li.src = '//platform.linkedin.com/in.js';
                        var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(li, s);
                    })();
                }
                else{
                    window.IN.init();
                }
            },
            pinterest : function(self){
                var sett = self.options.buttons.pinterest;
                $(self.element).find('.buttons').append('<div class="button pinterest"><a href="http://pinterest.com/pin/create/button/?url='+(sett.url !== '' ? sett.url : self.options.url)+'&media='+sett.media+'&description='+sett.description+'" class="pin-it-button" count-layout="'+sett.layout+'">Pin It</a></div>');

                (function() {
                    var li = document.createElement('script');li.type = 'text/javascript';li.async = true;
                    li.src = '//assets.pinterest.com/js/pinit.js';
                    var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(li, s);
                })();
            }
        },
        /* Tracking for Google Analytics
  ================================================== */
        tracking = {
            googlePlus: function(){},
            facebook: function(){
                fb = window.setInterval(function(){
                    if (typeof FB !== 'undefined') {
                        FB.Event.subscribe('edge.create', function(targetUrl) {
                            _gaq.push(['_trackSocial', 'facebook', 'like', targetUrl]);
                        });
                        FB.Event.subscribe('edge.remove', function(targetUrl) {
                            _gaq.push(['_trackSocial', 'facebook', 'unlike', targetUrl]);
                        });
                        FB.Event.subscribe('message.send', function(targetUrl) {
                            _gaq.push(['_trackSocial', 'facebook', 'send', targetUrl]);
                        });
                        clearInterval(fb);
                    }
                },1000);
            },
            twitter: function(){
                tw = window.setInterval(function(){
                    if (typeof twttr !== 'undefined') {
                        twttr.events.bind('tweet', function(event) {
                            if (event) {
                                _gaq.push(['_trackSocial', 'twitter', 'tweet']);
                            }
                        });
                        clearInterval(tw);
                    }
                },1000);
            },
            digg: function(){    },
            delicious: function(){},
            stumbleupon: function(){},
            linkedin: function(){
                function LinkedInShare() {
                    _gaq.push(['_trackSocial', 'linkedin', 'share']);
                }
            },
            pinterest: function(){

            }
        },
        /* Popup for each social network
  ================================================== */
        popup = {
            googlePlus: function(opt){
                window.open("https://plus.google.com/share?hl="+opt.buttons.googlePlus.lang+"&url="+encodeURIComponent((opt.buttons.googlePlus.url !== '' ? opt.buttons.googlePlus.url : opt.url)), "", "toolbar=0, status=0, width=900, height=500");
            },
            facebook: function(opt){
                window.open("http://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent((opt.buttons.facebook.url !== '' ? opt.buttons.facebook.url : opt.url))+"&t="+opt.text+"", "", "toolbar=0, status=0, width=900, height=500");
            },
            twitter: function(opt){
                window.open("https://twitter.com/intent/tweet?text="+encodeURIComponent(opt.text)+"&url="+encodeURIComponent((opt.buttons.twitter.url !== '' ? opt.buttons.twitter.url : opt.url))+(opt.buttons.twitter.via !== '' ? '&via='+opt.buttons.twitter.via : ''), "", "toolbar=0, status=0, width=650, height=360");
            },
            digg: function(opt){
                window.open("http://digg.com/tools/diggthis/submit?url="+encodeURIComponent((opt.buttons.digg.url !== '' ? opt.buttons.digg.url : opt.url))+"&title="+opt.text+"&related=true&style=true", "", "toolbar=0, status=0, width=650, height=360");
            },
            delicious: function(opt){
                window.open('http://www.delicious.com/save?v=5&noui&jump=close&url='+encodeURIComponent((opt.buttons.delicious.url !== '' ? opt.buttons.delicious.url : opt.url))+'&title='+opt.text, 'delicious', 'toolbar=no,width=550,height=550');
            },
            stumbleupon: function(opt){
                window.open('http://www.stumbleupon.com/badge/?url='+encodeURIComponent((opt.buttons.delicious.url !== '' ? opt.buttons.delicious.url : opt.url)), 'stumbleupon', 'toolbar=no,width=550,height=550');
            },
            linkedin: function(opt){
                window.open('https://www.linkedin.com/cws/share?url='+encodeURIComponent((opt.buttons.delicious.url !== '' ? opt.buttons.delicious.url : opt.url))+'&token=&isFramed=true', 'linkedin', 'toolbar=no,width=550,height=550');
            },
            pinterest: function(opt){
                window.open('http://pinterest.com/pin/create/button/?url='+encodeURIComponent((opt.buttons.pinterest.url !== '' ? opt.buttons.pinterest.url : opt.url))+'&media='+$('#prk_pint').attr('data-media')+'&description='+$('#prk_pint').attr('data-desc'), 'pinterest', 'toolbar=no,width=700,height=300');
            }
        };

    /* Plugin constructor
  ================================================== */
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( true, {}, defaults, options);
        this.options.share = options.share; //simple solution to allow order of buttons

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    };

    /* Initialization method
  ================================================== */
    Plugin.prototype.init = function () {
        var self = this;
        if(this.options.urlCurl !== ''){

        }
        $(this.element).addClass(this.options.className);

        //HTML5 Custom data
        if(typeof $(this.element).data('title') !== 'undefined'){
            this.options.title = $(this.element).attr('data-title');
        }
        if(typeof $(this.element).data('url') !== 'undefined'){
            this.options.url = $(this.element).data('url');
        }
        if(typeof $(this.element).data('text') !== 'undefined'){
            this.options.text = $(this.element).data('text');
        }

        //how many social website have been selected
        $.each(this.options.share, function(name, val) {
            if(val === true){
                self.options.shareTotal ++;
            }
        });

        if(self.options.enableCounter === true){  //if for some reason you don't need counter
            //get count of social share that have been selected
            $.each(this.options.share, function(name, val) {
                if(val === true){

                    try {
                        self.getSocialJson(name);
                    } catch(e){
                    }
                }
            });
        }
        else if(self.options.template !== ''){
            this.options.render(this, this.options);
        }
        else{
            this.loadButtons();
        }

        //add hover event
        $(this.element).hover(function(){
            //load social button if enable and 1 time
            if($(this).find('.buttons').length === 0 && self.options.enableHover === true){
                self.loadButtons();
            }
            self.options.hover(self, self.options);
        }, function(){
            self.options.hide(self, self.options);
        });

        //click event
        $(this.element).click(function(){
            self.options.click(self, self.options);
            return false;
        });
    };

    /* loadButtons methode
  ================================================== */
    Plugin.prototype.loadButtons = function () {
        var self = this;
        $(this.element).append('<div class="buttons"></div>');
        $.each(self.options.share, function(name, val) {
            if(val == true){
                loadButton[name](self);
                if(self.options.enableTracking === true){ //add tracking
                    tracking[name]();
                }
            }
        });
    };

    /* getSocialJson methode
  ================================================== */
    Plugin.prototype.getSocialJson = function (name) {
        var self = this,
            count = 0,
            url = urlJson[name].replace('{url}', encodeURIComponent(this.options.url));
        self.renderer();
        self.options.count[name] = 0;
        self.rendererPerso();
    };

    /* launch render methode
  ================================================== */
    Plugin.prototype.rendererPerso = function () {
        //check if this is the last social website to launch render
        var shareCount = 0;
        for (e in this.options.count) { shareCount++; }
        if(shareCount === this.options.shareTotal){
            this.options.render(this, this.options);
        }
    };

    /* render methode
  ================================================== */
    Plugin.prototype.renderer = function () {
        var total = this.options.total,
            template = this.options.template;
        if(this.options.shorterTotal === true){  //format number like 1.2k or 5M
            total = this.shorterTotal(total);
        }

        if(template !== ''){  //if there is a template
            template = template.replace('{total}', total);
            $(this.element).html(template);
        }
        else{ //template by defaults
            $(this.element).html(
                '<div class="box"><a class="count" href="#">' + total + '</a>' +
                (this.options.title !== '' ? '<a class="share" href="#">' + this.options.title + '</a>' : '') +
                '</div>'
            );
        }
    };

    /* format total numbers like 1.2k or 5M
  ================================================== */
    Plugin.prototype.shorterTotal = function (num) {
        if (num >= 1e6){
            num = (num / 1e6).toFixed(2) + "M"
        } else if (num >= 1e3){
            num = (num / 1e3).toFixed(1) + "k"
        }
        return num;
    };

    /* Methode for open popup
  ================================================== */
    Plugin.prototype.openPopup = function (site) {
        popup[site](this.options);  //open
        if(this.options.enableTracking === true){ //tracking!
            var tracking = {
                googlePlus: {site: 'Google', action: '+1'},
                facebook: {site: 'facebook', action: 'like'},
                twitter: {site: 'twitter', action: 'tweet'},
                digg: {site: 'digg', action: 'add'},
                delicious: {site: 'delicious', action: 'add'},
                stumbleupon: {site: 'stumbleupon', action: 'add'},
                linkedin: {site: 'linkedin', action: 'share'},
                pinterest: {site: 'pinterest', action: 'pin'}
            };
            _gaq.push(['_trackSocial', tracking[site].site, tracking[site].action]);
        }
    };

    /* Methode for add +1 to a counter
  ================================================== */
    Plugin.prototype.simulateClick = function () {
        var html = $(this.element).html();
        $(this.element).html(html.replace(this.options.total, this.options.total+1));
    };

    /* Methode for add +1 to a counter
  ================================================== */
    Plugin.prototype.update = function (url, text) {
        if(url !== ''){
            this.options.url = url;
        }
        if(text !== ''){
            this.options.text = text;
        }
    };

    /* A really lightweight plugin wrapper around the constructor, preventing against multiple instantiations
  ================================================== */
    $.fn[pluginName] = function ( options ) {
        var args = arguments;
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
            return this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);
                if (instance instanceof Plugin && typeof instance[options] === 'function') {
                    instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
                }
            });
        }
    };
})(jQuery, window, document);

/*! Magnific Popup - v1.1.0 - 2016-02-20
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2016 Dmitry Semenov; */
;(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(window.jQuery || window.Zepto);
    }
}(function($) {



    /**
     * Private static constants
     */
    var CLOSE_EVENT = 'Close',
        BEFORE_CLOSE_EVENT = 'BeforeClose',
        AFTER_CLOSE_EVENT = 'AfterClose',
        BEFORE_APPEND_EVENT = 'BeforeAppend',
        MARKUP_PARSE_EVENT = 'MarkupParse',
        OPEN_EVENT = 'Open',
        CHANGE_EVENT = 'Change',
        NS = 'mfp',
        EVENT_NS = '.' + NS,
        READY_CLASS = 'mfp-ready',
        REMOVING_CLASS = 'mfp-removing',
        PREVENT_CLOSE_CLASS = 'mfp-prevent-close';


    /**
     * Private vars
     */
    /*jshint -W079 */
    var mfp, // As we have only one instance of MagnificPopup object, we define it locally to not to use 'this'
        MagnificPopup = function(){},
        _isJQ = !!(window.jQuery),
        _prevStatus,
        _window = $(window),
        _document,
        _prevContentType,
        _wrapClasses,
        _currPopupType;


    /**
     * Private functions
     */
    var _mfpOn = function(name, f) {
            mfp.ev.on(NS + name + EVENT_NS, f);
        },
        _getEl = function(className, appendTo, html, raw) {
            var el = document.createElement('div');
            el.className = 'mfp-'+className;
            if(html) {
                el.innerHTML = html;
            }
            if(!raw) {
                el = $(el);
                if(appendTo) {
                    el.appendTo(appendTo);
                }
            } else if(appendTo) {
                appendTo.appendChild(el);
            }
            return el;
        },
        _mfpTrigger = function(e, data) {
            mfp.ev.triggerHandler(NS + e, data);

            if(mfp.st.callbacks) {
                // converts "mfpEventName" to "eventName" callback and triggers it if it's present
                e = e.charAt(0).toLowerCase() + e.slice(1);
                if(mfp.st.callbacks[e]) {
                    mfp.st.callbacks[e].apply(mfp, $.isArray(data) ? data : [data]);
                }
            }
        },
        _getCloseBtn = function(type) {
            if(type !== _currPopupType || !mfp.currTemplate.closeBtn) {
                mfp.currTemplate.closeBtn = $( mfp.st.closeMarkup.replace('%title%', mfp.st.tClose ) );
                _currPopupType = type;
            }
            return mfp.currTemplate.closeBtn;
        },
        // Initialize Magnific Popup only when called at least once
        _checkInstance = function() {
            if(!$.magnificPopup.instance) {
                /*jshint -W020 */
                mfp = new MagnificPopup();
                mfp.init();
                $.magnificPopup.instance = mfp;
            }
        },
        // CSS transition detection, http://stackoverflow.com/questions/7264899/detect-css-transitions-using-javascript-and-without-modernizr
        supportsTransitions = function() {
            var s = document.createElement('p').style, // 's' for style. better to create an element if body yet to exist
                v = ['ms','O','Moz','Webkit']; // 'v' for vendor

            if( s['transition'] !== undefined ) {
                return true;
            }

            while( v.length ) {
                if( v.pop() + 'Transition' in s ) {
                    return true;
                }
            }

            return false;
        };



    /**
     * Public functions
     */
    MagnificPopup.prototype = {

        constructor: MagnificPopup,

        /**
         * Initializes Magnific Popup plugin.
         * This function is triggered only once when $.fn.magnificPopup or $.magnificPopup is executed
         */
        init: function() {
            var appVersion = navigator.appVersion;
            mfp.isLowIE = mfp.isIE8 = document.all && !document.addEventListener;
            mfp.isAndroid = (/android/gi).test(appVersion);
            mfp.isIOS = (/iphone|ipad|ipod/gi).test(appVersion);
            mfp.supportsTransition = supportsTransitions();

            // We disable fixed positioned lightbox on devices that don't handle it nicely.
            // If you know a better way of detecting this - let me know.
            mfp.probablyMobile = (mfp.isAndroid || mfp.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent) );
            _document = $(document);

            mfp.popupsCache = {};
        },

        /**
         * Opens popup
         * @param  data [description]
         */
        open: function(data) {

            var i;

            if(data.isObj === false) {
                // convert jQuery collection to array to avoid conflicts later
                mfp.items = data.items.toArray();

                mfp.index = 0;
                var items = data.items,
                    item;
                for(i = 0; i < items.length; i++) {
                    item = items[i];
                    if(item.parsed) {
                        item = item.el[0];
                    }
                    if(item === data.el[0]) {
                        mfp.index = i;
                        break;
                    }
                }
            } else {
                mfp.items = $.isArray(data.items) ? data.items : [data.items];
                mfp.index = data.index || 0;
            }

            // if popup is already opened - we just update the content
            if(mfp.isOpen) {
                mfp.updateItemHTML();
                return;
            }

            mfp.types = [];
            _wrapClasses = '';
            if(data.mainEl && data.mainEl.length) {
                mfp.ev = data.mainEl.eq(0);
            } else {
                mfp.ev = _document;
            }

            if(data.key) {
                if(!mfp.popupsCache[data.key]) {
                    mfp.popupsCache[data.key] = {};
                }
                mfp.currTemplate = mfp.popupsCache[data.key];
            } else {
                mfp.currTemplate = {};
            }



            mfp.st = $.extend(true, {}, $.magnificPopup.defaults, data );
            mfp.fixedContentPos = mfp.st.fixedContentPos === 'auto' ? !mfp.probablyMobile : mfp.st.fixedContentPos;

            if(mfp.st.modal) {
                mfp.st.closeOnContentClick = false;
                mfp.st.closeOnBgClick = false;
                mfp.st.showCloseBtn = false;
                mfp.st.enableEscapeKey = false;
            }


            // Building markup
            // main containers are created only once
            if(!mfp.bgOverlay) {

                // Dark overlay
                mfp.bgOverlay = _getEl('bg').on('click'+EVENT_NS, function() {
                    mfp.close();
                });

                mfp.wrap = _getEl('wrap').attr('tabindex', -1).on('click'+EVENT_NS, function(e) {
                    if(mfp._checkIfClose(e.target)) {
                        mfp.close();
                    }
                });

                mfp.container = _getEl('container', mfp.wrap);
            }

            mfp.contentContainer = _getEl('content');
            if(mfp.st.preloader) {
                mfp.preloader = _getEl('preloader', mfp.container, mfp.st.tLoading);
            }


            // Initializing modules
            var modules = $.magnificPopup.modules;
            for(i = 0; i < modules.length; i++) {
                var n = modules[i];
                n = n.charAt(0).toUpperCase() + n.slice(1);
                mfp['init'+n].call(mfp);
            }
            _mfpTrigger('BeforeOpen');


            if(mfp.st.showCloseBtn) {
                // Close button
                if(!mfp.st.closeBtnInside) {
                    mfp.wrap.append( _getCloseBtn() );
                } else {
                    _mfpOn(MARKUP_PARSE_EVENT, function(e, template, values, item) {
                        values.close_replaceWith = _getCloseBtn(item.type);
                    });
                    _wrapClasses += ' mfp-close-btn-in';
                }
            }

            if(mfp.st.alignTop) {
                _wrapClasses += ' mfp-align-top';
            }



            if(mfp.fixedContentPos) {
                mfp.wrap.css({
                    overflow: mfp.st.overflowY,
                    overflowX: 'hidden',
                    overflowY: mfp.st.overflowY
                });
            } else {
                mfp.wrap.css({
                    top: _window.scrollTop(),
                    position: 'absolute'
                });
            }
            if( mfp.st.fixedBgPos === false || (mfp.st.fixedBgPos === 'auto' && !mfp.fixedContentPos) ) {
                mfp.bgOverlay.css({
                    height: _document.height(),
                    position: 'absolute'
                });
            }



            if(mfp.st.enableEscapeKey) {
                // Close on ESC key
                _document.on('keyup' + EVENT_NS, function(e) {
                    if(e.keyCode === 27) {
                        mfp.close();
                    }
                });
            }

            _window.on('resize' + EVENT_NS, function() {
                mfp.updateSize();
            });


            if(!mfp.st.closeOnContentClick) {
                _wrapClasses += ' mfp-auto-cursor';
            }

            if(_wrapClasses)
                mfp.wrap.addClass(_wrapClasses);


            // this triggers recalculation of layout, so we get it once to not to trigger twice
            var windowHeight = mfp.wH = _window.height();


            var windowStyles = {};

            if( mfp.fixedContentPos ) {
                if(mfp._hasScrollBar(windowHeight)){
                    var s = mfp._getScrollbarSize();
                    if(s) {
                        windowStyles.marginRight = s;
                    }
                }
            }

            if(mfp.fixedContentPos) {
                if(!mfp.isIE7) {
                    windowStyles.overflow = 'hidden';
                } else {
                    // ie7 double-scroll bug
                    $('body, html').css('overflow', 'hidden');
                }
            }



            var classesToadd = mfp.st.mainClass;
            if(mfp.isIE7) {
                classesToadd += ' mfp-ie7';
            }
            if(classesToadd) {
                mfp._addClassToMFP( classesToadd );
            }

            // add content
            mfp.updateItemHTML();

            _mfpTrigger('BuildControls');

            // remove scrollbar, add margin e.t.c
            $('html').css(windowStyles);

            // add everything to DOM
            mfp.bgOverlay.add(mfp.wrap).prependTo( mfp.st.prependTo || $(document.body) );

            // Save last focused element
            mfp._lastFocusedEl = document.activeElement;

            // Wait for next cycle to allow CSS transition
            setTimeout(function() {

                if(mfp.content) {
                    mfp._addClassToMFP(READY_CLASS);
                    mfp._setFocus();
                } else {
                    // if content is not defined (not loaded e.t.c) we add class only for BG
                    mfp.bgOverlay.addClass(READY_CLASS);
                }

                // Trap the focus in popup
                _document.on('focusin' + EVENT_NS, mfp._onFocusIn);

            }, 16);

            mfp.isOpen = true;
            mfp.updateSize(windowHeight);
            _mfpTrigger(OPEN_EVENT);

            return data;
        },

        /**
         * Closes the popup
         */
        close: function() {
            if(!mfp.isOpen) return;
            _mfpTrigger(BEFORE_CLOSE_EVENT);

            mfp.isOpen = false;
            // for CSS3 animation
            if(mfp.st.removalDelay && !mfp.isLowIE && mfp.supportsTransition )  {
                mfp._addClassToMFP(REMOVING_CLASS);
                setTimeout(function() {
                    mfp._close();
                }, mfp.st.removalDelay);
            } else {
                mfp._close();
            }
        },

        /**
         * Helper for close() function
         */
        _close: function() {
            _mfpTrigger(CLOSE_EVENT);

            var classesToRemove = REMOVING_CLASS + ' ' + READY_CLASS + ' ';

            mfp.bgOverlay.detach();
            mfp.wrap.detach();
            mfp.container.empty();

            if(mfp.st.mainClass) {
                classesToRemove += mfp.st.mainClass + ' ';
            }

            mfp._removeClassFromMFP(classesToRemove);

            if(mfp.fixedContentPos) {
                var windowStyles = {marginRight: ''};
                if(mfp.isIE7) {
                    $('body, html').css('overflow', '');
                } else {
                    windowStyles.overflow = '';
                }
                $('html').css(windowStyles);
            }

            _document.off('keyup' + EVENT_NS + ' focusin' + EVENT_NS);
            mfp.ev.off(EVENT_NS);

            // clean up DOM elements that aren't removed
            mfp.wrap.attr('class', 'mfp-wrap').removeAttr('style');
            mfp.bgOverlay.attr('class', 'mfp-bg');
            mfp.container.attr('class', 'mfp-container');

            // remove close button from target element
            if(mfp.st.showCloseBtn &&
                (!mfp.st.closeBtnInside || mfp.currTemplate[mfp.currItem.type] === true)) {
                if(mfp.currTemplate.closeBtn)
                    mfp.currTemplate.closeBtn.detach();
            }


            if(mfp.st.autoFocusLast && mfp._lastFocusedEl) {
                $(mfp._lastFocusedEl).focus(); // put tab focus back
            }
            mfp.currItem = null;
            mfp.content = null;
            mfp.currTemplate = null;
            mfp.prevHeight = 0;

            _mfpTrigger(AFTER_CLOSE_EVENT);
        },

        updateSize: function(winHeight) {

            if(mfp.isIOS) {
                // fixes iOS nav bars https://github.com/dimsemenov/Magnific-Popup/issues/2
                var zoomLevel = document.documentElement.clientWidth / window.innerWidth;
                var height = window.innerHeight * zoomLevel;
                mfp.wrap.css('height', height);
                mfp.wH = height;
            } else {
                mfp.wH = winHeight || _window.height();
            }
            // Fixes #84: popup incorrectly positioned with position:relative on body
            if(!mfp.fixedContentPos) {
                mfp.wrap.css('height', mfp.wH);
            }

            _mfpTrigger('Resize');

        },

        /**
         * Set content of popup based on current index
         */
        updateItemHTML: function() {
            var item = mfp.items[mfp.index];

            // Detach and perform modifications
            mfp.contentContainer.detach();

            if(mfp.content)
                mfp.content.detach();

            if(!item.parsed) {
                item = mfp.parseEl( mfp.index );
            }

            var type = item.type;

            _mfpTrigger('BeforeChange', [mfp.currItem ? mfp.currItem.type : '', type]);
            // BeforeChange event works like so:
            // _mfpOn('BeforeChange', function(e, prevType, newType) { });

            mfp.currItem = item;

            if(!mfp.currTemplate[type]) {
                var markup = mfp.st[type] ? mfp.st[type].markup : false;

                // allows to modify markup
                _mfpTrigger('FirstMarkupParse', markup);

                if(markup) {
                    mfp.currTemplate[type] = $(markup);
                } else {
                    // if there is no markup found we just define that template is parsed
                    mfp.currTemplate[type] = true;
                }
            }

            if(_prevContentType && _prevContentType !== item.type) {
                mfp.container.removeClass('mfp-'+_prevContentType+'-holder');
            }

            var newContent = mfp['get' + type.charAt(0).toUpperCase() + type.slice(1)](item, mfp.currTemplate[type]);
            mfp.appendContent(newContent, type);

            item.preloaded = true;

            _mfpTrigger(CHANGE_EVENT, item);
            _prevContentType = item.type;

            // Append container back after its content changed
            mfp.container.prepend(mfp.contentContainer);

            _mfpTrigger('AfterChange');
        },


        /**
         * Set HTML content of popup
         */
        appendContent: function(newContent, type) {
            mfp.content = newContent;

            if(newContent) {
                if(mfp.st.showCloseBtn && mfp.st.closeBtnInside &&
                    mfp.currTemplate[type] === true) {
                    // if there is no markup, we just append close button element inside
                    if(!mfp.content.find('.mfp-close').length) {
                        mfp.content.append(_getCloseBtn());
                    }
                } else {
                    mfp.content = newContent;
                }
            } else {
                mfp.content = '';
            }

            _mfpTrigger(BEFORE_APPEND_EVENT);
            mfp.container.addClass('mfp-'+type+'-holder');

            mfp.contentContainer.append(mfp.content);
        },


        /**
         * Creates Magnific Popup data object based on given data
         * @param  {int} index Index of item to parse
         */
        parseEl: function(index) {
            var item = mfp.items[index],
                type;

            if(item.tagName) {
                item = { el: $(item) };
            } else {
                type = item.type;
                item = { data: item, src: item.src };
            }

            if(item.el) {
                var types = mfp.types;

                // check for 'mfp-TYPE' class
                for(var i = 0; i < types.length; i++) {
                    if( item.el.hasClass('mfp-'+types[i]) ) {
                        type = types[i];
                        break;
                    }
                }

                item.src = item.el.attr('data-mfp-src');
                if(!item.src) {
                    item.src = item.el.attr('href');
                }
            }

            item.type = type || mfp.st.type || 'inline';
            item.index = index;
            item.parsed = true;
            mfp.items[index] = item;
            _mfpTrigger('ElementParse', item);

            return mfp.items[index];
        },


        /**
         * Initializes single popup or a group of popups
         */
        addGroup: function(el, options) {
            var eHandler = function(e) {
                e.mfpEl = this;
                mfp._openClick(e, el, options);
            };

            if(!options) {
                options = {};
            }

            var eName = 'click.magnificPopup';
            options.mainEl = el;

            if(options.items) {
                options.isObj = true;
                el.off(eName).on(eName, eHandler);
            } else {
                options.isObj = false;
                if(options.delegate) {
                    el.off(eName).on(eName, options.delegate , eHandler);
                } else {
                    options.items = el;
                    el.off(eName).on(eName, eHandler);
                }
            }
        },
        _openClick: function(e, el, options) {
            var midClick = options.midClick !== undefined ? options.midClick : $.magnificPopup.defaults.midClick;


            if(!midClick && ( e.which === 2 || e.ctrlKey || e.metaKey || e.altKey || e.shiftKey ) ) {
                return;
            }

            var disableOn = options.disableOn !== undefined ? options.disableOn : $.magnificPopup.defaults.disableOn;

            if(disableOn) {
                if($.isFunction(disableOn)) {
                    if( !disableOn.call(mfp) ) {
                        return true;
                    }
                } else { // else it's number
                    if( _window.width() < disableOn ) {
                        return true;
                    }
                }
            }

            if(e.type) {
                e.preventDefault();

                // This will prevent popup from closing if element is inside and popup is already opened
                if(mfp.isOpen) {
                    e.stopPropagation();
                }
            }

            options.el = $(e.mfpEl);
            if(options.delegate) {
                options.items = el.find(options.delegate);
            }
            mfp.open(options);
        },


        /**
         * Updates text on preloader
         */
        updateStatus: function(status, text) {

            if(mfp.preloader) {
                if(_prevStatus !== status) {
                    mfp.container.removeClass('mfp-s-'+_prevStatus);
                }

                if(!text && status === 'loading') {
                    text = mfp.st.tLoading;
                }

                var data = {
                    status: status,
                    text: text
                };
                // allows to modify status
                _mfpTrigger('UpdateStatus', data);

                status = data.status;
                text = data.text;

                mfp.preloader.html(text);

                mfp.preloader.find('a').on('click', function(e) {
                    e.stopImmediatePropagation();
                });

                mfp.container.addClass('mfp-s-'+status);
                _prevStatus = status;
            }
        },

        _checkIfClose: function(target) {

            if($(target).hasClass(PREVENT_CLOSE_CLASS)) {
                return;
            }

            var closeOnContent = mfp.st.closeOnContentClick;
            var closeOnBg = mfp.st.closeOnBgClick;

            if(closeOnContent && closeOnBg) {
                return true;
            } else {

                // We close the popup if click is on close button or on preloader. Or if there is no content.
                if(!mfp.content || $(target).hasClass('mfp-close') || (mfp.preloader && target === mfp.preloader[0]) ) {
                    return true;
                }

                // if click is outside the content
                if(  (target !== mfp.content[0] && !$.contains(mfp.content[0], target))  ) {
                    if(closeOnBg) {
                        // last check, if the clicked element is in DOM, (in case it's removed onclick)
                        if( $.contains(document, target) ) {
                            return true;
                        }
                    }
                } else if(closeOnContent) {
                    return true;
                }

            }
            return false;
        },
        _addClassToMFP: function(cName) {
            mfp.bgOverlay.addClass(cName);
            mfp.wrap.addClass(cName);
        },
        _removeClassFromMFP: function(cName) {
            this.bgOverlay.removeClass(cName);
            mfp.wrap.removeClass(cName);
        },
        _hasScrollBar: function(winHeight) {
            return (  (mfp.isIE7 ? _document.height() : document.body.scrollHeight) > (winHeight || _window.height()) );
        },
        _setFocus: function() {
            (mfp.st.focus ? mfp.content.find(mfp.st.focus).eq(0) : mfp.wrap).focus();
        },
        _onFocusIn: function(e) {
            if( e.target !== mfp.wrap[0] && !$.contains(mfp.wrap[0], e.target) ) {
                mfp._setFocus();
                return false;
            }
        },
        _parseMarkup: function(template, values, item) {
            var arr;
            if(item.data) {
                values = $.extend(item.data, values);
            }
            _mfpTrigger(MARKUP_PARSE_EVENT, [template, values, item] );

            $.each(values, function(key, value) {
                if(value === undefined || value === false) {
                    return true;
                }
                arr = key.split('_');
                if(arr.length > 1) {
                    var el = template.find(EVENT_NS + '-'+arr[0]);

                    if(el.length > 0) {
                        var attr = arr[1];
                        if(attr === 'replaceWith') {
                            if(el[0] !== value[0]) {
                                el.replaceWith(value);
                            }
                        } else if(attr === 'img') {
                            if(el.is('img')) {
                                el.attr('src', value);
                            } else {
                                el.replaceWith( $('<img>').attr('src', value).attr('class', el.attr('class')) );
                            }
                        } else {
                            el.attr(arr[1], value);
                        }
                    }

                } else {
                    template.find(EVENT_NS + '-'+key).html(value);
                }
            });
        },

        _getScrollbarSize: function() {
            if(mfp.scrollbarSize === undefined) {
                var scrollDiv = document.createElement("div");
                scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
                document.body.appendChild(scrollDiv);
                mfp.scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
                document.body.removeChild(scrollDiv);
            }
            return mfp.scrollbarSize;
        }

    }; /* MagnificPopup core prototype end */




    /**
     * Public static functions
     */
    $.magnificPopup = {
        instance: null,
        proto: MagnificPopup.prototype,
        modules: [],

        open: function(options, index) {
            _checkInstance();

            if(!options) {
                options = {};
            } else {
                options = $.extend(true, {}, options);
            }

            options.isObj = true;
            options.index = index || 0;
            return this.instance.open(options);
        },

        close: function() {
            return $.magnificPopup.instance && $.magnificPopup.instance.close();
        },

        registerModule: function(name, module) {
            if(module.options) {
                $.magnificPopup.defaults[name] = module.options;
            }
            $.extend(this.proto, module.proto);
            this.modules.push(name);
        },

        defaults: {

            disableOn: 0,

            key: null,

            midClick: false,

            mainClass: '',

            preloader: true,

            focus: '',

            closeOnContentClick: false,

            closeOnBgClick: true,

            closeBtnInside: true,

            showCloseBtn: true,

            enableEscapeKey: true,

            modal: false,

            alignTop: false,

            removalDelay: 0,

            prependTo: null,

            fixedContentPos: 'auto',

            fixedBgPos: 'auto',

            overflowY: 'auto',

            closeMarkup: '<button title="%title%" type="button" class="mfp-close">&#215;</button>',

            tClose: 'Close (Esc)',

            tLoading: 'Loading...',

            autoFocusLast: true

        }
    };



    $.fn.magnificPopup = function(options) {
        _checkInstance();

        var jqEl = $(this);

        // We call some API method of first param is a string
        if (typeof options === "string" ) {

            if(options === 'open') {
                var items,
                    itemOpts = _isJQ ? jqEl.data('magnificPopup') : jqEl[0].magnificPopup,
                    index = parseInt(arguments[1], 10) || 0;

                if(itemOpts.items) {
                    items = itemOpts.items[index];
                } else {
                    items = jqEl;
                    if(itemOpts.delegate) {
                        items = items.find(itemOpts.delegate);
                    }
                    items = items.eq( index );
                }
                mfp._openClick({mfpEl:items}, jqEl, itemOpts);
            } else {
                if(mfp.isOpen)
                    mfp[options].apply(mfp, Array.prototype.slice.call(arguments, 1));
            }

        } else {
            // clone options obj
            options = $.extend(true, {}, options);

            if(_isJQ) {
                jqEl.data('magnificPopup', options);
            } else {
                jqEl[0].magnificPopup = options;
            }

            mfp.addGroup(jqEl, options);

        }
        return jqEl;
    };

    /*>>core*/

    /*>>inline*/

    var INLINE_NS = 'inline',
        _hiddenClass,
        _inlinePlaceholder,
        _lastInlineElement,
        _putInlineElementsBack = function() {
            if(_lastInlineElement) {
                _inlinePlaceholder.after( _lastInlineElement.addClass(_hiddenClass) ).detach();
                _lastInlineElement = null;
            }
        };

    $.magnificPopup.registerModule(INLINE_NS, {
        options: {
            hiddenClass: 'hide', // will be appended with `mfp-` prefix
            markup: '',
            tNotFound: 'Content not found'
        },
        proto: {

            initInline: function() {
                mfp.types.push(INLINE_NS);

                _mfpOn(CLOSE_EVENT+'.'+INLINE_NS, function() {
                    _putInlineElementsBack();
                });
            },

            getInline: function(item, template) {

                _putInlineElementsBack();

                if(item.src) {
                    var inlineSt = mfp.st.inline,
                        el = $(item.src);

                    if(el.length) {

                        // If target element has parent - we replace it with placeholder and put it back after popup is closed
                        var parent = el[0].parentNode;
                        if(parent && parent.tagName) {
                            if(!_inlinePlaceholder) {
                                _hiddenClass = inlineSt.hiddenClass;
                                _inlinePlaceholder = _getEl(_hiddenClass);
                                _hiddenClass = 'mfp-'+_hiddenClass;
                            }
                            // replace target inline element with placeholder
                            _lastInlineElement = el.after(_inlinePlaceholder).detach().removeClass(_hiddenClass);
                        }

                        mfp.updateStatus('ready');
                    } else {
                        mfp.updateStatus('error', inlineSt.tNotFound);
                        el = $('<div>');
                    }

                    item.inlineElement = el;
                    return el;
                }

                mfp.updateStatus('ready');
                mfp._parseMarkup(template, {}, item);
                return template;
            }
        }
    });

    /*>>inline*/

    /*>>ajax*/
    var AJAX_NS = 'ajax',
        _ajaxCur,
        _removeAjaxCursor = function() {
            if(_ajaxCur) {
                $(document.body).removeClass(_ajaxCur);
            }
        },
        _destroyAjaxRequest = function() {
            _removeAjaxCursor();
            if(mfp.req) {
                mfp.req.abort();
            }
        };

    $.magnificPopup.registerModule(AJAX_NS, {

        options: {
            settings: null,
            cursor: 'mfp-ajax-cur',
            tError: '<a href="%url%">The content</a> could not be loaded.'
        },

        proto: {
            initAjax: function() {
                mfp.types.push(AJAX_NS);
                _ajaxCur = mfp.st.ajax.cursor;

                _mfpOn(CLOSE_EVENT+'.'+AJAX_NS, _destroyAjaxRequest);
                _mfpOn('BeforeChange.' + AJAX_NS, _destroyAjaxRequest);
            },
            getAjax: function(item) {

                if(_ajaxCur) {
                    $(document.body).addClass(_ajaxCur);
                }

                mfp.updateStatus('loading');

                var opts = $.extend({
                    url: item.src,
                    success: function(data, textStatus, jqXHR) {
                        var temp = {
                            data:data,
                            xhr:jqXHR
                        };

                        _mfpTrigger('ParseAjax', temp);

                        mfp.appendContent( $(temp.data), AJAX_NS );

                        item.finished = true;

                        _removeAjaxCursor();

                        mfp._setFocus();

                        setTimeout(function() {
                            mfp.wrap.addClass(READY_CLASS);
                        }, 16);

                        mfp.updateStatus('ready');

                        _mfpTrigger('AjaxContentAdded');
                    },
                    error: function() {
                        _removeAjaxCursor();
                        item.finished = item.loadError = true;
                        mfp.updateStatus('error', mfp.st.ajax.tError.replace('%url%', item.src));
                    }
                }, mfp.st.ajax.settings);

                mfp.req = $.ajax(opts);

                return '';
            }
        }
    });

    /*>>ajax*/

    /*>>image*/
    var _imgInterval,
        _getTitle = function(item) {
            if(item.data && item.data.title !== undefined)
                return item.data.title;

            var src = mfp.st.image.titleSrc;

            if(src) {
                if($.isFunction(src)) {
                    return src.call(mfp, item);
                } else if(item.el) {
                    return item.el.attr(src) || '';
                }
            }
            return '';
        };

    $.magnificPopup.registerModule('image', {

        options: {
            markup: '<div class="mfp-figure">'+
                '<div class="mfp-close"></div>'+
                '<figure>'+
                '<div class="mfp-img"></div>'+
                '<figcaption>'+
                '<div class="mfp-bottom-bar">'+
                '<div class="mfp-title"></div>'+
                '<div class="mfp-counter"></div>'+
                '</div>'+
                '</figcaption>'+
                '</figure>'+
                '</div>',
            cursor: 'mfp-zoom-out-cur',
            titleSrc: 'title',
            verticalFit: true,
            tError: '<a href="%url%">The image</a> could not be loaded.'
        },

        proto: {
            initImage: function() {
                var imgSt = mfp.st.image,
                    ns = '.image';

                mfp.types.push('image');

                _mfpOn(OPEN_EVENT+ns, function() {
                    if(mfp.currItem.type === 'image' && imgSt.cursor) {
                        $(document.body).addClass(imgSt.cursor);
                    }
                });

                _mfpOn(CLOSE_EVENT+ns, function() {
                    if(imgSt.cursor) {
                        $(document.body).removeClass(imgSt.cursor);
                    }
                    _window.off('resize' + EVENT_NS);
                });

                _mfpOn('Resize'+ns, mfp.resizeImage);
                if(mfp.isLowIE) {
                    _mfpOn('AfterChange', mfp.resizeImage);
                }
            },
            resizeImage: function() {
                var item = mfp.currItem;
                if(!item || !item.img) return;

                if(mfp.st.image.verticalFit) {
                    var decr = 0;
                    // fix box-sizing in ie7/8
                    if(mfp.isLowIE) {
                        decr = parseInt(item.img.css('padding-top'), 10) + parseInt(item.img.css('padding-bottom'),10);
                    }
                    item.img.css('max-height', mfp.wH-decr);
                }
            },
            _onImageHasSize: function(item) {
                if(item.img) {

                    item.hasSize = true;

                    if(_imgInterval) {
                        clearInterval(_imgInterval);
                    }

                    item.isCheckingImgSize = false;

                    _mfpTrigger('ImageHasSize', item);

                    if(item.imgHidden) {
                        if(mfp.content)
                            mfp.content.removeClass('mfp-loading');

                        item.imgHidden = false;
                    }

                }
            },

            /**
             * Function that loops until the image has size to display elements that rely on it asap
             */
            findImageSize: function(item) {

                var counter = 0,
                    img = item.img[0],
                    mfpSetInterval = function(delay) {

                        if(_imgInterval) {
                            clearInterval(_imgInterval);
                        }
                        // decelerating interval that checks for size of an image
                        _imgInterval = setInterval(function() {
                            if(img.naturalWidth > 0) {
                                mfp._onImageHasSize(item);
                                return;
                            }

                            if(counter > 200) {
                                clearInterval(_imgInterval);
                            }

                            counter++;
                            if(counter === 3) {
                                mfpSetInterval(10);
                            } else if(counter === 40) {
                                mfpSetInterval(50);
                            } else if(counter === 100) {
                                mfpSetInterval(500);
                            }
                        }, delay);
                    };

                mfpSetInterval(1);
            },

            getImage: function(item, template) {

                var guard = 0,

                    // image load complete handler
                    onLoadComplete = function() {
                        if(item) {
                            if (item.img[0].complete) {
                                item.img.off('.mfploader');

                                if(item === mfp.currItem){
                                    mfp._onImageHasSize(item);

                                    mfp.updateStatus('ready');
                                }

                                item.hasSize = true;
                                item.loaded = true;

                                _mfpTrigger('ImageLoadComplete');

                            }
                            else {
                                // if image complete check fails 200 times (20 sec), we assume that there was an error.
                                guard++;
                                if(guard < 200) {
                                    setTimeout(onLoadComplete,100);
                                } else {
                                    onLoadError();
                                }
                            }
                        }
                    },

                    // image error handler
                    onLoadError = function() {
                        if(item) {
                            item.img.off('.mfploader');
                            if(item === mfp.currItem){
                                mfp._onImageHasSize(item);
                                mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
                            }

                            item.hasSize = true;
                            item.loaded = true;
                            item.loadError = true;
                        }
                    },
                    imgSt = mfp.st.image;


                var el = template.find('.mfp-img');
                if(el.length) {
                    var img = document.createElement('img');
                    img.className = 'mfp-img';
                    if(item.el && item.el.find('img').length) {
                        img.alt = item.el.find('img').attr('alt');
                    }
                    item.img = $(img).on('load.mfploader', onLoadComplete).on('error.mfploader', onLoadError);
                    img.src = item.src;

                    if(el.is('img')) {
                        item.img = item.img.clone();
                    }

                    img = item.img[0];
                    if(img.naturalWidth > 0) {
                        item.hasSize = true;
                    } else if(!img.width) {
                        item.hasSize = false;
                    }
                }

                mfp._parseMarkup(template, {
                    title: _getTitle(item),
                    img_replaceWith: item.img
                }, item);

                mfp.resizeImage();

                if(item.hasSize) {
                    if(_imgInterval) clearInterval(_imgInterval);

                    if(item.loadError) {
                        template.addClass('mfp-loading');
                        mfp.updateStatus('error', imgSt.tError.replace('%url%', item.src) );
                    } else {
                        template.removeClass('mfp-loading');
                        mfp.updateStatus('ready');
                    }
                    return template;
                }

                mfp.updateStatus('loading');
                item.loading = true;

                if(!item.hasSize) {
                    item.imgHidden = true;
                    template.addClass('mfp-loading');
                    mfp.findImageSize(item);
                }

                return template;
            }
        }
    });

    /*>>image*/

    /*>>zoom*/
    var hasMozTransform,
        getHasMozTransform = function() {
            if(hasMozTransform === undefined) {
                hasMozTransform = document.createElement('p').style.MozTransform !== undefined;
            }
            return hasMozTransform;
        };

    $.magnificPopup.registerModule('zoom', {

        options: {
            enabled: false,
            easing: 'ease-in-out',
            duration: 300,
            opener: function(element) {
                return element.is('img') ? element : element.find('img');
            }
        },

        proto: {

            initZoom: function() {
                var zoomSt = mfp.st.zoom,
                    ns = '.zoom',
                    image;

                if(!zoomSt.enabled || !mfp.supportsTransition) {
                    return;
                }

                var duration = zoomSt.duration,
                    getElToAnimate = function(image) {
                        var newImg = image.clone().removeAttr('style').removeAttr('class').addClass('mfp-animated-image'),
                            transition = 'all '+(zoomSt.duration/1000)+'s ' + zoomSt.easing,
                            cssObj = {
                                position: 'fixed',
                                zIndex: 9999,
                                left: 0,
                                top: 0,
                                '-webkit-backface-visibility': 'hidden'
                            },
                            t = 'transition';

                        cssObj['-webkit-'+t] = cssObj['-moz-'+t] = cssObj['-o-'+t] = cssObj[t] = transition;

                        newImg.css(cssObj);
                        return newImg;
                    },
                    showMainContent = function() {
                        mfp.content.css('visibility', 'visible');
                    },
                    openTimeout,
                    animatedImg;

                _mfpOn('BuildControls'+ns, function() {
                    if(mfp._allowZoom()) {

                        clearTimeout(openTimeout);
                        mfp.content.css('visibility', 'hidden');

                        // Basically, all code below does is clones existing image, puts in on top of the current one and animated it

                        image = mfp._getItemToZoom();

                        if(!image) {
                            showMainContent();
                            return;
                        }

                        animatedImg = getElToAnimate(image);

                        animatedImg.css( mfp._getOffset() );

                        mfp.wrap.append(animatedImg);

                        openTimeout = setTimeout(function() {
                            animatedImg.css( mfp._getOffset( true ) );
                            openTimeout = setTimeout(function() {

                                showMainContent();

                                setTimeout(function() {
                                    animatedImg.remove();
                                    image = animatedImg = null;
                                    _mfpTrigger('ZoomAnimationEnded');
                                }, 16); // avoid blink when switching images

                            }, duration); // this timeout equals animation duration

                        }, 16); // by adding this timeout we avoid short glitch at the beginning of animation


                        // Lots of timeouts...
                    }
                });
                _mfpOn(BEFORE_CLOSE_EVENT+ns, function() {
                    if(mfp._allowZoom()) {

                        clearTimeout(openTimeout);

                        mfp.st.removalDelay = duration;

                        if(!image) {
                            image = mfp._getItemToZoom();
                            if(!image) {
                                return;
                            }
                            animatedImg = getElToAnimate(image);
                        }

                        animatedImg.css( mfp._getOffset(true) );
                        mfp.wrap.append(animatedImg);
                        mfp.content.css('visibility', 'hidden');

                        setTimeout(function() {
                            animatedImg.css( mfp._getOffset() );
                        }, 16);
                    }

                });

                _mfpOn(CLOSE_EVENT+ns, function() {
                    if(mfp._allowZoom()) {
                        showMainContent();
                        if(animatedImg) {
                            animatedImg.remove();
                        }
                        image = null;
                    }
                });
            },

            _allowZoom: function() {
                return mfp.currItem.type === 'image';
            },

            _getItemToZoom: function() {
                if(mfp.currItem.hasSize) {
                    return mfp.currItem.img;
                } else {
                    return false;
                }
            },

            // Get element postion relative to viewport
            _getOffset: function(isLarge) {
                var el;
                if(isLarge) {
                    el = mfp.currItem.img;
                } else {
                    el = mfp.st.zoom.opener(mfp.currItem.el || mfp.currItem);
                }

                var offset = el.offset();
                var paddingTop = parseInt(el.css('padding-top'),10);
                var paddingBottom = parseInt(el.css('padding-bottom'),10);
                offset.top -= ( $(window).scrollTop() - paddingTop );


                /*

      Animating left + top + width/height looks glitchy in Firefox, but perfect in Chrome. And vice-versa.

      */
                var obj = {
                    width: el.width(),
                    // fix Zepto height+padding issue
                    height: (_isJQ ? el.innerHeight() : el[0].offsetHeight) - paddingBottom - paddingTop
                };

                if( getHasMozTransform() ) {
                    obj['-moz-transform'] = obj['transform'] = 'translate(' + offset.left + 'px,' + offset.top + 'px)';
                } else {
                    obj.left = offset.left;
                    obj.top = offset.top;
                }
                return obj;
            }

        }
    });



    /*>>zoom*/

    /*>>iframe*/

    var IFRAME_NS = 'iframe',
        _emptyPage = '//about:blank',

        _fixIframeBugs = function(isShowing) {
            if(mfp.currTemplate[IFRAME_NS]) {
                var el = mfp.currTemplate[IFRAME_NS].find('iframe');
                if(el.length) {
                    // reset src after the popup is closed to avoid "video keeps playing after popup is closed" bug
                    if(!isShowing) {
                        el[0].src = _emptyPage;
                    }

                    // IE8 black screen bug fix
                    if(mfp.isIE8) {
                        el.css('display', isShowing ? 'block' : 'none');
                    }
                }
            }
        };

    $.magnificPopup.registerModule(IFRAME_NS, {

        options: {
            markup: '<div class="mfp-iframe-scaler">'+
                '<div class="mfp-close"></div>'+
                '<iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe>'+
                '</div>',

            srcAction: 'iframe_src',

            patterns: {
                youtube: {
                    index: 'youtube.com',
                    id: 'v=',
                    src: '//www.youtube.com/embed/%id%?autoplay=1'
                },
                vimeo: {
                    index: 'vimeo.com/',
                    id: '/',
                    src: '//player.vimeo.com/video/%id%?autoplay=1'
                },
                gmaps: {
                    index: '//maps.google.',
                    src: '%id%&output=embed'
                }
            }
        },

        proto: {
            initIframe: function() {
                mfp.types.push(IFRAME_NS);

                _mfpOn('BeforeChange', function(e, prevType, newType) {
                    if(prevType !== newType) {
                        if(prevType === IFRAME_NS) {
                            _fixIframeBugs(); // iframe if removed
                        } else if(newType === IFRAME_NS) {
                            _fixIframeBugs(true); // iframe is showing
                        }
                    }
                });

                _mfpOn(CLOSE_EVENT + '.' + IFRAME_NS, function() {
                    _fixIframeBugs();
                });
            },

            getIframe: function(item, template) {
                var embedSrc = item.src;
                var iframeSt = mfp.st.iframe;

                $.each(iframeSt.patterns, function() {
                    if(embedSrc.indexOf( this.index ) > -1) {
                        if(this.id) {
                            if(typeof this.id === 'string') {
                                embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
                            } else {
                                embedSrc = this.id.call( this, embedSrc );
                            }
                        }
                        embedSrc = this.src.replace('%id%', embedSrc );
                        return false;
                    }
                });

                var dataObj = {};
                if(iframeSt.srcAction) {
                    dataObj[iframeSt.srcAction] = embedSrc;
                }
                mfp._parseMarkup(template, dataObj, item);

                mfp.updateStatus('ready');

                return template;
            }
        }
    });



    /*>>iframe*/

    /*>>gallery*/
    /**
     * Get looped index depending on number of slides
     */
    var _getLoopedId = function(index) {
            var numSlides = mfp.items.length;
            if(index > numSlides - 1) {
                return index - numSlides;
            } else  if(index < 0) {
                return numSlides + index;
            }
            return index;
        },
        _replaceCurrTotal = function(text, curr, total) {
            return text.replace(/%curr%/gi, curr + 1).replace(/%total%/gi, total);
        };

    $.magnificPopup.registerModule('gallery', {

        options: {
            enabled: false,
            arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',
            preload: [0,2],
            navigateByImgClick: true,
            arrows: true,

            tPrev: 'Previous (Left arrow key)',
            tNext: 'Next (Right arrow key)',
            tCounter: '%curr% of %total%'
        },

        proto: {
            initGallery: function() {

                var gSt = mfp.st.gallery,
                    ns = '.mfp-gallery';

                mfp.direction = true; // true - next, false - prev

                if(!gSt || !gSt.enabled ) return false;

                _wrapClasses += ' mfp-gallery';

                _mfpOn(OPEN_EVENT+ns, function() {

                    if(gSt.navigateByImgClick) {
                        mfp.wrap.on('click'+ns, '.mfp-img', function() {
                            if(mfp.items.length > 1) {
                                mfp.next();
                                return false;
                            }
                        });
                    }

                    _document.on('keydown'+ns, function(e) {
                        if (e.keyCode === 37) {
                            mfp.prev();
                        } else if (e.keyCode === 39) {
                            mfp.next();
                        }
                    });
                });

                _mfpOn('UpdateStatus'+ns, function(e, data) {
                    if(data.text) {
                        data.text = _replaceCurrTotal(data.text, mfp.currItem.index, mfp.items.length);
                    }
                });

                _mfpOn(MARKUP_PARSE_EVENT+ns, function(e, element, values, item) {
                    var l = mfp.items.length;
                    values.counter = l > 1 ? _replaceCurrTotal(gSt.tCounter, item.index, l) : '';
                });

                _mfpOn('BuildControls' + ns, function() {
                    if(mfp.items.length > 1 && gSt.arrows && !mfp.arrowLeft) {
                        var markup = gSt.arrowMarkup,
                            arrowLeft = mfp.arrowLeft = $( markup.replace(/%title%/gi, gSt.tPrev).replace(/%dir%/gi, 'left') ).addClass(PREVENT_CLOSE_CLASS),
                            arrowRight = mfp.arrowRight = $( markup.replace(/%title%/gi, gSt.tNext).replace(/%dir%/gi, 'right') ).addClass(PREVENT_CLOSE_CLASS);

                        arrowLeft.click(function() {
                            mfp.prev();
                        });
                        arrowRight.click(function() {
                            mfp.next();
                        });

                        mfp.container.append(arrowLeft.add(arrowRight));
                    }
                });

                _mfpOn(CHANGE_EVENT+ns, function() {
                    if(mfp._preloadTimeout) clearTimeout(mfp._preloadTimeout);

                    mfp._preloadTimeout = setTimeout(function() {
                        mfp.preloadNearbyImages();
                        mfp._preloadTimeout = null;
                    }, 16);
                });


                _mfpOn(CLOSE_EVENT+ns, function() {
                    _document.off(ns);
                    mfp.wrap.off('click'+ns);
                    mfp.arrowRight = mfp.arrowLeft = null;
                });

            },
            next: function() {
                mfp.direction = true;
                mfp.index = _getLoopedId(mfp.index + 1);
                mfp.updateItemHTML();
            },
            prev: function() {
                mfp.direction = false;
                mfp.index = _getLoopedId(mfp.index - 1);
                mfp.updateItemHTML();
            },
            goTo: function(newIndex) {
                mfp.direction = (newIndex >= mfp.index);
                mfp.index = newIndex;
                mfp.updateItemHTML();
            },
            preloadNearbyImages: function() {
                var p = mfp.st.gallery.preload,
                    preloadBefore = Math.min(p[0], mfp.items.length),
                    preloadAfter = Math.min(p[1], mfp.items.length),
                    i;

                for(i = 1; i <= (mfp.direction ? preloadAfter : preloadBefore); i++) {
                    mfp._preloadItem(mfp.index+i);
                }
                for(i = 1; i <= (mfp.direction ? preloadBefore : preloadAfter); i++) {
                    mfp._preloadItem(mfp.index-i);
                }
            },
            _preloadItem: function(index) {
                index = _getLoopedId(index);

                if(mfp.items[index].preloaded) {
                    return;
                }

                var item = mfp.items[index];
                if(!item.parsed) {
                    item = mfp.parseEl( index );
                }

                _mfpTrigger('LazyLoad', item);

                if(item.type === 'image') {
                    item.img = $('<img class="mfp-img" />').on('load.mfploader', function() {
                        item.hasSize = true;
                    }).on('error.mfploader', function() {
                        item.hasSize = true;
                        item.loadError = true;
                        _mfpTrigger('LazyLoadError', item);
                    }).attr('src', item.src);
                }


                item.preloaded = true;
            }
        }
    });

    /*>>gallery*/

    /*>>retina*/

    var RETINA_NS = 'retina';

    $.magnificPopup.registerModule(RETINA_NS, {
        options: {
            replaceSrc: function(item) {
                return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
            },
            ratio: 1 // Function or number.  Set to 1 to disable.
        },
        proto: {
            initRetina: function() {
                if(window.devicePixelRatio > 1) {

                    var st = mfp.st.retina,
                        ratio = st.ratio;

                    ratio = !isNaN(ratio) ? ratio : ratio();

                    if(ratio > 1) {
                        _mfpOn('ImageHasSize' + '.' + RETINA_NS, function(e, item) {
                            item.img.css({
                                'max-width': item.img[0].naturalWidth / ratio,
                                'width': '100%'
                            });
                        });
                        _mfpOn('ElementParse' + '.' + RETINA_NS, function(e, item) {
                            item.src = st.replaceSrc(item, ratio);
                        });
                    }
                }

            }
        }
    });

    /*>>retina*/
    _checkInstance(); }));


/*
Counter.js
https://github.com/tombruijn/counter.js

Version: 0.0.3
Copyright (c) 2014 Tom de Bruijn

Counter.js is licensed under the MIT license.
https://github.com/tombruijn/counter.js/LICENSE
*/
!function(){!function($){var Counter,defaults,pluginName;return pluginName="counter",defaults={autoStart:!0,duration:1500,countFrom:void 0,countTo:void 0,runOnce:!1,placeholder:void 0,easing:"easeOutQuad",onStart:function(){},onComplete:function(){},numberFormatter:function(number){return Math.round(number)}},Counter=function(){function Counter(element,options){this.element=element,this.options=$.extend(!0,{},defaults,options),this.init()}return Counter}(),Counter.prototype.init=function(){var givenNumber;if(givenNumber=parseInt(this.element.innerHTML),null==givenNumber||isNaN(givenNumber)||(this.options.countFrom<givenNumber?this.options.countTo=givenNumber:this.options.countFrom=givenNumber),void 0===this.options.countFrom&&(this.options.countFrom=0),void 0===this.options.countTo&&(this.options.countTo=0),null!=this.options.placeholder&&(this.element.innerHTML=this.options.placeholder),this.options.autoStart)return this.start()},Counter.prototype.start=function(){var self;if(this.options.runOnce&&this.runCount()>=1)return!1;if(!this.running)return this.running=!0,this.updateRunCount(),this.options.onStart(),self=this,jQuery({count:this.options.countFrom}).animate({count:this.options.countTo},{duration:this.options.duration,easing:this.options.easing,step:function(){return self.setNumber(this.count)},complete:function(){return self.setNumber(self.options.countTo),self.running=!1,self.options.onComplete()}})},Counter.prototype.updateRunCount=function(){return $(this.element).data("counterRunCount",(this.runCount()||0)+1)},Counter.prototype.runCount=function(){return $(this.element).data("counterRunCount")},Counter.prototype.setNumber=function(number){return this.element.innerHTML=this.options.numberFormatter(number)},$.fn.counter=function(options){var self;return self=this,this.each(function(){var plugin;if(!(plugin=$(this).data("plugin_"+pluginName)))return $(this).data("plugin_"+pluginName,new Counter(this,options));if("string"==typeof options)switch(options){case"start":return plugin.start()}})}}(jQuery)}.call(this);

/* ===========================================================
 *
 *  Name:          selectordie.js
 *  Updated:       2014-10-11
 *  Version:       0.1.8
 *  Created by:    Per V @ Vst.mn
 *  What?:         The Select or Die JS
 *
 *  Copyright (c) 2014 Per Vestman
 *  Dual licensed under the MIT and GPL licenses.
 *
 *  To much comments in the code. Please, I know.
 *
 *  Oddny | Cogs 'n Kegs
 *
 * =========================================================== */

; (function ($) {
    "use strict";

    $.fn.selectOrDie = function (method) {

        var $defaults = {
                customID:          null,      // String  - "" by default - Adds an ID to the SoD
                customClass:       "",        // String  - "" by default - Adds a class to the SoD
                placeholder:       null,      // String  - "" by default - Adds a placeholder that will be shown before a selection has been made
                placeholderOption: false,     // Boolean - false by default - Same as above, but it uses the first option in the <select> as a placeholder (and hides it from the list)
                prefix:            null,      // String  - "" by default - Adds a prefix that always will be shown before the selected value
                cycle:             false,     // Boolean  - false by default - Should keyboard cycle through options or not?
                stripEmpty:        false,     // Boolean  - false by default - Should empty <option>'s be stripped from the <select>
                links:             false,     // Boolean  - false by default - Should the options be treated as links?
                linksExternal:     false,     // Boolean  - false by default - Should the options be treated as links and open in a new window/tab?
                size:              0,         // Integer  - 0 by default - The value set equals the amount of items before scroll is needed
                tabIndex:          0,         // integer  - 0 by default
                onChange:          $.noop     // Adds a callback function for when the SoD gets changed
            },
            $_settings = {},
            $_sodKeysWhenClosed = false,
            $_sodFilterTimeout, $_sodViewportTimeout;

        var _private = {

            initSoD: function (options) {
                $_settings = $.extend({}, $defaults, options);

                return this.each(function () {

                    if ( !$(this).parent().hasClass("sod_select") ) {
                        var $select                    = $(this),
                            $settingsId                = $select.data("custom-id") ? $select.data("custom-id") : $_settings.customID,
                            $settingsClass             = $select.data("custom-class") ? $select.data("custom-class") : $_settings.customClass,
                            $settingsPrefix            = $select.data("prefix") ? $select.data("prefix") : $_settings.prefix,
                            $settingsPlaceholder       = $select.data("placeholder") ? $select.data("placeholder") : $_settings.placeholder,
                            $settingsPlaceholderOption = $select.data("placeholder-option") ? $select.data("placeholder-option") : $_settings.placeholderOption,
                            $settingsCycle             = $select.data("cycle") ? $select.data("cycle") : $_settings.cycle,
                            $settingsLinks             = $select.data("links") ? $select.data("links") : $_settings.links,
                            $settingsLinksExternal     = $select.data("links-external") ? $select.data("links-external") : $_settings.linksExternal,
                            $settingsSize              = parseInt($select.data("size")) ? $select.data("size") : $_settings.size,
                            $settingsTabIndex          = parseInt($select.data("tabindex")) ? $select.data("tabindex") : ( $_settings.tabIndex ? $_settings.tabIndex : ( $select.attr("tabindex") ? $select.attr("tabindex") : $_settings.tabIndex ) ),
                            $settingsStripEmpty        = $select.data("strip-empty") ? $select.data("strip-empty") : $_settings.stripEmpty,
                            $selectTitle               = $select.prop("title") ? $select.prop("title") : null,
                            $selectDisabled            = $select.is(":disabled") ? " disabled" : "",
                            $sodPrefix                 = "",
                            $sodHtml                   = "",
                            $sodHeight                 = 0,
                            $sod, $sodListWrapper, $sodList;

                        // If there's a prefix defined
                        if ( $settingsPrefix ) {
                            $sodPrefix = "<span class=\"sod_prefix\">" + $settingsPrefix + "</span> ";
                        }

                        // If there's a placeholder defined
                        if ( $settingsPlaceholder && !$settingsPrefix ) {
                            $sodHtml += "<span class=\"sod_label sod_placeholder\">" + $settingsPlaceholder + "</span>";
                        }
                        else {
                            $sodHtml += "<span class=\"sod_label\">" + $sodPrefix + "</span>";
                        }

                        // Inserts a new element that will act like our new <select>
                        $sod = $("<span/>", {
                            id:                        $settingsId,
                            "class":                   "sod_select " + $settingsClass + $selectDisabled,
                            title:                     $selectTitle,
                            tabindex:                  $settingsTabIndex,
                            html:                      $sodHtml,
                            "data-cycle":              $settingsCycle,
                            "data-links":              $settingsLinks,
                            "data-links-external":     $settingsLinksExternal,
                            "data-placeholder":        $settingsPlaceholder,
                            "data-placeholder-option": $settingsPlaceholderOption,
                            "data-prefix":             $settingsPrefix,
                            "data-filter":             ""
                        }).insertAfter( this );

                        // If it's a touch device
                        if ( _private.isTouch() ) {
                            $sod.addClass("touch");
                        }

                        // Add a wrapper for the option list
                        $sodListWrapper = $("<span/>", {
                            "class": "sod_list_wrapper"
                        }).appendTo($sod);

                        // Inserts a <span> into our wrapper created above. It will host our <option>:s
                        $sodList = $("<span/>", {
                            "class": "sod_list"
                        }).appendTo($sodListWrapper);

                        // Inserts an option <span> for each <option>
                        $("option, optgroup", $select).each(function (i) {
                            var $this = $(this);

                            if ( $settingsStripEmpty && !$.trim($this.text()) ) {
                                $this.remove();
                            } else if ( i === 0 && $settingsPlaceholderOption && !$sodPrefix )
                                _private.populateSoD($this, $sodList, $sod, true);
                            else {
                                _private.populateSoD($this, $sodList, $sod, false);
                            }
                        });

                        // If the setting size is set, then add a max-height to the SoD
                        if ( $settingsSize ) {
                            // Show the SoD options
                            $sodListWrapper.show();

                            // Calculate a max-height
                            $(".sod_option:lt(" + $settingsSize + ")", $sodList).each(function () {
                                $sodHeight += $(this).outerHeight();
                            });

                            // Hide the SoD list wrapper and set a "max-height" to the list itself
                            $sodListWrapper.removeAttr("style");
                            $sodList.css({"max-height": $sodHeight });
                        }

                        // Move the <select> into the SoD element
                        $select.appendTo( $sod );

                        // Bind events to the SoD
                        $sod.on("focusin", _private.focusSod)
                            .on("click", _private.triggerSod)
                            .on("click", ".sod_option", _private.optionClick)
                            .on("mousemove", ".sod_option", _private.optionHover)
                            .on("keydown", _private.keyboardUse);

                        // Bind change event to the <select>
                        $select.on("change", _private.selectChange);

                        // When a label for the native select is clicked we want to focus the SoD
                        $(document).on("click", "label[for='" + $select.attr("id") + "']", function(e) {
                            e.preventDefault();
                            $sod.focus();
                        });
                    }
                    else {
                        console.log("Select or Die: It looks like the SoD already exists");
                    }

                });
            }, // initSoD


            populateSoD: function ($option, $sodList, $sod, $isPlaceholder) {
                var $sodPlaceholder       = $sod.data("placeholder"),
                    $sodPlaceholderOption = $sod.data("placeholder-option"),
                    $sodPrefix            = $sod.data("prefix"),
                    $sodLabel             = $sod.find(".sod_label"),
                    $optionParent         = $option.parent(),
                    $optionText           = $option.text(),
                    $optionValue          = $option.val(),
                    $optionCustomId       = $option.data("custom-id") ? $option.data("custom-id") : null,
                    $optionCustomClass    = $option.data("custom-class") ? $option.data("custom-class") : "",
                    $optionIsDisabled     = $option.is(":disabled") ? " disabled " : "",
                    $optionIsSelected     = $option.is(":selected") ? " selected active " : "",
                    $optionLink           = $option.data("link") ? " link " : "",
                    $optionLinkExternal   = $option.data("link-external") ? " linkexternal" : "",
                    $optgroupLabel        = $option.prop("label");

                // Create <li> for each <option>
                if ( $option.is("option") ) { // If <option>
                    $("<span/>", {
                        "class":      "sod_option " + $optionCustomClass + $optionIsDisabled + $optionIsSelected + $optionLink + $optionLinkExternal,
                        id:           $optionCustomId,
                        title:        $optionText,
                        html:         $optionText,
                        "data-value": $optionValue
                    }).appendTo( $sodList );

                    // Set the SoD data-label (used in the blur event)
                    if ( $isPlaceholder && !$sodPrefix ) { // Various things if the first option should be used as a placeholder
                        $sod.data("label", $optionText);
                        $sod.data("placeholder", $optionText);
                        $option.prop("disabled", true);
                        $sodList.find(".sod_option:last").addClass("is-placeholder disabled");

                        if ( $optionIsSelected ) {
                            $sodLabel.addClass("sod_placeholder");
                        }
                    }
                    else if ( $optionIsSelected && $sodPlaceholder && !$sodPlaceholderOption && !$sodPrefix ) { // If the option is selected and the placeholder option is used
                        $sod.data("label", $sodPlaceholder);
                    }
                    else if ( $optionIsSelected ) { // If the option is selected
                        $sod.data("label", $optionText);
                    }

                    // If selected and no placeholder is set, update label,
                    // added in v.0.1.8: if the placeholder-option is set we'll update the label
                    if ( $optionIsSelected && !$sodPlaceholder || $optionIsSelected && $sodPlaceholderOption || $optionIsSelected && $sodPrefix ) {
                        $sodLabel.append($optionText);
                    }

                    // If child of an <optgroup>
                    if ( $optionParent.is("optgroup") ) {
                        $sodList.find(".sod_option:last").addClass("groupchild");

                        // If <optgroup> disabled
                        if ( $optionParent.is(":disabled") ) {
                            $sodList.find(".sod_option:last").addClass("disabled");
                        }
                    }
                }
                else { // If <<optgroup>
                    $("<span/>", {
                        "class":      "sod_option optgroup " + $optionIsDisabled,
                        title:        $optgroupLabel,
                        html:         $optgroupLabel,
                        "data-label": $optgroupLabel
                    }).appendTo( $sodList );
                }
            }, // populateSoD


            focusSod: function () {
                var $sod = $(this);

                // If not disabled we'll add focus (and blur other active SoD's)
                if ( !$sod.hasClass("disabled") ) {
                    _private.blurSod($(".sod_select.focus").not($sod));
                    $sod.addClass("focus");

                    // Blur the SoD when clicking outside it
                    $("html").on("click.sodBlur", function() {
                        _private.blurSod($sod);
                    });
                }
                else {
                    _private.blurSod($sod);
                }
            }, // focusSod


            triggerSod: function (e) {
                e.stopPropagation();

                var $sod            = $(this),
                    $sodList        = $sod.find(".sod_list"),
                    $sodPlaceholder = $sod.data("placeholder"),
                    $optionActive   = $sod.find(".active"),
                    $optionSelected = $sod.find(".selected");

                // Trigger the SoD if it's not disabled, already open or a touch device
                if ( !$sod.hasClass("disabled") && !$sod.hasClass("open") && !$sod.hasClass("touch") ) {
                    // Add the .open class to display list
                    $sod.addClass("open");

                    // If a placeholder is set, then show it
                    if ( $sodPlaceholder && !$sod.data("prefix") ) {
                        $sod.find(".sod_label").addClass("sod_placeholder").html($sodPlaceholder);
                    }

                    // Scroll list to selected item
                    _private.listScroll($sodList, $optionSelected);

                    // Check if the option list fits in the viewport
                    _private.checkViewport($sod, $sodList);
                }
                else {
                    // Clears viewport check timeout
                    clearTimeout($_sodViewportTimeout);
                    $sod.removeClass("open");

                    // If a placeholder is set, make sure the placeholder text is removed if
                    // the user toggles the select using his mouse
                    if ( $sodPlaceholder ) {
                        $sod.find(".sod_label").get(0).lastChild.nodeValue = $optionActive.text();
                    }
                }
            }, // triggerSod


            keyboardUse: function (e) {
                var $sod            = $(this),
                    $sodList        = $sod.find(".sod_list"),
                    $sodOptions     = $sod.find(".sod_option"),
                    $sodLabel       = $sod.find(".sod_label"),
                    $sodCycle       = $sod.data("cycle"),
                    $optionActive   = $sodOptions.filter(".active"),
                    $sodFilterHit, $optionNext, $optionCycle;

                // Highlight prev/next element if up/down key pressed
                if ( e.which > 36 && e.which < 41 ) {

                    // Set $optionNext and $optionCycle
                    if ( e.which === 37 || e.which === 38 ) { // Left/Up key
                        $optionNext  = $optionActive.prevAll(":not('.disabled, .optgroup')").first();
                        $optionCycle = $sodOptions.not(".disabled, .optgroup").last();
                    }
                    else if ( e.which === 39 || e.which === 40 ) { // Right/Down key
                        $optionNext  = $optionActive.nextAll(":not('.disabled, .optgroup')").first();
                        $optionCycle = $sodOptions.not(".disabled, .optgroup").first();
                    }

                    // If there's no option before/after and cycle is enabled
                    if ( !$optionNext.hasClass("sod_option") && $sodCycle ) {
                        $optionNext = $optionCycle;
                    }

                    // Add .active to the next option, update the label and scroll the list
                    if ( $optionNext.hasClass("sod_option") || $sodCycle ) {
                        $optionActive.removeClass("active");
                        $optionNext.addClass("active");
                        $sodLabel.get(0).lastChild.nodeValue = $optionNext.text();
                        _private.listScroll($sodList, $optionNext);

                        // If the user used his keys when the SoD was closed we'll
                        // update the $_sodKeysWhenClosed flag that we use in blurSod()
                        if ( !$sod.hasClass("open") ) {
                            $_sodKeysWhenClosed = true;
                        }

                    }

                    // Disables the up/down keys from scrolling the page
                    return false;
                }
                else if ( e.which === 13 || (e.which === 32 && $sod.hasClass("open") && ($sod.data("filter")[0] === ' ' || $sod.data("filter") === "") ) ) { // Enter key or space, simulate click() function
                    e.preventDefault();
                    $optionActive.click();
                }
                else if ( e.which === 32 && !$sod.hasClass("open") && ($sod.data("filter")[0] === ' ' || $sod.data("filter") === "") ) { // Space bar, Opens the SoD if already closed
                    e.preventDefault();
                    $_sodKeysWhenClosed = false;
                    $sod.click();
                }
                else if ( e.which === 27 ) { // Esc key, blur the SoD
                    _private.blurSod($sod);
                }

                // "Filter" options list using keybaord based input
                if ( e.which !== 0) {
                    // Clears data-filter timeout
                    clearTimeout($_sodFilterTimeout);

                    // Append the data-filter with typed character
                    $sod.data("filter", $sod.data("filter") + String.fromCharCode(e.which));

                    // Check for matches of the typed string
                    $sodFilterHit = $sodOptions.filter(function() {
                        return $(this).text().toLowerCase().indexOf($sod.data("filter").toLowerCase()) === 0;
                    }).not(".disabled, .optgroup").first();

                    // If the typed value is a hit, then set it to active
                    if ( $sodFilterHit.length ) {
                        $optionActive.removeClass("active");
                        $sodFilterHit.addClass("active");
                        _private.listScroll($sodList, $sodFilterHit);
                        $sodLabel.get(0).lastChild.nodeValue = $sodFilterHit.text();

                        if ( !$sod.hasClass("open") ) {
                            $_sodKeysWhenClosed = true;
                        }
                    }

                    // Set a timeout to empty the data-filter
                    $_sodFilterTimeout = setTimeout( function() {
                        $sod.data("filter", "");
                    }, 500);
                }
            }, // keyboardUse


            optionHover: function () {
                var $option = $(this);

                // Mousemove event on option to make the SoD behave just like a native select
                if ( !$option.hasClass("disabled") && !$option.hasClass("optgroup") ) {
                    $option.siblings().removeClass("active").end().addClass("active");
                }
            }, // optionHover


            optionClick: function (e) {
                e.stopPropagation();

                var $clicked        = $(this),
                    $sod            = $clicked.closest(".sod_select"),
                    $optionDisabled = $clicked.hasClass("disabled"),
                    $optionOptgroup = $clicked.hasClass("optgroup"),
                    $optionIndex    = $sod.find(".sod_option:not('.optgroup')").index(this);

                if ( $sod.hasClass("touch") ) {
                    return;
                }

                // If not disabled or optgroup
                if ( !$optionDisabled && !$optionOptgroup ) {
                    $sod.find(".selected, .sod_placeholder").removeClass("selected sod_placeholder");
                    $clicked.addClass("selected");
                    $sod.find("select option")[$optionIndex].selected = true;
                    $sod.find("select").change();
                }

                // Clear viewport check timeout
                clearTimeout($_sodViewportTimeout);

                // Hide the list
                $sod.removeClass("open");
            }, // optionClick


            selectChange: function () {
                var $select         = $(this),
                    $optionSelected = $select.find(":selected"),
                    $optionText     = $optionSelected.text(),
                    $sod            = $select.closest(".sod_select");

                $sod.find(".sod_label").get(0).lastChild.nodeValue = $optionText;
                $sod.data("label", $optionText);

                // Triggers the onChange callback
                $_settings.onChange.call(this);

                // If $_settings.links, send the user to the URL
                if ( ($sod.data("links") || $optionSelected.data("link")) && !$optionSelected.data("link-external") ) {
                    window.location.href = $optionSelected.val();
                }
                else if ( $sod.data("links-external") || $optionSelected.data("link-external") ) {
                    window.open($optionSelected.val(),"_blank");
                }
            }, // selectChange


            blurSod: function ($sod) {
                if ( $("body").find($sod).length ) {
                    var $sodLabel         = $sod.data("label"),
                        $sodPlaceholder   = $sod.data("placeholder"),
                        $optionActive     = $sod.find(".active"),
                        $optionSelected   = $sod.find(".selected"),
                        $optionHasChanged = false;

                    // Clear viewport check timeout
                    clearTimeout($_sodViewportTimeout);

                    // Check the $sod for changes. If the user has used his keys when the SoD was closed
                    // we'll set the currently active option to selected. If the user used his keys when
                    // the SoD was open but did NOT make a selection, then we'll restore the SoD
                    if ( $_sodKeysWhenClosed && !$optionActive.hasClass("selected") ) {
                        $optionActive.click();
                        $optionHasChanged = true;
                    }
                    else if ( !$optionActive.hasClass("selected") ) {
                        $optionActive.removeClass("active");
                        $optionSelected.addClass("active");
                    }

                    if ( !$optionHasChanged && $sodPlaceholder ) {
                        $sod.find(".sod_label").get(0).lastChild.nodeValue = $optionSelected.text();
                    } else if ( !$optionHasChanged ) {
                        $sod.find(".sod_label").get(0).lastChild.nodeValue = $sodLabel;
                    }

                    // Reset the flag indicating whether the user has used his arrow keys when the SoD
                    // was closed or not
                    $_sodKeysWhenClosed = false;

                    // Remove open/focus class
                    $sod.removeClass("open focus");

                    // Blur the SOD
                    $sod.blur();

                    // Unbind the
                    $("html").off(".sodBlur");
                }
            }, // blurSod


            checkViewport: function ($sod, $sodList) {
                var $sodPosition   = $sod[0].getBoundingClientRect(),
                    $sodListHeight = $sodList.outerHeight();

                // If the list is below the viewport AND fits above, then show it above
                if ( ($sodPosition.bottom + $sodListHeight + 10) > $(window).height() && ($sodPosition.top - $sodListHeight) > 10 ) {
                    $sod.addClass("above");
                }
                else {
                    $sod.removeClass("above");
                }

                // This was fun, lets do it again and again.
                $_sodViewportTimeout = setTimeout( function() {
                    _private.checkViewport($sod, $sodList);
                }, 200);
            }, // checkViewport


            listScroll: function ($sodList, $option) {
                var $scrollList   = $sodList[0].getBoundingClientRect(), // getBoundingClientRect FTW!
                    $scrollOption = $option[0].getBoundingClientRect();

                // Scroll list up and down
                if ( $scrollList.top > $scrollOption.top ) {
                    $sodList.scrollTop($sodList.scrollTop() - $scrollList.top + $scrollOption.top);
                } else if ( $scrollList.bottom < $scrollOption.bottom ) {
                    $sodList.scrollTop($sodList.scrollTop() - $scrollList.bottom + $scrollOption.bottom);
                }
            }, // listScroll


            isTouch: function () {
                return (("ontouchstart" in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));
            } // isTouch

        };

        var methods = {

            destroy: function () {
                return this.each(function () {
                    var $select = $(this),
                        $sod    = $select.parent();

                    // Destroy the SoD
                    if ( $sod.hasClass("sod_select") ) {
                        // Unbind the change event on the real <select>
                        $select.off("change");

                        // Restore DOM
                        $sod.find("span").remove();
                        $select.unwrap();
                    } else {
                        console.log("Select or Die: There's no SoD to destroy");
                    }
                });
            }, // destroy


            update: function () {
                return this.each(function () {
                    var $select  = $(this),
                        $sod     = $select.parent(),
                        $sodList = $sod.find(".sod_list:first");

                    // Check for the SoD
                    if ( $sod.hasClass("sod_select") ) {
                        // Empty current list of options in faux <select>
                        $sodList.empty();

                        // Clear the label (but keep prefix)
                        $sod.find(".sod_label").get(0).lastChild.nodeValue = "";

                        // Disable the SoD if the select is disabled
                        if ( $select.is(":disabled") ) {
                            $sod.addClass("disabled");
                        }

                        // Inserts a <span class="sod_option"> for each <option>
                        $("option, optgroup", $select).each(function () {
                            _private.populateSoD($(this), $sodList, $sod);
                        });
                    } else {
                        console.log("Select or Die: There's no SoD to update");
                    }
                });

            }, // update


            disable: function ($value) {
                return this.each(function () {
                    var $select = $(this),
                        $sod    = $select.parent();

                    // Check for the SoD
                    if ( $sod.hasClass("sod_select") ) {
                        if ( typeof $value !== "undefined" ) { // Disable option/optgroup

                            // Disables the option (and possible children if optgroup) in the SoD
                            $sod.find(".sod_list:first .sod_option[data-value='" + $value + "']").addClass("disabled");
                            $sod.find(".sod_list:first .sod_option[data-label='" + $value + "']").nextUntil(":not(.groupchild)").addClass("disabled");

                            // Disables the option/optgroup in the real <select>
                            $("option[value='" + $value + "'], optgroup[label='" + $value + "']", this).prop("disabled", true);

                        } else if ( $sod.hasClass("sod_select") ) { // Disable select/SoD
                            $sod.addClass("disabled");
                            $select.prop("disabled", true);
                        }
                    } else {
                        console.log("Select or Die: There's no SoD to disable");
                    }
                });
            }, // disable

            enable: function ($value) {
                return this.each(function () {
                    var $select = $(this),
                        $sod    = $select.parent();

                    // Check for the SoD
                    if ( $sod.hasClass("sod_select") ) {
                        if ( typeof $value !== "undefined" ) { // Enable option/optgroup

                            // Enables the option (and possible children if optgroup) in the SoD
                            $sod.find(".sod_list:first .sod_option[data-value='" + $value + "']").removeClass("disabled");
                            $sod.find(".sod_list:first .sod_option[data-label='" + $value + "']").nextUntil(":not(.groupchild)").removeClass("disabled");

                            // Enables the option in the real <select>
                            $("option[value='" + $value + "'], optgroup[label='" + $value + "']", this).prop("disabled", false);

                        } else if ( $sod.hasClass("sod_select") ) { // Enable select/SoD
                            $sod.removeClass("disabled");
                            $select.prop("disabled", false);
                        }
                    } else {
                        console.log("Select or Die: There's no SoD to enable");
                    }
                });
            } // enable

        };

        if ( methods[method] ) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if ( typeof method === "object" || !method ) {
            return _private.initSoD.apply(this, arguments);
        } else {
            $.error("Select or Die: Oh no! No such method \"" + method + "\" for the SoD instance");
        }
    };

})(jQuery);


//VISUAL COMPOSER SCRIPTS------------------------------------------

document.documentElement.className += ' js_active ';
document.documentElement.className += 'ontouchstart' in document.documentElement ? ' vc_mobile ' : ' vc_desktop ';
(function () {
    var prefix = ['-webkit-', '-o-', '-moz-', '-ms-', ""];
    for (var i in prefix) {
        if (prefix[i] + 'transform' in document.documentElement.style) document.documentElement.className += " vc_transform ";
    }
})();

/*
 On document ready jQuery will fire set of functions.
 If you want to override function behavior then copy it to your theme js file
 with the same name.
 */

jQuery(window).load(function () {

});
var vc_js = function () {
    vc_twitterBehaviour();
    vc_toggleBehaviour();
    vc_tabsBehaviour();
    vc_accordionBehaviour();
    vc_teaserGrid();
    vc_carouselBehaviour();
    vc_slidersBehaviour();
    vc_prettyPhoto();
    vc_googleplus();
    vc_pinterest();
    vc_progress_bar();
    vc_plugin_flexslider();
    vc_google_fonts();
    window.setTimeout(vc_waypoints, 1500);
};

if (typeof window['vc_plugin_flexslider'] !== 'function') {
    function vc_plugin_flexslider($parent) {
        var $slider = $parent ? $parent.find('.wpb_flexslider') : jQuery('.wpb_flexslider');
        $slider.each(function () {
            var this_element = jQuery(this);
            var sliderSpeed = 800,
                sliderTimeout = parseInt(this_element.attr('data-interval')) * 1000,
                sliderFx = this_element.attr('data-flex_fx'),
                slideshow = true;
            if (sliderTimeout == 0) slideshow = false;

            this_element.is(':visible') && this_element.flexslider({
                animation:sliderFx,
                slideshow:slideshow,
                slideshowSpeed:sliderTimeout,
                sliderSpeed:sliderSpeed,
                smoothHeight:true
            });
        });
    }
}

/* Twitter
---------------------------------------------------------- */
if (typeof window['vc_twitterBehaviour'] !== 'function') {
    function vc_twitterBehaviour() {
        jQuery('.wpb_twitter_widget .tweets').each(function (index) {
            var this_element = jQuery(this),
                tw_name = this_element.attr('data-tw_name');
            tw_count = this_element.attr('data-tw_count');

            this_element.tweet({
                username:tw_name,
                join_text:"auto",
                avatar_size:0,
                count:tw_count,
                template:"{avatar}{join}{text}{time}",
                auto_join_text_default:"",
                auto_join_text_ed:"",
                auto_join_text_ing:"",
                auto_join_text_reply:"",
                auto_join_text_url:"",
                loading_text:'<span class="loading_tweets">loading tweets...</span>'
            });
        });
    }
}

/* Google plus
---------------------------------------------------------- */
if (typeof window['vc_googleplus'] !== 'function') {
    function vc_googleplus() {
        if (jQuery('.wpb_googleplus').length > 0) {
            (function () {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();
        }
    }
}

/* Pinterest
---------------------------------------------------------- */
if (typeof window['vc_pinterest'] !== 'function') {
    function vc_pinterest() {
        if (jQuery('.wpb_pinterest').length > 0) {
            (function () {
                var po = document.createElement('script');
                po.type = 'text/javascript';
                po.async = true;
                po.src = 'https://assets.pinterest.com/js/pinit.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(po, s);
            })();
        }
    }
}

//Vc601
//No anims when using frontend editor
if (jQuery('body').hasClass('compose-mode')) {
    jQuery('.wpb_animate_when_almost_visible').removeClass('wpb_animate_when_almost_visible');
    //THEME COUNTER
    jQuery('.hook_counter').each(function() {
        var $this_el=jQuery(this);
        if ($this_el.attr('data-thousands')===undefined) {
            $this_el.attr('data-thousands','');
        }
        $this_el.counter({
            autoStart: true,
            duration: parseInt($this_el.attr('data-duration'),10), // milliseconds, default: 1500
            countFrom: $this_el.attr('data-origin'),// start counting at this number, default: 0
            countTo: $this_el.attr('data-counter'),// count to this number, default: 0
            runOnce: true,// only run the counter once, default: false
            placeholder: "", // replace the number with this before counting,
            easing: "easeOutCubic", // easing effects
            onStart: function() {}, // callback on start of the counting
            onComplete: function() {}, // callback on completion of the counting
            numberFormatter: // function used to format the displayed numbers.
                function(number) {
                    //return $this_el.attr('data-prefix')+Math.ceil(number)+$this_el.attr('data-suffix');
                    return $this_el.attr('data-prefix')+numberWithCommas(Math.ceil(number),$this_el.attr('data-thousands'))+$this_el.attr('data-suffix');
                }
        });
    });
    jQuery('.vc_progress_bar').find('.vc_single_bar').each(function() {
        var $this = jQuery(this),
            bar = $this.find('.vc_bar'),
            val = bar.data('percentage-value');
        $this.css({'opacity':'1'});
        bar.css({"width" : val+'%'});
    });
}

/* Progress bar
---------------------------------------------------------- */
if (typeof window['vc_progress_bar'] !== 'function') {
    function vc_progress_bar() {
        if (typeof jQuery.fn.waypoint !== 'undefined') {
            //NO ANIMS ON MOBILE
            if (is_mobile() && theme_options.css_enable!=="1") {
                jQuery('.vc_progress_bar').find('.vc_single_bar').each(function() {
                    var $this = jQuery(this),
                        bar = $this.find('.vc_bar'),
                        val = bar.data('percentage-value');
                    $this.css({'opacity':'1'});
                    bar.css({"width" : val+'%'});
                });
            }
            else {
                jQuery('.vc_progress_bar').find('.vc_single_bar').each(function(index) {
                    var $this = jQuery(this),
                        bar = $this.find('.vc_bar'),
                        val = bar.data('percentage-value');
                    jQuery('.vc_progress_bar').waypoint(function() {
                            setTimeout(function() {
                                    $this.css({'opacity':'1'});
                                    bar.css({"width" : val+'%'}); },
                                index*200);
                        },
                        {
                            offset: '95%'
                        });
                });
            }
        }
    }
}

function numberWithCommas (x,separator) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, separator);
}

/* Waypoints magic
---------------------------------------------------------- */
if ( typeof window['vc_waypoints'] !== 'function' ) {
    function vc_waypoints() {
        if (typeof jQuery.fn.waypoint !== 'undefined') {
            //NO ANIMS ON MOBILE
            if (is_mobile() && theme_options.css_enable!=="1") {
                jQuery('.wpb_animate_when_almost_visible').removeClass('wpb_animate_when_almost_visible');
                //THEME COUNTER
                jQuery('.hook_counter').each(function() {
                    var $this_el=jQuery(this);
                    if ($this_el.attr('data-thousands')===undefined) {
                        $this_el.attr('data-thousands','');
                    }
                    $this_el.counter({
                        autoStart: true,
                        duration: parseInt($this_el.attr('data-duration'),10), // milliseconds, default: 1500
                        countFrom: $this_el.attr('data-origin'),// start counting at this number, default: 0
                        countTo: $this_el.attr('data-counter'),// count to this number, default: 0
                        runOnce: true,// only run the counter once, default: false
                        placeholder: "", // replace the number with this before counting,
                        easing: "easeOutCubic", // easing effects
                        onStart: function() {}, // callback on start of the counting
                        onComplete: function() {}, // callback on completion of the counting
                        numberFormatter: // function used to format the displayed numbers.
                            function(number) {
                                //return $this_el.attr('data-prefix')+Math.ceil(number)+$this_el.attr('data-suffix');
                                return $this_el.attr('data-prefix')+numberWithCommas(Math.ceil(number),$this_el.attr('data-thousands'))+$this_el.attr('data-suffix');
                            }
                    });
                });
            }
            else {
                jQuery('.wpb_animate_when_almost_visible:not(.wpb_start_animation,.hook_manual_anim)').each(function() {
                    var $this_el=jQuery(this);
                    if($this_el.attr('id')===undefined) {
                        $this_el.attr('id','wayp-'+Math.floor(Math.random() * 10000));
                    }
                    $this_el.waypoint(function() {
                        if (!$this_el.is('[class*="delay-"]')) {
                            setTimeout(function() {
                                $this_el.addClass('wpb_start_animation');
                            },parseInt(delayer,10)+300);
                        }
                        else {
                            var classes = $this_el.attr("class").split(" ");
                            var delayer=0;
                            for (var i = 0; i < classes.length; i++) {
                                if ( classes[i].substr(0,6) === "delay-" ) {
                                    delayer=classes[i].substr(6,classes[i].length);
                                    break;
                                }
                            }
                            setTimeout(function() {
                                $this_el.addClass('wpb_start_animation');
                            },parseInt(delayer,10)+100);
                        }
                    }, { offset: '90%' });
                });
//THEME COUNTER
                jQuery('.hook_counter').each(function() {
                    var $this_el=jQuery(this);
                    if ($this_el.attr('data-thousands')===undefined) {
                        $this_el.attr('data-thousands','');
                    }
                    $this_el.waypoint(function() {
                        $this_el.counter({
                            autoStart: true,
                            duration: parseInt($this_el.attr('data-duration'),10), // milliseconds, default: 1500
                            countFrom: $this_el.attr('data-origin'),// start counting at this number, default: 0
                            countTo: $this_el.attr('data-counter'),// count to this number, default: 0
                            runOnce: true,// only run the counter once, default: false
                            placeholder: "", // replace the number with this before counting,
                            easing: "easeOutCubic", // easing effects
                            onStart: function() {}, // callback on start of the counting
                            onComplete: function() {}, // callback on completion of the counting
                            numberFormatter: // function used to format the displayed numbers.
                                function(number) {
                                    return $this_el.attr('data-prefix')+numberWithCommas(Math.ceil(number),$this_el.attr('data-thousands'))+$this_el.attr('data-suffix');
                                }
                        });
                    }, { offset: '85%' });
                });
            }
        }
    }
}

/* Toggle
---------------------------------------------------------- */
if (typeof window['vc_toggleBehaviour'] !== 'function') {
    function vc_toggleBehaviour() {
        jQuery(".wpb_toggle").unbind('click').click(function (e) {
            if (jQuery(this).next().is(':animated')) {
                return false;
            }
            if (jQuery(this).hasClass('wpb_toggle_title_active')) {
                jQuery(this).removeClass('wpb_toggle_title_active').next().slideUp(500);
            } else {
                jQuery(this).addClass('wpb_toggle_title_active').next().slideDown(500);
            }
        });
        jQuery('.wpb_toggle_content').each(function (index) {
            if (jQuery(this).next().is('h4.wpb_toggle') == false) {
                jQuery('<div class="last_toggle_el_margin"></div>').insertAfter(this);
            }
        });
    }
}

/* Tabs + Tours
---------------------------------------------------------- */
if (typeof window['vc_tabsBehaviour'] !== 'function') {
    function vc_tabsBehaviour() {
        jQuery(function($){$(document.body).off('click.preview', 'a')});
        jQuery('.wpb_tabs, .wpb_tour').each(function(index) {
            var $tabs,
                interval = jQuery(this).attr("data-interval"),
                tabs_array = [];
            $tabs = jQuery(this).find('.wpb_tour_tabs_wrapper').tabs({
                show: function(event, ui) {},
                beforeActivate: function(event, ui) {
                    var panel = ui.panel || ui.newPanel;
                },
                activate: function(event, ui) {
                    var panel = ui.panel || ui.newPanel;
                }
            });
            jQuery(this).find('.wpb_tab').each(function(){ tabs_array.push(this.id); });
        });
    }
}

/* Tabs + Tours
---------------------------------------------------------- */
if (typeof window['vc_accordionBehaviour'] !== 'function') {
    function vc_accordionBehaviour() {
        jQuery('.wpb_accordion').each(function(index) {
            var $tabs,
                interval = jQuery(this).attr("data-interval"),
                active_tab = !isNaN(jQuery(this).data('active-tab')) && parseInt(jQuery(this).data('active-tab')) >  0 ? parseInt(jQuery(this).data('active-tab'))-1 : false,
                collapsible =  active_tab === false || jQuery(this).data('collapsible') === 'yes';
            var ac_icons = {
                header: "hook_fa-plus",
                activeHeader: "hook_fa-minus"
            };
            $tabs = jQuery(this).find('.wpb_accordion_wrapper').accordion({
                header: "> div > h3",
                icons: ac_icons,
                autoHeight: false,
                heightStyle: "content",
                active: active_tab,
                collapsible: collapsible,
                navigation: true,
                activate: function(event, ui){
                    vc_carouselBehaviour();
                    var panel = ui.panel || ui.newPanel;
                }
            });
        });
    }
}

/* Teaser grid: isotope
---------------------------------------------------------- */
if (typeof window['vc_teaserGrid'] !== 'function') {
    function vc_teaserGrid() {
        var layout_modes = {
            fitrows:'fitRows',
            masonry:'masonry'
        }
        jQuery('.wpb_grid .teaser_grid_container:not(.wpb_carousel), .wpb_filtered_grid .teaser_grid_container:not(.wpb_carousel)').each(function () {
            var $container = jQuery(this);
            var $thumbs = $container.find('.wpb_thumbnails');
            var layout_mode = $thumbs.attr('data-layout-mode');
            $thumbs.isotope({
                itemSelector:'.isotope-item',
                layoutMode:(layout_modes[layout_mode] == undefined ? 'fitRows' : layout_modes[layout_mode])
            });
            $container.find('.categories_filter a').data('isotope', $thumbs).click(function (e) {
                e.preventDefault();
                var $thumbs = jQuery(this).data('isotope');
                jQuery(this).parent().parent().find('.active').removeClass('active');
                jQuery(this).parent().addClass('active');
                $thumbs.isotope({filter:jQuery(this).attr('data-filter')});
            });
            jQuery(window).bind('load resize', function () {
                $thumbs.isotope("layout");
            });
        });
    }
}

if (typeof window['vc_carouselBehaviour'] !== 'function') {
    function vc_carouselBehaviour($parent) {
        var $carousel = $parent ? $parent.find(".wpb_carousel") : jQuery(".wpb_carousel");
        $carousel.each(function () {
            var $this = jQuery(this);
            if ($this.data('carousel_enabled') !== true && $this.is(':visible')) {
                $this.data('carousel_enabled', true);
                var carousel_width = jQuery(this).width(),
                    visible_count = getColumnsCount(jQuery(this)),
                    carousel_speed = 500;
                if (jQuery(this).hasClass('columns_count_1')) {
                    carousel_speed = 900;
                }
                var carousele_li = jQuery(this).find('.wpb_thumbnails-fluid li');
                carousele_li.css({"margin-right":carousele_li.css("margin-left"), "margin-left":0 });

                jQuery(this).find('.wpb_wrapper:eq(0)').jCarouselLite({
                    btnNext:jQuery(this).find('.next'),
                    btnPrev:jQuery(this).find('.prev'),
                    visible:visible_count,
                    speed:carousel_speed
                })
                    .width('100%');

                var fluid_ul = jQuery(this).find('ul.wpb_thumbnails-fluid');
                fluid_ul.width(fluid_ul.width() + 300);

                jQuery(window).resize(function () {
                    var before_resize = screen_size;
                    screen_size = getSizeName();
                    if (before_resize != screen_size) {
                        window.setTimeout('location.reload()', 20);
                    }
                });
            }

        });
        /*if (window.Swiper !== undefined) {

  jQuery('.swiper-container').each(function () {
    var $this = jQuery(this),
    my_swiper,
    max_slide_size = 0,
    options = jQuery(this).data('settings');

    if (options.mode === 'vertical') {
      $this.find('.swiper-slide').each(function () {
        var height = jQuery(this).outerHeight(true);
        if (height > max_slide_size) max_slide_size = height;
    });
      $this.height(max_slide_size);
      $this.css('overflow', 'hidden');
  }
  jQuery(window).resize(function () {
      $this.find('.swiper-slide').each(function () {
        var height = jQuery(this).outerHeight(true);
        if (height > max_slide_size) max_slide_size = height;
    });
      $this.height(max_slide_size);
  });
  my_swiper = jQuery(this).swiper(jQuery.extend(options, {
      onFirstInit:function (swiper) {
        if (swiper.slides.length < 2) {
          $this.find('.vc_arrow-left,.vc_arrow-right').hide();
      } else if (swiper.activeIndex === 0 && swiper.params.loop !== true) {
          $this.find('.vc_arrow-left').hide();
      } else {
          $this.find('.vc_arrow-left').show();
      }
  },
  onSlideChangeStart:function (swiper) {
    if (swiper.slides.length > 1 && swiper.params.loop !== true) {
      if (swiper.activeIndex === 0) {
        $this.find('.vc_arrow-left').hide();
    } else {
        $this.find('.vc_arrow-left').show();
    }
    if (swiper.slides.length - 1 === swiper.activeIndex) {
        $this.find('.vc_arrow-right').hide();
    } else {
        $this.find('.vc_arrow-right').show();
    }
}
}
}));
  $this.find('.vc_arrow-left').click(function (e) {
      e.preventDefault();
      my_swiper.swipePrev();
  });
  $this.find('.vc_arrow-right').click(function (e) {
      e.preventDefault();
      my_swiper.swipeNext();
  });
  my_swiper.reInit();
});

}*/

    }
}

if (typeof window['vc_slidersBehaviour'] !== 'function') {
    function vc_slidersBehaviour() {
        jQuery('.wpb_gallery_slides').each(function (index) {
            var this_element = jQuery(this);
            var ss_count = 0;

            if (this_element.hasClass('wpb_image_grid')) {
                var isotope = this_element.find('.wpb_image_grid_ul');
                isotope.isotope({
                    itemSelector:'.isotope-item',
                    layoutMode:'fitRows'
                });
                jQuery(window).load(function () {
                    isotope.isotope("layout");
                });
            }
        });
    }
}

if (typeof window['vc_prettyPhoto'] !== 'function') {
    function vc_prettyPhoto() { }
}


if ( typeof window['vc_google_fonts'] !== 'function' ) {
    function vc_google_fonts() {
        return;
    }
}
/* Helper
---------------------------------------------------------- */
function getColumnsCount(el) {
    var find = false,
        i = 1;

    while (find == false) {
        if (el.hasClass('columns_count_' + i)) {
            find = true;
            return i;
        }
        i++;
    }
}

var screen_size = getSizeName();
function getSizeName() {
    var screen_size = '',
        screen_w = jQuery(window).width();

    if (screen_w > 1170) {
        screen_size = "desktop_wide";
    }
    else if (screen_w > 960 && screen_w < 1169) {
        screen_size = "desktop";
    }
    else if (screen_w > 768 && screen_w < 959) {
        screen_size = "tablet";
    }
    else if (screen_w > 300 && screen_w < 767) {
        screen_size = "mobile";
    }
    else if (screen_w < 300) {
        screen_size = "mobile_portrait";
    }
    return screen_size;
}


function loadScript(url, $obj, callback) {

    var script = document.createElement("script")
    script.type = "text/javascript";

    if (script.readyState) {
        script.onreadystatechange = function () {
            if (script.readyState == "loaded" ||
                script.readyState == "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  }

    script.src = url;
    $obj.get(0).appendChild(script);
}

/**
 * Prepare html to correctly display inside tab container
 *
 * @param event - ui tab event 'show'
 * @param ui - jquery ui tabs object
 */

function wpb_prepare_tab_content(event, ui) {
    var panel = ui.panel || ui.newPanel,
        $pie_charts = panel.find('.vc_pie_chart:not(.vc_ready)'),
        $carousel = panel.find('[data-ride="vc_carousel"]'),
        $ui_panel, $google_maps;
    vc_carouselBehaviour();
    vc_plugin_flexslider(panel);
    $pie_charts.length && jQuery.fn.vcChat && $pie_charts.vcChat();
    $carousel.length && jQuery.fn.carousel && $carousel.carousel('resizeAction');
    $ui_panel = panel.find('.isotope');
    $google_maps = panel.find('.wpb_gmaps_widget');
    if ($ui_panel.length > 0) {
        $ui_panel.isotope("layout");
    }
    if ($google_maps.length && !$google_maps.is('.map_ready')) {
        var $frame = $google_maps.find('iframe');
        $frame.attr('src', $frame.attr('src'));
        $google_maps.addClass('map_ready');
    }
    if(panel.parents('.isotope').length) {
        panel.parents('.isotope').each(function(){
            jQuery(this).isotope("layout");
        });
    }
}
/* =========================================================
 * vc-accordion.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer accordion
 * ========================================================= */
+ function ( $ ) {
    'use strict';

    var Accordion, clickHandler, old, hashNavigation;

    // Accordion plugin definition
    // ==========================
    function Plugin( action, options ) {
        var args;

        args = Array.prototype.slice.call( arguments, 1 );
        return this.each( function () {
            var $this, data;

            $this = $( this );
            data = $this.data( 'vc.accordion' );
            if ( ! data ) {
                data = new Accordion( $this, $.extend( true, {}, options ) );
                $this.data( 'vc.accordion', data );
            }
            if ( 'string' === typeof(action) ) {
                data[ action ].apply( data, args );
            }
        } );
    }

    /**
     * Accordion object definition
     * @param $element
     * @constructor
     */
    Accordion = function ( $element, options ) {
        this.$element = $element;
        this.activeClass = 'vc_active';
        this.animatingClass = 'vc_animating';
        // cached vars
        this.useCacheFlag = undefined;
        this.$target = undefined;
        this.$targetContent = undefined;
        this.selector = undefined;
        this.$container = undefined;
        this.animationDuration = undefined;
        this.index = 0;
    };

    /**
     * Get supported transition event
     * @returns {*}
     */
    Accordion.transitionEvent = function () {
        var transition, transitions, el;
        el = document.createElement( 'vcFakeElement' );
        transitions = {
            'transition': 'transitionend',
            'MSTransition': 'msTransitionEnd',
            'MozTransition': 'transitionend',
            'WebkitTransition': 'webkitTransitionEnd'
        };

        for ( transition in
            transitions ) {
            if ( 'undefined' !== typeof(el.style[ transition ]) ) {
                return transitions[ transition ];
            }
        }
    };

    /**
     * Emulate transition end
     * @param $el
     * @param duration
     */
    Accordion.emulateTransitionEnd = function ( $el, duration ) {
        var callback, called;
        called = false;
        if ( ! duration ) {
            duration = 250;
        }

        $el.one( Accordion.transitionName, function () {
            called = true;
        } );
        callback = function () {
            if ( ! called ) {
                $el.trigger( Accordion.transitionName );
            }
        };
        setTimeout( callback, duration );
    };

    Accordion.DEFAULT_TYPE = 'collapse';
    Accordion.transitionName = Accordion.transitionEvent();

    /**
     * Accordion controller
     * @param action
     */
    Accordion.prototype.controller = function ( action ) {
        var $this;
        $this = this.$element;

        if ( 'string' !== typeof(action) ) {
            action = $this.data( 'vcAction' ) || this.getContainer().data( 'vcAction' );
        }
        if ( 'undefined' === typeof(action) ) {
            action = Accordion.DEFAULT_TYPE;
        }

        if ( 'string' === typeof(action) ) {
            Plugin.call( $this, action );
        }
    };

    /**
     * Is cache used
     * @returns {boolean}
     */
    Accordion.prototype.isCacheUsed = function () {
        var useCache, that;
        that = this;
        useCache = function () {
            return false !== that.$element.data( 'vcUseCache' );
        };

        if ( 'undefined' === typeof(this.useCacheFlag) ) {
            this.useCacheFlag = useCache();
        }

        return this.useCacheFlag;
    };

    /**
     * Get selector
     * @returns {*}
     */
    Accordion.prototype.getSelector = function () {
        var findSelector, $this;

        $this = this.$element;

        findSelector = function () {
            var selector;

            selector = $this.data( 'vcTarget' );
            if ( ! selector ) {
                selector = $this.attr( 'href' );
            }

            return selector;
        };

        if ( ! this.isCacheUsed() ) {
            return findSelector();
        }

        if ( 'undefined' === typeof(this.selector) ) {
            this.selector = findSelector();
        }

        return this.selector;
    };

    /**
     * Find container
     * @returns {window.jQuery}
     */
    Accordion.prototype.findContainer = function () {
        var $container;
        $container = this.$element.closest( this.$element.data( 'vcContainer' ) );
        if ( ! $container.length ) {
            $container = $( 'body' );
        }
        return $container;
    };

    /**
     * Get container
     * @returns {*|Number}
     */
    Accordion.prototype.getContainer = function () {
        if ( ! this.isCacheUsed() ) {
            return this.findContainer();
        }

        if ( 'undefined' === typeof(this.$container) ) {
            this.$container = this.findContainer();
        }

        return this.$container;
    };

    /**
     * Get target
     * @returns {*}
     */
    Accordion.prototype.getTarget = function () {
        var selector, that, getTarget;
        that = this;
        selector = that.getSelector();
        getTarget = function () {
            var element;
            element = that.getContainer().find( selector );
            if ( ! element.length ) {
                element = that.getContainer().filter( selector );
            }
            return element;
        };

        if ( ! this.isCacheUsed() ) {
            return getTarget();
        }

        if ( 'undefined' === typeof(this.$target) ) {
            this.$target = getTarget();
        }

        return this.$target;
    };

    /**
     * Get target content
     * @returns {*}
     */
    Accordion.prototype.getTargetContent = function () {
        var $target, $targetContent;
        $target = this.getTarget();
        if ( ! this.isCacheUsed() ) {
            if ( $target.data( 'vcContent' ) ) {
                $targetContent = $target.find( $target.data( 'vcContent' ) );
                if ( $targetContent.length ) {
                    return $targetContent;
                }
            }
            return $target;
        }

        if ( 'undefined' === typeof(this.$targetContent) ) {
            $targetContent = $target;
            if ( $target.data( 'vcContent' ) ) {
                $targetContent = $target.find( $target.data( 'vcContent' ) );
                if ( ! $targetContent.length ) {
                    $targetContent = $target;
                }
            }
            this.$targetContent = $targetContent;
        }

        return this.$targetContent;
    };

    /**
     * Get triggers
     * @returns {*}
     */
    Accordion.prototype.getTriggers = function () {
        var i;
        i = 0;
        return this.getContainer().find( '[data-vc-accordion]' ).each( function () {
            var accordion, $this;
            $this = $( this );
            accordion = $this.data( 'vc.accordion' );
            if ( 'undefined' === typeof(accordion) ) {
                $this.vcAccordion();
                accordion = $this.data( 'vc.accordion' );
            }
            accordion && accordion.setIndex && accordion.setIndex( i ++ );
        } );
    };

    /**
     * Set the position index in getTriggers
     * @param index
     */
    Accordion.prototype.setIndex = function ( index ) {
        this.index = index;
    };

    /**
     * Get the position index in getTriggers
     */
    Accordion.prototype.getIndex = function () {
        return this.index;
    };

    /**
     * Trigger event
     * @param event
     */
    Accordion.prototype.triggerEvent = function ( event ) {
        var $event;
        if ( 'string' === typeof(event) ) {
            $event = $.Event( event );
            this.$element.trigger( $event );
        }
    };

    /**
     * Get active triggers
     * @returns {*}
     */
    Accordion.prototype.getActiveTriggers = function () {
        var $triggers;

        $triggers = this.getTriggers().filter( function () {
            var $this, accordion;
            $this = $( this );
            accordion = $this.data( 'vc.accordion' );

            return accordion.getTarget().hasClass( accordion.activeClass );
        } );
        return $triggers;
    };

    /**
     * change document location hash
     */
    Accordion.prototype.changeLocationHash = function () {
        var id, $target;

        $target = this.getTarget();
        if ( $target.length ) {
            id = $target.attr( 'id' );
        }
        if ( id ) {
            if ( history.pushState ) {
                history.pushState( null, null, '#' + id );
            }
            else {
                location.hash = '#' + id;
            }
        }
    };

    /**
     * is active
     * @returns {boolean}
     */
    Accordion.prototype.isActive = function () {

        return this.getTarget().hasClass( this.activeClass );
    };

    /**
     * Get animation duration
     * @returns {*|Number}
     */
    Accordion.prototype.getAnimationDuration = function () {
        var findAnimationDuration, that;
        that = this;

        findAnimationDuration = function () {
            var $targetContent, duration;

            if ( 'undefined' === typeof(Accordion.transitionName) ) {
                return '0s';
            }

            $targetContent = that.getTargetContent();
            duration = $targetContent.css( 'transition-duration' );
            duration = duration.split( ',' )[ 0 ];
            return duration;
        };

        if ( ! this.isCacheUsed() ) {
            return findAnimationDuration();
        }

        if ( 'undefined' === typeof(this.animationDuration) ) {
            this.animationDuration = findAnimationDuration();
        }
        return this.animationDuration;
    };

    /**
     * Get animation duration in milliseconds
     * @returns {*|Number}
     */
    Accordion.prototype.getAnimationDurationMilliseconds = function () {
        var duration;
        duration = this.getAnimationDuration();

        if ( 'ms' === duration.substr( - 2 ) ) {
            return parseInt( duration );
        }

        if ( 's' === duration.substr( - 1 ) ) {
            return Math.round( parseFloat( duration ) * 1000 )
        }
    };

    /**
     * Has animation
     * @returns {boolean}
     */
    Accordion.prototype.isAnimated = function () {
        return parseFloat( this.getAnimationDuration() ) > 0;
    };

    /**
     * Show accordion panel
     */
    Accordion.prototype.show = function () {
        var $target, that, $targetContent;

        that = this;
        $target = that.getTarget();
        $targetContent = that.getTargetContent();

        // if showed no need to do anything
        if ( that.isActive() ) {
            return;
        }

        if ( that.isAnimated() ) {
            that.triggerEvent( 'beforeShow.vc.accordion' );
            $target
                .queue( function ( next ) {
                    $targetContent.one( Accordion.transitionName, function () {
                        $target.removeClass( that.animatingClass );
                        $targetContent.attr( 'style', '' );
                        that.triggerEvent( 'afterShow.vc.accordion' );
                    } );
                    Accordion.emulateTransitionEnd( $targetContent, that.getAnimationDurationMilliseconds() + 100 );
                    next();
                } )
                .queue( function ( next ) {
                    $targetContent.attr( 'style', '' );
                    $targetContent.css( {
                        position: 'absolute', // Optional if #myDiv is already absolute
                        visibility: 'hidden',
                        display: 'block'
                    } );
                    var height = $targetContent.height();
                    $targetContent.data( 'vcHeight', height );
                    $targetContent.attr( 'style', '' );
                    next();
                } )
                .queue( function ( next ) {
                    $targetContent.height( 0 );
                    $targetContent.css( {
                        'padding-top': 0,
                        'padding-bottom': 0
                    } );
                    next();
                } )
                .queue( function ( next ) {
                    $target.addClass( that.animatingClass );
                    $target.addClass( that.activeClass );
                    //REMOVE URL HASH FEATURE - PIRENKO
                    //that.changeLocationHash();
                    that.triggerEvent( 'show.vc.accordion' );
                    next();
                } )
                .queue( function ( next ) {
                    var height = $targetContent.data( 'vcHeight' );
                    $targetContent.animate( { 'height': height }, {
                        duration: that.getAnimationDurationMilliseconds(),
                        complete: function () {
                            if (!$targetContent.data('events')) {
                                $targetContent.attr( 'style', '' );
                            }
                        }
                    } );
                    $targetContent.css( {
                        'padding-top': '',
                        'padding-bottom': ''
                    } );
                    next();
                } );
        } else {
            $target.addClass( that.activeClass );
            that.triggerEvent( 'show.vc.accordion' );
        }
    };

    /**
     * Hide accordion panel
     */
    Accordion.prototype.hide = function () {
        var $target, that, $targetContent;

        that = this;
        $target = that.getTarget();
        $targetContent = that.getTargetContent();

        // if hidden no need to do anything
        if ( ! that.isActive() ) {
            return;
        }

        if ( that.isAnimated() ) {
            that.triggerEvent( 'beforeHide.vc.accordion' );
            $target
                .queue( function ( next ) {
                    $targetContent.one( Accordion.transitionName, function () {
                        $target.removeClass( that.animatingClass );
                        $targetContent.attr( 'style', '' );
                        that.triggerEvent( 'afterHide.vc.accordion' );
                    } );
                    Accordion.emulateTransitionEnd( $targetContent, that.getAnimationDurationMilliseconds() + 100 );
                    next();
                } )
                .queue( function ( next ) {
                    $target.addClass( that.animatingClass );
                    $target.removeClass( that.activeClass );
                    that.triggerEvent( 'hide.vc.accordion' );
                    next();
                } )
                .queue( function ( next ) {
                    var height = $targetContent.height();
                    $targetContent.height( height );
                    next();
                } )
                .queue( function ( next ) {
                    $targetContent.animate( { 'height': 0 }, that.getAnimationDurationMilliseconds() );
                    $targetContent.css( {
                        'padding-top': 0,
                        'padding-bottom': 0
                    } );
                    next();
                } );
        } else {
            $target.removeClass( that.activeClass );
            that.triggerEvent( 'hide.vc.accordion' );
        }
    };

    /**
     * Accordion type: toggle
     */
    Accordion.prototype.toggle = function () {
        var $this;

        $this = this.$element;

        if ( this.isActive() ) {
            Plugin.call( $this, 'hide' );
        } else {
            Plugin.call( $this, 'show' );
        }
    };

    /**
     * Accordion type: dropdown
     */
    Accordion.prototype.dropdown = function () {
        var $this, that;
        that = this;
        $this = this.$element;

        if ( this.isActive() ) {
            Plugin.call( $this, 'hide' );
        } else {
            Plugin.call( $this, 'show' );
            $( document ).on( 'click.vc.accordion.data-api.dropdown', function ( e ) {
                var isTarget;
                isTarget = $( e.target ).closest( that.getTarget() ).length;
                if ( ! isTarget ) {
                    Plugin.call( $this, 'hide' );
                    $( document ).off( e );
                }
            } );
        }
    };

    /**
     * Accordion type: collapse
     */
    Accordion.prototype.collapse = function () {
        var $this,
            $triggers;

        $this = this.$element;
        $triggers = this.getActiveTriggers().filter( function () {
            return $this[ 0 ] !== this;
        } );

        if ( $triggers.length ) {
            Plugin.call( $triggers, 'hide' );
        }
        Plugin.call( $this, 'show' );
    };

    /**
     * Accordion type: collapse all
     */
    Accordion.prototype.collapseAll = function () {
        var $this,
            $triggers;

        $this = this.$element;
        $triggers = this.getActiveTriggers().filter( function () {
            return $this[ 0 ] !== this;
        } );

        if ( $triggers.length ) {
            Plugin.call( $triggers, 'hide' );
        }
        Plugin.call( $this, 'toggle' );
    };

    Accordion.prototype.showNext = function () {
        var $triggers,
            $activeTriggers,
            activeIndex;

        $triggers = this.getTriggers();
        $activeTriggers = this.getActiveTriggers();
        if ( $triggers.length ) {
            if ( $activeTriggers.length ) {
                var lastActiveAccordion;
                lastActiveAccordion = $activeTriggers.eq( $activeTriggers.length - 1 ).vcAccordion().data( 'vc.accordion' );
                if ( lastActiveAccordion && lastActiveAccordion.getIndex ) {
                    activeIndex = lastActiveAccordion.getIndex();
                }
            }
            if ( - 1 < activeIndex ) {
                if ( activeIndex + 1 < $triggers.length ) {
                    Plugin.call( $triggers.eq( activeIndex + 1 ), 'controller' );
                } else {
                    // we are in the end so next is first
                    Plugin.call( $triggers.eq( 0 ), 'controller' );
                }
            } else {
                // no one is active let's activate first
                Plugin.call( $triggers.eq( 0 ), 'controller' );
            }
        }
    };

    Accordion.prototype.showPrev = function () {
        var $triggers,
            $activeTriggers,
            activeIndex;

        $triggers = this.getTriggers();
        $activeTriggers = this.getActiveTriggers();
        if ( $triggers.length ) {
            if ( $activeTriggers.length ) {
                var lastActiveAccordion;
                lastActiveAccordion = $activeTriggers.eq( $activeTriggers.length - 1 ).vcAccordion().data( 'vc.accordion' );
                if ( lastActiveAccordion && lastActiveAccordion.getIndex ) {
                    activeIndex = lastActiveAccordion.getIndex();
                }
            }
            if ( - 1 < activeIndex ) {
                if ( 0 <= activeIndex - 1 ) {
                    Plugin.call( $triggers.eq( activeIndex - 1 ), 'controller' );
                } else {
                    // we are in the end so next is first
                    Plugin.call( $triggers.eq( $triggers.length - 1 ), 'controller' );
                }
            } else {
                // no one is active let's activate first
                Plugin.call( $triggers.eq( 0 ), 'controller' );
            }
        }
    };

    Accordion.prototype.showAt = function ( index ) {
        var $triggers;

        $triggers = this.getTriggers();
        if ( $triggers.length && index && index < $triggers.length ) {
            Plugin.call( $triggers.eq( index ), 'controller' );
        }
    };

    old = $.fn.vcAccordion;

    $.fn.vcAccordion = Plugin;
    $.fn.vcAccordion.Constructor = Accordion;

    // Accordion no conflict
    // ==========================
    $.fn.vcAccordion.noConflict = function () {
        $.fn.vcAccordion = old;
        return this;
    };

    // Accordion data-api
    // =================
    clickHandler = function ( e ) {
        var $this;
        $this = $( this );
        e.preventDefault();
        Plugin.call( $this, 'controller' );
    };

    hashNavigation = function () {
        var hash, $targetElement, $accordion, offset, delay, speed;
        offset = 0.3;
        delay = 300;
        speed = 0;

        hash = window.location.hash;
        if ( hash ) {
            $targetElement = $( hash );
            if ( $targetElement.length && $targetElement.hasClass('vc_tta-panel')) {
                $accordion = $targetElement.find('[data-vc-accordion]');
                if ( $accordion.length ) {
                    setTimeout( function () {
                        $( 'html, body' ).animate( {
                            scrollTop: $targetElement.offset().top - $( window ).height() * offset
                        }, speed );
                    }, delay );
                    $accordion.trigger( 'click' );
                }
            }
        }
    };

    $( document ).on( 'click.vc.accordion.data-api', '[data-vc-accordion]', clickHandler );
    $( document ).ready( hashNavigation );
}( window.jQuery );
/* =========================================================
 * vc-tabs.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer Tabs
 * ========================================================= */
+ function ( $ ) {
    'use strict';

    var Tabs, old, clickHandler, changeHandler;

    /**
     * Tabs object definition
     * @param element
     * @constructor
     */
    Tabs = function ( element, options ) {
        this.$element = $( element );
        this.activeClass = 'vc_active';
        this.tabSelector = '[data-vc-tab]';

        // cached vars
        this.useCacheFlag = undefined;
        this.$target = undefined;
        this.selector = undefined;
        this.$targetTab = undefined;
        this.$relatedAccordion = undefined;
        this.$container = undefined;
    };

    /**
     * Is cache used
     * @returns {boolean}
     */
    Tabs.prototype.isCacheUsed = function () {
        var useCache, that;
        that = this;
        useCache = function () {
            return false !== that.$element.data( 'vcUseCache' );
        };

        if ( undefined === this.useCacheFlag ) {
            this.useCacheFlag = useCache();
        }

        return this.useCacheFlag;
    };

    /**
     * Get container
     * @returns {*|Number}
     */
    Tabs.prototype.getContainer = function () {
        if ( ! this.isCacheUsed() ) {
            return this.findContainer();
        }

        if ( undefined === this.$container ) {
            this.$container = this.findContainer();
        }

        return this.$container;
    };

    /**
     * Find container
     * @returns {window.jQuery}
     */
    Tabs.prototype.findContainer = function () {
        var $container;
        $container = this.$element.closest( this.$element.data( 'vcContainer' ) );
        if ( ! $container.length ) {
            $container = $( 'body' );
        }
        return $container;
    };

    /**
     * Get container accordions
     * @returns {*}
     */
    Tabs.prototype.getContainerAccordion = function () {
        return this.getContainer().find( '[data-vc-accordion]' );
    };

    /**
     * Get selector
     * @returns {*}
     */
    Tabs.prototype.getSelector = function () {
        var findSelector, $this;

        $this = this.$element;
        findSelector = function () {
            var selector;

            selector = $this.data( 'vcTarget' );
            if ( ! selector ) {
                selector = $this.attr( 'href' );
            }

            return selector;
        };

        if ( ! this.isCacheUsed() ) {
            return findSelector();
        }

        if ( undefined === this.selector ) {
            this.selector = findSelector();
        }

        return this.selector;
    };

    /**
     * Get target
     * @returns {*}
     */
    Tabs.prototype.getTarget = function () {
        var selector;
        selector = this.getSelector();

        if ( ! this.isCacheUsed() ) {
            return this.getContainer().find( selector );
        }

        if ( undefined === this.$target ) {
            this.$target = this.getContainer().find( selector );
        }

        return this.$target;
    };

    /**
     * Get related accordion
     * @returns {*}
     */
    Tabs.prototype.getRelatedAccordion = function () {
        var tab, filterElements;

        tab = this;

        filterElements = function () {
            var $elements;

            $elements = tab.getContainerAccordion().filter( function () {
                var $that, accordion;
                $that = $( this );

                accordion = $that.data( 'vc.accordion' );

                if ( undefined === accordion ) {
                    $that.vcAccordion();
                    accordion = $that.data( 'vc.accordion' );
                }

                return tab.getSelector() === accordion.getSelector();
            } );

            if ( $elements.length ) {
                return $elements;
            }

            return undefined;
        };
        if ( ! this.isCacheUsed() ) {
            return filterElements();
        }

        if ( undefined === this.$relatedAccordion ) {
            this.$relatedAccordion = filterElements();
        }

        return this.$relatedAccordion;
    };

    /**
     * Trigger event
     * @param event
     */
    Tabs.prototype.triggerEvent = function ( event ) {
        var $event;
        if ( 'string' === typeof event ) {
            $event = $.Event( event );
            this.$element.trigger( $event );
        }
    };

    /**
     * Get target tab
     * @returns {*|Number}
     */
    Tabs.prototype.getTargetTab = function () {
        var $this;
        $this = this.$element;

        if ( ! this.isCacheUsed() ) {
            return $this.closest( this.tabSelector );
        }

        if ( undefined === this.$targetTab ) {
            this.$targetTab = $this.closest( this.tabSelector );
        }

        return this.$targetTab;
    };

    /**
     * Tab Clicked
     */
    Tabs.prototype.tabClick = function () {

        this.getRelatedAccordion().trigger( 'click' );
    };

    /**
     * Tab Show
     */
    Tabs.prototype.show = function () {
        // if showed no need to do anything
        if ( this.getTargetTab().hasClass( this.activeClass ) ) {
            return;
        }

        this.triggerEvent( 'show.vc.tab' );

        this.getTargetTab().addClass( this.activeClass );
    };

    /**
     * Tab Hide
     */
    Tabs.prototype.hide = function () {
        // if showed no need to do anything
        if ( ! this.getTargetTab().hasClass( this.activeClass ) ) {
            return;
        }

        this.triggerEvent( 'hide.vc.tab' );

        this.getTargetTab().removeClass( this.activeClass );
    };

    //Tabs.prototype

    // Tabs plugin definition
    // ==========================
    function Plugin( action, options ) {
        var args;

        args = Array.prototype.slice.call( arguments, 1 );
        return this.each( function () {
            var $this, data;

            $this = $( this );
            data = $this.data( 'vc.tabs' );
            if ( ! data ) {
                data = new Tabs( $this, $.extend( true, {}, options ) );
                $this.data( 'vc.tabs', data );
            }
            if ( 'string' === typeof action ) {
                data[ action ].apply( data, args );
            }
        } );
    }

    old = $.fn.vcTabs;

    $.fn.vcTabs = Plugin;
    $.fn.vcTabs.Constructor = Tabs;

    // Tabs no conflict
    // ==========================
    $.fn.vcTabs.noConflict = function () {
        $.fn.vcTabs = old;
        return this;
    };

    // Tabs data-api
    // =================

    clickHandler = function ( e ) {
        var $this;
        $this = $( this );
        e.preventDefault();
        Plugin.call( $this, 'tabClick' );
    };

    changeHandler = function ( e ) {
        var caller;
        caller = $( e.target ).data( 'vc.accordion' );

        //BETTER PLUGIN COMPATIBILITY - PIRENKO
        setTimeout(function() {
            jQuery(window).trigger('smartresize');
            jQuery(window).trigger('resize');
        },0);
        if ( undefined === caller.getRelatedTab ) {
            /**
             * Get related tab from accordion
             * @returns {*}
             */
            caller.getRelatedTab = function () {
                var findTargets;

                findTargets = function () {
                    var $targets;
                    $targets = caller.getContainer().find( '[data-vc-tabs]' ).filter( function () {
                        var $this, tab;
                        $this = $( this );

                        tab = $this.data( 'vc.accordion' );
                        if ( undefined === tab ) {
                            $this.vcAccordion();
                        }
                        tab = $this.data( 'vc.accordion' );

                        return tab.getSelector() === caller.getSelector();
                    } );

                    return $targets;
                };

                if ( ! caller.isCacheUsed() ) {
                    return findTargets();
                }

                if ( undefined === caller.relatedTab ) {
                    caller.relatedTab = findTargets();
                }

                return caller.relatedTab;
            };
        }

        Plugin.call( caller.getRelatedTab(), e.type );
    };

    $( document ).on( 'click.vc.tabs.data-api', '[data-vc-tabs]', clickHandler );
    $( document ).on( 'show.vc.accordion hide.vc.accordion', changeHandler );
}( window.jQuery );
/* =========================================================
 * vc-tta-autoplay.js v1.0.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer tabs, tours, accordion auto play
 * ========================================================= */
+ function ( $ ) {
    'use strict';

    var Plugin, TtaAutoPlay, old;

    Plugin = function ( action, options ) {
        var args;

        args = Array.prototype.slice.call( arguments, 1 );
        return this.each( function () {
            var $this, data;

            $this = $( this );
            data = $this.data( 'vc.tta.autoplay' );
            if ( ! data ) {
                data = new TtaAutoPlay( $this,
                    $.extend( true, {}, TtaAutoPlay.DEFAULTS, $this.data( 'vc-tta-autoplay' ), options ) );
                $this.data( 'vc.tta.autoplay', data );
            }
            if ( 'string' === typeof action ) {
                data[ action ].apply( data, args );
            } else {
                data.start( args ); // start the auto play by default
            }
        } );
    };

    /**
     * AutoPlay constuctor
     * @param $element
     * @param options
     * @constructor
     */
    TtaAutoPlay = function ( $element, options ) {
        this.$element = $element;
        this.options = options;
    };

    TtaAutoPlay.DEFAULTS = {
        delay: 5000,
        pauseOnHover: true,
        stopOnClick: true
    };

    /**
     * Method called on timeout hook call
     */
    TtaAutoPlay.prototype.show = function () {
        this.$element.find( '[data-vc-accordion]:eq(0)' ).vcAccordion( 'showNext' );
    };

    /**
     * Check is container has set window.setInterval
     *
     * @returns {boolean}
     */
    TtaAutoPlay.prototype.hasTimer = function () {
        return undefined !== this.$element.data( 'vc.tta.autoplay.timer' );
    };

    /**
     * Set for container window.setInterval and save it in data-attribute
     *
     * @param windowInterval
     */
    TtaAutoPlay.prototype.setTimer = function ( windowInterval ) {
        this.$element.data( 'vc.tta.autoplay.timer', windowInterval );
    };

    /**
     * Get containers timer from data-attributes
     *
     * @returns {*|Number}
     */
    TtaAutoPlay.prototype.getTimer = function () {
        return this.$element.data( 'vc.tta.autoplay.timer' );
    };

    /**
     * Removes from container data-attributes timer
     */
    TtaAutoPlay.prototype.deleteTimer = function () {
        this.$element.removeData( 'vc.tta.autoplay.timer' );
    };

    /**
     * Starts the autoplay timer with multiple call preventions
     */
    TtaAutoPlay.prototype.start = function () {
        var $this,
            that;

        $this = this.$element;
        that = this;

        /**
         * Local method called when accordion title being clicked
         * Used to stop autoplay
         *
         * @param e {jQuery.Event}
         */
        function stopHandler( e ) {
            e.preventDefault && e.preventDefault();

            if ( that.hasTimer() ) {
                Plugin.call( $this, 'stop' );
            }
        }

        /**
         * Local method called when mouse hovers a [data-vc-tta-autoplay] element( this.$element )
         * Used to pause/resume autoplay
         *
         * @param e {jQuery.Event}
         */
        function hoverHandler( e ) {
            e.preventDefault && e.preventDefault();

            if ( that.hasTimer() ) {
                Plugin.call( $this, 'mouseleave' === e.type ? 'resume' : 'pause' );
            }
        }

        if ( ! this.hasTimer() ) {
            this.setTimer( window.setInterval( this.show.bind( this ), this.options.delay ) );

            // On switching tab by click it stop/clears the timer
            this.options.stopOnClick && $this.on( 'click.vc.tta.autoplay.data-api',
                '[data-vc-accordion]',
                stopHandler );

            // On hover it pauses/resumes the timer
            this.options.pauseOnHover && $this.hover( hoverHandler );
        }
    };

    /**
     * Resumes the paused autoplay timer
     */
    TtaAutoPlay.prototype.resume = function () {
        if ( this.hasTimer() ) {
            this.setTimer( window.setInterval( this.show.bind( this ), this.options.delay ) );
        }
    };

    /**
     * Stop the autoplay timer
     */
    TtaAutoPlay.prototype.stop = function () {
        this.pause();
        this.deleteTimer();
        // Remove bind events in TtaAutoPlay.prototype.start method
        this.$element.off( 'click.vc.tta.autoplay.data-api mouseenter mouseleave' );
    };

    /**
     * Pause the autoplay timer
     */
    TtaAutoPlay.prototype.pause = function () {
        var timer;

        timer = this.getTimer();
        if ( undefined !== timer ) {
            window.clearInterval( timer );
        }
    };

    old = $.fn.vcTtaAutoPlay;

    $.fn.vcTtaAutoPlay = Plugin;

    $.fn.vcTtaAutoPlay.Constructor = TtaAutoPlay;

    /**
     * vcTtaAutoPlay no conflict
     * @returns {$.fn.vcTtaAutoPlay}
     */
    $.fn.vcTtaAutoPlay.noConflict = function () {
        $.fn.vcTtaAutoPlay = old;
        return this;
    };

    /**
     * Find all autoplay elements and start the timer
     */
    function startAutoPlay() {
        $( '[data-vc-tta-autoplay]' ).each( function () {
            $( this ).vcTtaAutoPlay();
        } );
    }

    $( document ).ready( startAutoPlay );
}( window.jQuery );



/* jshint ignore:end */