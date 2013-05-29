/*
Abstract class for captions
*/

dojo.declare("slidercaption", null, {
    constructor: function(args) {
        var transEndEventNames = {
            'WebkitTransition': 'webkitTransitionEnd',
            'MozTransition': 'transitionend',
            'OTransition': 'oTransitionEnd otransitionend',
            'msTransition': 'MSTransitionEnd',
            'transition': 'transitionend'
        };
        this.transitionEnd = transEndEventNames[Modernizr.prefixed('transition')];

        this.delay = 0;
        this.interval = 400;
        this.hideEasing = 'dojo.fx.easing.linear';
        this.showEasing = 'dojo.fx.easing.linear';
        this.anim = null;
        this.currentValue = 0;
        this.activeslide = 0;
    },

    init: function() {
        if (typeof(this.hideEasing) === 'string') {
            this.cssHideEasing = dojoEasingToCSSEasing(this.hideEasing);
            this.hideEasing = eval(this.hideEasing);
        } else {
            this.cssHideEasing = 'ease';
        }
        if (typeof(this.showEasing) === 'string') {
            this.cssShowEasing = dojoEasingToCSSEasing(this.showEasing);
            this.showEasing = eval(this.showEasing);
        } else {
            this.cssShowEasing = 'ease';
        }

        this.active = 0;

        if (this.css3transition) {
            this.node.addEventListener(this.transitionEnd, dojo.stopEvent);
            this.onAnimate = this.onAnimateTransition;
        }
        var el = dojo.query('.opener', this.node)[0];
        dojo.connect(el, 'onclick', dojo.hitch(this, 'onOpenOrClose'));
        dojo.connect(el, "ontouchstart", this, "touchstart");
        dojo.connect(el, "ontouchmove", this, "touchmove");
        dojo.connect(el, "ontouchend", dojo.stopEvent);
        this.touch = {
            screenX: 0,
            screenY: 0,
            identifier: ''
        };
        this.minval = parseInt(dojo.style(this.node, this.prop)) + 5;
        this.init2();
    },

    init2: function() {},
    // virtual

    slideShowed: function() {
        this.slideShowed2();
        this.activeslide = 1;
    },
    // virtual

    onOpenOrClose: function(e) {
        this.stopAnim();
        var prop = this.currentValue;

        if (prop > this.minval) {
            if (this.css3transition) {
                dojo.style(this.node, Modernizr.prefixed('transition'), 'all ' + this.interval / 1000 + 's ' + this.cssHideEasing + ' ' + this.delay / 1000 + 's');
                this.onAnimate(this.minval);
            } else {
                this.anim = new dojo.Animation({
                    duration: this.interval,
                    onAnimate: dojo.hitch(this, 'onAnimate'),
                    onEnd: dojo.hitch(this, 'enableArrow'),
                    curve: [prop, this.minval],
                    easing: this.hideEasing,
                    delay: this.delay
                });
            }
            dojo.removeClass(this.node, 'opened');
        } else {
            if (this.css3transition) {
                dojo.style(this.node, Modernizr.prefixed('transition'), 'all ' + this.interval / 1000 + 's ' + this.cssShowEasing + ' ' + this.delay / 1000 + 's');
                this.onAnimate(this.value);
            } else {
                this.anim = new dojo.Animation({
                    duration: this.interval,
                    onAnimate: dojo.hitch(this, 'onAnimate'),
                    onBegin: dojo.hitch(this, 'disableArrow'),
                    curve: [prop, this.value],
                    easing: this.showEasing,
                    delay: this.delay
                });
            }
            dojo.addClass(this.node, 'opened');
        }
        if (!this.css3transition) this.anim.play();
    },

    onAnimate: function() {},
    // virtual

    onAnimateTransition: function() {},
    // virtual

    reset: function() {
        this.active = 0;
        this.activeslide = 0;
        this.reset2();
    },

    enableArrow: function() {
        this.active = 0;
        if (this.vertical) this.vertical.displayArrows();
    },

    disableArrow: function() {
        this.active = 1;
        if (this.vertical) this.vertical.displayArrows();
    },

    stopAnim: function() {
        if (this.anim && this.anim.status() == "playing") {
            this.anim.stop();
        }
    },

    touchstart: function(e) {
        if (this.css3transition) {
            dojo.style(this.node, Modernizr.prefixed('transition'), 'all 0s ease 0s');
        }
        dojo.copyTouch(e.changedTouches[0], this.touch);
    },

    touchmove: function(e) {
        dojo.stopEvent(e);
        this.touchmoveAction(e);
        dojo.copyTouch(e.changedTouches[0], this.touch);
    },

    touchmoveAction: function(e) {} // virtual

});

/*
                                From right class
                                */

dojo.declare("slidercaptionfromright", slidercaption, {
    constructor: function(args) {
        this.prop = 'right';
        this.showcaption = 0;
    },

    init2: function() {
        dojo.style(this.node.parentNode, {
            'right': '0px',
            'left': 'auto',
            'display': 'block'
        });
        var el = dojo.query('.content', this.node)[0];
        dojo.style(el, 'width', (this.value - dojo.marginBox(el).w + dojo.contentBox(el).w) + 'px');
        this.value -= 5;
        this.reset2();
    },

    onAnimate: function(e) {
        var px = parseInt(e);
        dojo.style(this.node, this.prop, px + 'px');
        this.currentValue = px;
    },

    onAnimateTransition: function(e) {
        var px = parseInt(e);
        dojo.style(this.node, Modernizr.prefixed('transform'), 'translate3d(' + (-px) + 'px,0,0)');
        this.currentValue = px;
    },

    reset2: function() {
        this.onAnimate(this.minval);
        dojo.removeClass(this.node, 'opened');
    },

    slideShowed2: function() {
        if (this.showcaption == 1) {
            this.onOpenOrClose();
        }
    },

    touchmoveAction: function(e) {
        var v = this.currentValue - (e.changedTouches[0].screenX - this.touch.screenX);
        if (v < this.minval) v = this.minval;
        if (v > this.value) v = this.value;
        this.onAnimate(v);
    },

    makeResponsive: function(ratio) {
        var a = this.activeslide;
        if (!this.bakvalue) this.bakvalue = this.value;
        this.value = this.bakvalue * ratio;
        this.init2();
        if (a) this.slideShowed();
    }
});

/*
                                From bottom class
                                */

dojo.declare("slidercaptionfrombottom", slidercaption, {
    constructor: function(args) {
        this.prop = 'height';
        this.showcaption = 0;
    },

    init2: function() {
        dojo.style(this.node.parentNode, {
            'bottom': '0px',
            'right': '0px',
            'left': 'auto',
            'top': 'auto',
            'display': 'block'
        });
        var el = dojo.query('.content', this.node)[0];
        dojo.style(el, this.prop, (this.value - dojo.marginBox(el).h + dojo.contentBox(el).h) + 'px');
        this.value -= 5;
        this.reset2();
    },

    onAnimate: function(e) {
        var px = parseInt(e);
        dojo.style(this.node, this.prop, px + 'px');
        this.currentValue = px;
    },

    onAnimateTransition: function(e) {
        var px = parseInt(e);
        dojo.style(this.node, Modernizr.prefixed('transform'), 'translate3d(0,' + (-px) + 'px,0)');
        this.currentValue = px;
    },

    reset2: function() {
        this.onAnimate(this.minval);
        dojo.removeClass(this.node, 'opened');
    },

    slideShowed2: function() {
        if (this.showcaption == 1) {
            this.onOpenOrClose();
        }
    },

    touchmoveAction: function(e) {
        var v = this.currentValue - (e.changedTouches[0].screenY - this.touch.screenY);
        if (v < this.minval) v = this.minval;
        if (v > this.value) v = this.value;
        this.onAnimate(v);
    },

    makeResponsive: function(ratio) {
        var a = this.activeslide;
        if (!this.bakvalue) this.bakvalue = this.value;
        this.value = this.bakvalue * ratio;
        this.init2();
        if (a) this.slideShowed();
    }
});


/*
                                Smart caption class
                                */

dojo.declare("slidercaptionsmart", slidercaption, {
    constructor: function(args) {
        this.horizontaloffset = 0;
        this.interval = 400;
        this.easing = 'dojo.fx.easing.linear';
        this.cssEasing = 'ease';
    },

    init: function() {
        if (typeof(this.easing) === 'string') {
            this.cssEasing = dojoEasingToCSSEasing(this.easing);
            this.easing = eval(this.easing);
        }

        if (typeof(this.easing) === 'string') this.easing = eval(this.easing);
        this.top = parseInt(this.top);
        this.horizontaloffset = parseInt(this.horizontaloffset);
        this.w = parseInt(this.w);
        dojo.style(this.node, 'visibility', 'hidden');
        dojo.style(this.node, 'display', 'block');
        dojo.style(this.node.parentNode, 'display', 'block');

        if (this.css3transition) {
            this.node.addEventListener(this.transitionEnd, dojo.stopEvent);
            this.onAnimate = this.onAnimateTransition;
        }
        if (this.mode == "div") {
            this.tag = dojo.query("div.caption-h4", this.node)[0];
            this.title = dojo.query("div.caption-h3", this.node)[0];
        } else {
            this.tag = dojo.query("h4", this.node)[0];
            this.title = dojo.query("h3", this.node)[0];
        }
        if (!this.title) alert('Please fill out the title for this caption!');

        this.autostart = 0;
        this.initalized = 0;
        setTimeout(dojo.hitch(this, 'delayed'), 100);
    },

    delayed: function() {
        var canvas = this.node.parentNode.parentNode;
        this.canvaspos = dojo.position(this.node.parentNode.parentNode);
        if (this.canvaspos.w == 0) {
            this.canvaspos.w = parseInt(dojo.style(canvas, 'width'));
            this.canvaspos.h = parseInt(dojo.style(canvas, 'height'));
        }

        if (this.tag) {
            dojo.style(this.tag, {
                height: 'auto',
                width: 'auto'
            });
            this.tagpos = dojo.contentBox(this.tag);
            dojo.style(this.tag, {
                height: Math.ceil(this.tagpos.h) + 'px',
                width: Math.ceil(this.tagpos.w) + 'px'
            });
            this.tagpos = dojo.position(this.tag);
        } else {
            this.tagpos = {
                w: 0,
                h: 0
            };
        }

        dojo.style(this.title, 'width', this.w + 'px');
        this.titlepos = dojo.position(this.title);


        dojo.style(this.node, 'marginLeft', this.horizontaloffset + 'px');
        this.calcPosition();
        this.reset(true);

        if (this.css3transition) {
            this.node.addEventListener(this.transitionEnd, dojo.stopEvent);
        }

        if (this.autostart) this.onOpenOrClose();
        this.initalized = 1;
    },

    reInitTag: function() {
        if (!this.tag) return;

        this.tagpos = dojo.position(this.tag);
        this.tagpos.w = parseInt(this.tagpos.w);

        if (this.title) dojo.style(this.title, {
            width: 'auto'
        });

        this.titlepos = dojo.position(this.title);
        this.titlepos.w = parseInt(this.titlepos.w);

        this.calcPosition();

        if (this.tag) dojo.style(this.tag, {
            left: Math.ceil(this.tagStart.l) + 'px'
        });

        if (this.title) dojo.style(this.title, {
            top: this.titleStart.t + 'px',
            left: Math.ceil(this.titleStart.l) + 'px'
        });
    },

    calcPosition: function() {},
    // virtual

    slideShowed2: function() {
        if (this.initalized) this.onOpenOrClose();
        else
        this.autostart = 1;
    },

    onOpenOrClose: function(e) {
        this.reInitTag();
        dojo.style(this.node, 'visibility', 'visible');
        if (this.css3transition) {
            if (this.title) dojo.style(this.title, Modernizr.prefixed('transition'), Modernizr.hyphenated('transform') + ' ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's, opacity ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's');
            if (this.tag) dojo.style(this.tag, Modernizr.prefixed('transition'), Modernizr.hyphenated('transform') + ' ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's, opacity ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's');
            this.onAnimate(1);
        } else {
            this.anim = new dojo.Animation({
                duration: this.interval,
                onAnimate: dojo.hitch(this, 'onAnimate'),
                curve: [0, 1],
                easing: this.easing,
                delay: this.delay
            }).play();
        }
    },

    onAnimate: function(e) {
        var tagl = this.tagStart.l + this.tagdist * e;
        var titlel = this.titleStart.l + this.titledist * e;
        if (this.tag) dojo.style(this.tag, {
            left: tagl + 'px',
            opacity: e
        });
        if (this.title) dojo.style(this.title, {
            left: titlel + 'px',
            opacity: e
        });
    },

    onAnimateTransition: function(e) {
        var tagl = this.tagdist * e;
        var titlel = this.titledist * e;
        if (this.tag) {
            if (e == 1) {
                setTimeout(dojo.hitch(this, function() {
                    dojo.style(this.tag, 'opacity', e);
                    dojo.style(this.tag, Modernizr.prefixed('transform'), 'translate3d(' + (tagl) + 'px,0,0)');
                }), 110);
            } else {
                dojo.style(this.tag, 'opacity', e);
                dojo.style(this.tag, Modernizr.prefixed('transform'), 'translate3d(' + (tagl) + 'px,0,0)');
            }
        }
        if (this.title) {
            dojo.style(this.title, 'opacity', e);
            dojo.style(this.title, Modernizr.prefixed('transform'), 'translate3d(' + (titlel) + 'px,0,0)');
        }
    },

    reset: function(starting) {
        this.stopAnim();
        this.active = 0;
        this.activeslide = 0;

        dojo.style(this.node, 'visibility', 'hidden');

        if (this.css3transition) {
            if (this.title) dojo.style(this.title, Modernizr.prefixed('transition'), 'all 0s ease 0s');
            if (this.tag) dojo.style(this.tag, Modernizr.prefixed('transition'), 'all 0s ease 0s');
        }

        this.onAnimate(0);
        if (this.tag) dojo.style(this.tag, {
            left: this.tagStart.l + 'px',
            top: this.tagStart.t + 'px',
            opacity: 0
        });

        if (this.title) dojo.style(this.title, {
            left: this.titleStart.l + 'px',
            top: this.titleStart.t + 'px',
            opacity: 0
        });
    },

    stopAnim: function() {
        if (this.anim && this.anim.status() != "stopped") {
            this.anim.stop();
        }
    },

    makeResponsive: function(ratio) {
        var a = this.activeslide;
        if (!this.baktop) this.baktop = this.top;
        if (!this.bakhorizontaloffset) this.bakhorizontaloffset = this.horizontaloffset;

        if (!this.bakw) this.bakw = this.w;
        this.top = this.baktop * ratio;
        this.horizontaloffset = this.bakhorizontaloffset * ratio;
        this.w = this.bakw * ratio;
        this.init();
        if (a) {
            setTimeout(dojo.hitch(this, 'slideShowed'), 110);
        }
    }
});

dojo.declare("slidercaptiontaglefttitleright", slidercaptionsmart, {
    calcPosition: function() {
        this.tagStart = {
            l: Math.ceil(this.canvaspos.w - this.tagpos.w * 1.2),
            t: this.top
        }

        this.tagEnd = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w)
        }

        this.tagdist = Math.ceil(this.tagEnd.l - this.tagStart.l);

        this.titleStart = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w * 1.5),
            t: Math.ceil(this.top + this.tagpos.h)
        }

        this.titleEnd = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w)
        }
        this.titledist = this.titleEnd.l - this.titleStart.l;
    }
});


dojo.declare("slidercaptiontagrighttitleleft", slidercaptionsmart, {
    calcPosition: function() {
        this.tagStart = {
            l: Math.ceil(this.tagpos.w * 0.8),
            t: this.top
        }

        this.tagEnd = {
            l: Math.ceil(this.titlepos.w - this.tagpos.w)
        }

        this.tagdist = Math.ceil(this.tagEnd.l - this.tagStart.l);

        this.titleStart = {
            l: Math.ceil(this.titlepos.w * 0.5),
            t: parseInt(this.top) + this.tagpos.h
        }

        this.titleEnd = {
            l: 0
        }
        this.titledist = this.titleEnd.l - this.titleStart.l;

    }
});

dojo.declare("slidercaptiontagrighttitleright", slidercaptionsmart, {
    calcPosition: function() {
        this.tagStart = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w * 1.4),
            t: this.top
        }

        this.tagEnd = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w)
        }

        this.tagdist = Math.ceil(this.tagEnd.l - this.tagStart.l);

        this.titleStart = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w * 1.8),
            t: parseInt(this.top) + this.tagpos.h
        }

        this.titleEnd = {
            l: Math.ceil(this.canvaspos.w - this.titlepos.w)
        }
        this.titledist = Math.ceil(this.titleEnd.l - this.titleStart.l);

    }
});

dojo.declare("slidercaptiontaglefttitleleft", slidercaptionsmart, {
    calcPosition: function() {
        this.tagStart = {
            l: Math.ceil(this.titlepos.w * 1.4),
            t: this.top
        }

        this.tagEnd = {
            l: Math.ceil(this.titlepos.w - this.tagpos.w)
        }

        this.tagdist = Math.ceil(this.tagEnd.l - this.tagStart.l);

        this.titleStart = {
            l: Math.ceil(this.titlepos.w),
            t: parseInt(this.top) + this.tagpos.h
        }

        this.titleEnd = {
            l: 0
        }
        this.titledist = Math.ceil(this.titleEnd.l - this.titleStart.l);

    }
});

/*
                                Smart caption class
                                */

dojo.declare("slidercaptiondefault", slidercaption, {
    constructor: function(args) {
        this.interval = 400;
        this.easing = 'dojo.fx.easing.linear';
        this.cssEasing = 'ease';
        this.inClass = '';
    },

    init: function() {
        this.title = dojo.query(".defaultcaption-title", this.node)[0];
        this.description = dojo.query(".defaultcaption-description", this.node)[0];

        if (this.title) dojo.style(this.title, 'visibility', 'hidden');
        if (this.description) dojo.style(this.description, 'visibility', 'hidden');

        if (typeof(this.easing) === 'string') {
            this.cssEasing = dojoEasingToCSSEasing(this.easing);
            this.easing = eval(this.easing);
        }

        if (typeof(this.easing) === 'string') this.easing = eval(this.easing);

        dojo.style(this.node, 'display', 'block');
        dojo.style(this.node.parentNode, 'display', 'block');

        if (this.css3transition) {
            this.node.addEventListener(this.transitionEnd, dojo.stopEvent);
            this.onAnimate = this.onAnimateTransition;

            if (this.parent && this.parent.cssanimationEnd) {
                if (this.title) {
                    dojo.connect(this.title, this.parent.cssanimationEnd, dojo.stopEvent);
                    dojo.style(this.title, Modernizr.prefixed('animationFillMode'), 'both');
                    dojo.style(this.title, Modernizr.prefixed('animationDuration'), (this.interval / 1000) + 's');
                }
                if (this.description) {
                    dojo.connect(this.description, this.parent.cssanimationEnd, dojo.stopEvent);
                    dojo.style(this.description, Modernizr.prefixed('animationFillMode'), 'both');
                    dojo.style(this.description, Modernizr.prefixed('animationDuration'), (this.interval / 1000) + 's');
                    dojo.style(this.description, Modernizr.prefixed('animationDelay'), (this.interval / 3000) + 's');
                }
            }
        }
        this.reset(true);

    },

    slideShowed2: function() {
        this.onOpenOrClose();
    },

    onOpenOrClose: function(e) {
        if (this.title) dojo.style(this.title, 'visibility', 'visible');
        if (this.description) dojo.style(this.description, 'visibility', 'visible');
        if (this.css3transition) {
            if (this.parent && this.parent.css3animationentrance) {
                this.inClass = '';
                if (this.parent.inClass) {
                    this.inClass = this.parent.inClass;
                } else {
                    this.inClass = this.parent.css3animationentrance[Math.floor(Math.random() * this.parent.css3animationentrance.length)];;
                }
                if (this.title) dojo.addClass(this.title, this.inClass);
                if (this.description) dojo.addClass(this.description, this.inClass);
            } else {
                if (this.title) dojo.style(this.title, Modernizr.prefixed('transition'), 'opacity ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's');
                if (this.description) dojo.style(this.description, Modernizr.prefixed('transition'), 'opacity ' + this.interval / 1000 + 's ' + this.cssEasing + ' ' + this.delay / 1000 + 's');
                this.onAnimate(0.999);
            }
        } else {
            this.anim = new dojo.Animation({
                duration: this.interval,
                onAnimate: dojo.hitch(this, 'onAnimate'),
                curve: [0, 0.999],
                easing: this.easing,
                delay: this.delay
            }).play();
        }
    },

    onAnimate: function(e) {
        if (this.title) dojo.style(this.title, {
            opacity: e
        });
        if (this.description) dojo.style(this.description, {
            opacity: e
        });
    },

    onAnimateTransition: function(e) {
        if (this.title) {
            dojo.style(this.title, 'opacity', e);
        }
        if (this.description) {
            dojo.style(this.description, 'opacity', e);
        }
    },

    reset: function(starting) {        
        if (this.parent && this.parent.css3animation) {
            this.activeslide = 0;
            if (this.title) {
                dojo.style(this.title, 'visibility', 'hidden');
                dojo.removeClass(this.title, this.inClass);
            }
            if (this.description) {
                dojo.style(this.description, 'visibility', 'hidden');
                dojo.removeClass(this.description, this.inClass);
            }
        } else {
            this.stopAnim();
            this.active = 0;
            this.activeslide = 0;

            dojo.style(this.node, 'visibility', 'hidden');

            if (this.css3transition) {
                if (this.title) dojo.style(this.title, Modernizr.prefixed('transition'), 'all 0s ease 0s');
                if (this.description) dojo.style(this.description, Modernizr.prefixed('transition'), 'all 0s ease 0s');
            }

            this.onAnimate(0);
        }
    },

    stopAnim: function() {
        if (this.anim && this.anim.status() != "stopped") {
            this.anim.stop();
        }
    },

    makeResponsive: function(ratio) {
        var a = this.activeslide;
        if (!this.baktop) this.baktop = this.top;
        if (!this.bakhorizontaloffset) this.bakhorizontaloffset = this.horizontaloffset;

        if (!this.bakw) this.bakw = this.w;
        this.top = this.baktop * ratio;
        this.horizontaloffset = this.bakhorizontaloffset * ratio;
        this.w = this.bakw * ratio;
        this.init();
        if (a) {
            setTimeout(dojo.hitch(this, 'slideShowed'), 110);
        }
    }
});