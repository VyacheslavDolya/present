;window.Modernizr=function(a,b,c){function z(a){j.cssText=a}function A(a,b){return z(m.join(a+";")+(b||""))}function B(a,b){return typeof a===b}function C(a,b){return!!~(""+a).indexOf(b)}function D(a,b){for(var d in a){var e=a[d];if(!C(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function E(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:B(f,"function")?f.bind(d||b):f}return!1}function F(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return B(b,"string")||B(b,"undefined")?D(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),E(e,b,c))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={},r={},s={},t=[],u=t.slice,v,w=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},x={}.hasOwnProperty,y;!B(x,"undefined")&&!B(x.call,"undefined")?y=function(a,b){return x.call(a,b)}:y=function(a,b){return b in a&&B(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=u.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(u.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(u.call(arguments)))};return e}),q.backgroundsize=function(){return F("backgroundSize")},q.cssanimations=function(){return F("animationName")},q.csstransforms=function(){return!!F("transform")},q.csstransforms3d=function(){var a=!!F("perspective");return a&&"webkitPerspective"in g.style&&w("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a},q.csstransitions=function(){return F("transition")};for(var G in q)y(q,G)&&(v=G.toLowerCase(),e[v]=q[G](),t.push((e[v]?"":"no-")+v));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)y(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" nextend-"+(b?"":"no-")+a),e[a]=b}return e},z(""),i=k=null,e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.testProp=function(a){return D([a])},e.testAllProps=F,e.testStyles=w,e.prefixed=function(a,b,c){return b?F(a,b,c):F(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" nextend-js nextend-"+t.join(" nextend-"):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
window.Modernizr.hyphenated = function(str) {
    return Modernizr.prefixed(str).replace(/([A-Z])/g, function(str, m1) {
        return '-' + m1.toLowerCase();
    }).replace(/^ms-/, '-ms-');
};

dojo.copyTouch = function(sourceObj, targetObj) {
    targetObj.screenX = sourceObj.screenX;
    targetObj.screenY = sourceObj.screenY;
    targetObj.identifier = sourceObj.identifier;
};

dojo.hasFlash = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? 1 : 0;


window.dojoEasingToCSSEasing = function(easing) {
    switch (easing) {
    case "dojo.fx.easing.linear":
        return 'linear';
    case "dojo.fx.easing.quadIn":
        return 'cubic-bezier(0.550, 0.085, 0.680, 0.530)';
    case "dojo.fx.easing.quadOut":
        return 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
    case "dojo.fx.easing.quadInOut":
        return 'cubic-bezier(0.455, 0.030, 0.515, 0.955)';
    case "dojo.fx.easing.cubicIn":
        return 'cubic-bezier(0.550, 0.055, 0.675, 0.190)';
    case "dojo.fx.easing.cubicOut":
        return 'cubic-bezier(0.215, 0.610, 0.355, 1.000)';
    case "dojo.fx.easing.cubicInOut":
        return 'cubic-bezier(0.645, 0.045, 0.355, 1.000)';
    case "dojo.fx.easing.quartIn":
        return 'cubic-bezier(0.895, 0.030, 0.685, 0.220)';
    case "dojo.fx.easing.quartOut":
        return 'cubic-bezier(0.165, 0.840, 0.440, 1.000)';
    case "dojo.fx.easing.quartInOut":
        return 'cubic-bezier(0.770, 0.000, 0.175, 1.000)';
    case "dojo.fx.easing.quintIn":
        return 'cubic-bezier(0.755, 0.050, 0.855, 0.060)';
    case "dojo.fx.easing.quintOut":
        return 'cubic-bezier(0.230, 1.000, 0.320, 1.000)';
    case "dojo.fx.easing.quintInOut":
        return 'cubic-bezier(0.860, 0.000, 0.070, 1.000)';
    case "dojo.fx.easing.sineIn":
        return 'cubic-bezier(0.470, 0.000, 0.745, 0.715)';
    case "dojo.fx.easing.sineOut":
        return 'cubic-bezier(0.390, 0.575, 0.565, 1.000)';
    case "dojo.fx.easing.sineInOut":
        return 'cubic-bezier(0.445, 0.050, 0.550, 0.950)';
    case "dojo.fx.easing.expoIn":
        return 'cubic-bezier(0.950, 0.050, 0.795, 0.035)';
    case "dojo.fx.easing.expoOut":
        return 'cubic-bezier(0.190, 1.000, 0.220, 1.000)';
    case "dojo.fx.easing.expoInOut":
        return 'cubic-bezier(1.000, 0.000, 0.000, 1.000)';
    case "dojo.fx.easing.circIn":
        return 'cubic-bezier(0.600, 0.040, 0.980, 0.335)';
    case "dojo.fx.easing.circOut":
        return 'cubic-bezier(0.075, 0.820, 0.165, 1.000)';
    case "dojo.fx.easing.circInOut":
        return 'cubic-bezier(0.785, 0.135, 0.150, 0.860)';
    case "dojo.fx.easing.backIn":
        return 'cubic-bezier(0.600, -0.280, 0.735, 0.045)';
    case "dojo.fx.easing.backOut":
        return 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
    case "dojo.fx.easing.backInOut":
        return 'cubic-bezier(0.680, -0.550, 0.265, 1.550)';
    case "dojo.fx.easing.bounceIn":
        return 'ease-in';
    case "dojo.fx.easing.bounceOut":
        return 'ease-out';
    case "dojo.fx.easing.bounceInOut":
        return 'ease-in-out';
    default:
        return 'linear';
    }
}

dojo.declare("NextendSmartSliderResponsive", null, {
    responsivescaleup: 1,
    constructor: function(args) {
        var transEndEventNames = {
            'WebkitTransition': 'webkitTransitionEnd',
            'MozTransition': 'transitionend',
            'OTransition': 'oTransitionEnd otransitionend',
            'msTransition': 'MSTransitionEnd',
            'transition': 'transitionend'
        };
        this.transitionEnd = transEndEventNames[Modernizr.prefixed('transition')];
        var animEndEventNames = {
            'WebkitAnimation': 'webkitAnimationEnd',
            'MozAnimation': 'animationend',
            'OAnimation': 'oAnimationEnd oanimationend',
            'msAnimation': 'MSAnimationEnd',
            'animation': 'animationend'
        };
        this.cssanimationEnd = animEndEventNames[Modernizr.prefixed('animation')];
        if (args.responsive == 1) {
            this.module_id = parseInt(dojo.attr(args.node, 'id').match(/[0-9]+/)[0]);
        }

        // Disable CSS transition for older browsers...
        if (args.css3transition == 1 && (!Modernizr.csstransitions || !Modernizr.csstransforms3d)) {
            args.css3transition = 0;
        }

        if (args.css3animation == 1 && (!Modernizr.cssanimations || !Modernizr.csstransforms3d)) {
            args.css3animation = 0;
        }
        
        if(dojo.isSafari && dojo.isSafari < 6){
            args.css3animation = 0;
            dojo.removeClass(document.body.parentNode, 'nextend-csstransitions');
        }

        this.moduleid = parseInt(dojo.attr(args.node, 'id').replace('mod_smartslider_', ''));

        this.firstRun = 1;
    },

    makeResponsive: function() {
        this.style = dojo.query("link[href*='/mod_smartslider/cache/" + this.moduleid + "/']")[0];
        this.respNormalize = null;
        this.responsiveW = this.originalWidth = parseInt(dojo.position(this.node).w);
        if(this.responsiveW == 0){
            var _this = this;
            setTimeout(function(){
            _this.makeResponsive();
            }, 500);
        }else{
          this.onResponsiveResize();
          dojo.connect(window, 'resize', this, 'onResponsiveResize');
        }
    },

    onResponsiveResize: function() {
        if (this.respNormalize) clearTimeout(this.respNormalize);
        this.respNormalize = setTimeout(dojo.hitch(this, function() {
            var p = dojo.contentBox(this.node.parentNode);
            if(!this.responsivescaleup && p.w > this.originalWidth){
                p.w = this.originalWidth;
            }
            if (this.responsiveW == p.w) {
                if (this.firstRun) {
                    this.runCaption();
                    this.firstRun = 0;
                }
                this.onloaded();
                return;
            }
            this.responsiveW = p.w;
            this.responsiveRatio = p.w / this.originalWidth;
            if (this.style || this.firstRun) {
                var link = document.createElement('link');
                link.type = 'text/css';
                link.rel = 'stylesheet';
                link.w = p.w;
                link.href = this.url + 'index.php?module=' + this.module_id + '&w=' + p.w + '&ow=' + this.originalWidth;
                this.loadCSS(link, dojo.hitch(this, function(link) {
                    if (link.w != this.responsiveW) return;
                    if(this.style) dojo.destroy(this.style);
                    this.style = link;
                    this.onResponsiveCSSLoaded();
                    if (this.firstRun) {
                        this.runCaption();
                        this.firstRun = 0;
                    }
                    this.responsivateCaptions();
                    this.responsivateImages();
                    this.onloaded();
                }));
                document.getElementsByTagName('head')[0].appendChild(link);
            }
        }), 200);
    },

    onloaded: function() {

    },

    responsivateCaptions: function() {
        var cs = this.captions;
        for (var i = 0; i < cs.length; i++) {
            if (!cs[i]) continue;
            if (cs[i].length) {
                for (var j = 0; j < cs[i].length; j++) {
                    if (!cs[i][j]) continue;
                    this.responsivateCaption(cs[i][j]);
                }
            } else {
                this.responsivateCaption(cs[i]);
            }
        }
    },

    responsivateCaption: function(c) {
        c.makeResponsive(this.responsiveRatio);
    },

    responsivateImages: function() {
        for (var i = 0; i < this.resizeImages.length; i++) {
            this.resizeImages[i].resize();
        }
    },

    commonInit: function() {
        var canvasW = 0;
        var canvasH = 0;
        var canvas = dojo.query('.canvas', this.node);
        dojo.every(canvas, function(el) {
            var p = dojo.position(el);
            if (p.w > 0 && p.h > 0) {
                canvasW = p.w;
                canvasH = p.h;
                return false;
            }
            return true;
        });

        if (!Modernizr || !Modernizr.backgroundsize) {
            var onlyBG = dojo.query('.onlybackground', this.node);
            dojo.forEach(onlyBG, function(el) {
                var parent = el.parentNode;
                var src = dojo.style(el, 'backgroundImage').replace(/url\((['"])(.*?)\1\)/gi, '$2').split(',')[0];
                var size = dojo.style(el, 'backgroundSize'); //cover
                var load = function() {
                    if (!this.width) return;
                    switch (size) {
                    case 'contain':
                        if (this.width / this.height < canvasW / canvasH) {
                            dojo.style(this, 'height', '100%');
                            dojo.style(this, 'width', 'auto');
                        } else {
                            dojo.style(this, 'width', '100%');
                            dojo.style(this, 'height', 'auto');
                        }
                        break;
                    default:
                        if (this.width / this.height < canvasW / canvasH) {
                            dojo.style(this, 'width', '100%');
                            dojo.style(this, 'height', 'auto');
                        } else {
                            dojo.style(this, 'height', '100%');
                            dojo.style(this, 'width', 'auto');
                        }
                        break;
                    };
                };
                var img = dojo.create("img", {
                    src: src,
                    load: load,
                    style: 'max-width:none;'
                });
                dojo.hitch(img, load)();
                dojo.place(img, parent);
                dojo.style(el, {
                    position: 'absolute',
                    opacity: 0.001
                });
            });
        }

        this.resizeImages = [];
        if (this.imageresize) {
            for (var i = 0; i < this.resizeableimages.length; i++) {
                var imgs = dojo.query('[src*="' + this.resizeableimages[i] + '"], [style*="' + this.resizeableimages[i] + '"]');
                for(var j = 0; j < imgs.length; j++){
                  var img = imgs[j];
                  if (img) {
                      var size = dojo.position
                      if (img.tagName.toUpperCase() == 'IMG') {
                          this.resizeImages.push(
                          new NextendSmartSliderResizeImage({
                              slider: this,
                              backgroundsize: 'contain',
                              node: img,
                              image: this.resizeableimages[i],
                              changeImage: function(newimage) {
                                  dojo.attr(this.node, 'src', newimage);
                              }
                          }));
                      } else {
                          this.resizeImages.push(
                          new NextendSmartSliderResizeImage({
                              slider: this,
                              backgroundsize: 'cover',
                              node: img,
                              image: this.resizeableimages[i],
                              changeImage: function(newimage) {
                                  dojo.style(this.node, 'backgroundImage', "url('" + newimage + "')");
                              }
                          }));
                      }
                  }
                }
            }
        }
    },

    onResponsiveCSSLoaded: function() {

    },

    loadCSS: function(link, callback) {
        var cssLoaded = false;
        try {
            if (link.sheet && link.sheet.cssRules.length > 0) {
                cssLoaded = true;
            } else if (link.styleSheet && link.styleSheet.cssText.length > 0) {
                cssLoaded = true;
            } else if (link.innerHTML && link.innerHTML.length > 0) {
                cssLoaded = true;
            }
        } catch (ex) {}
        if (cssLoaded) {
            callback(link);
        } else {
            setTimeout(dojo.hitch(this, function() {
                this.loadCSS(link, callback);
            }), 100);
        }
    },
    
    checkCanvasForAutoplay: function(container){
      var canvas = dojo.query('.canvas', container)[0];
      if(canvas.youtube){
        var state = canvas.youtube.getPlayerState();
        if(state == 1 || state == 3){
          return false;
        }
      }
      return true;
    },
    
    goToSlideId: function(id){
      if(this.slideids && this.slideids[id]){
        var index = this.slideids[id];
        if(index.length == 2){
          this.gotoSlide(index[0]+1, index[1]+1);
        }else{
          this.gotoSlide(index[0]+1);
        }
      }
    }
});

dojo.declare("NextendSmartSliderResizeImage", null, {
    constructor: function(args) {
        dojo.mixin(this, args);
        this.resizeUrl = this.slider.url + 'index.php?action=nextendresize';
        this.retina = (window.devicePixelRatio > 1 ? window.devicePixelRatio : 1);
        this.resize();
    },

    resize: function() {
        var availableSize = dojo.contentBox(this.node.parentNode);
        var url = this.resizeUrl;
        url += "&src=" + this.image + "&ct=1&w=" + availableSize.w * this.retina + "&h=" + availableSize.h * this.retina;
        if (this.backgroundsize == 'contain') {
            url += "&zc=2";
        }
        this.resized = new Image();
        this.resized.src = url;
        if (!this.resized.width) {
            dojo.connect(this.resized, 'onload', this, 'onload');
        } else {
            this.onload();
        }
    },

    onload: function() {
        this.changeImage(this.resized.src);
    }
});