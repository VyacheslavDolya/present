
        (function(){
var dojo = odojo;

var dijit = odijit;

var dojox = odojox;


dojo.declare("OfflajnCombine", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.fields = new Array();
    this.init();
  },
  
  
  init: function() {
    this.hidden = dojo.byId(this.id);
    //console.log(this.hidden.value);
    dojo.connect(this.hidden, 'onchange', this, 'reset');
    for(var i = 0;i < this.num; i++){
      this.fields[i] = dojo.byId(this.id+i);
      this.fields[i].combineobj = this;
      if(this.fields[i].loaded) this.fields[i].loaded();
      dojo.connect(this.fields[i], 'change', this, 'change');
    }
    this.reset();
    
    this.outer = dojo.byId('offlajncombine_outer' + this.id);
    this.items = dojo.query('.offlajncombinefieldcontainer', this.outer);
    if(this.switcherid) {
      this.switcher = dojo.byId(this.switcherid);
      dojo.connect(this.switcher, 'onchange', this, 'hider');
      this.hider();
    }
  },
  
  reset: function(){
    this.value = this.hidden.value;
    //console.log(this.hidden);
    var values = this.value.split('|*|');
    for(var i = 0;i < this.num; i++){
      if(this.fields[i].value != values[i]){
        this.fields[i].value = values[i];
        this.fireEvent(this.fields[i], 'change');
      }
    }
  },
  
  change: function(){
    var value = '';
    for(var i = 0;i < this.num; i++){
      value+= this.fields[i].value+'|*|';
    }
    this.hidden.value = value;
    this.fireEvent(this.hidden, 'change');
  },
  
  hider: function() {
    var w = dojo.position(this.outer).w;
    if(!this.hiderdiv) { 
      this.hiderdiv = dojo.query('.offlajncombine_hider', this.switcher.parentNode.parentNode.parentNode)[0];
      dojo.style(this.hiderdiv, 'width',  w - 38 + 'px');
    }
    if(this.switcher.value == 0) {
      this.items.forEach(function(item, i){
        if(i >= this.hideafter && item != this.switcher.parentNode.parentNode) dojo.style(item, 'opacity', '0.5');
      }, this);
      if(this.hideafter == 0)
        dojo.style(this.hiderdiv, 'display', 'block');
    } else {
      this.items.forEach(function(item, i){
        if(item != this.switcher.parentNode.parentNode) dojo.style(item, 'opacity', '1');
      }, this);
      if(this.hideafter == 0)
        dojo.style(this.hiderdiv, 'display', 'none');
    }
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  }
});


dojo.declare("OfflajnRadio", null, {
	constructor: function(args) {
	 dojo.mixin(this,args);
   this.selected = -1;
	 this.init();
  },
  
  init: function() {
    this.hidden = dojo.byId(this.id);
    this.hidden.radioobj = this;
    dojo.connect(this.hidden, 'change', this, 'reset');
    this.container = dojo.byId('offlajnradiocontainer' + this.id);
    this.items = dojo.query('.radioelement', this.container);
    if(this.mode == "image") this.imgitems = dojo.query('.radioelement_img', this.container);
    dojo.forEach(this.items, function(item, i){
      if(this.hidden.value == this.values[i]) this.selected = i;
      dojo.connect(item, 'onclick', dojo.hitch(this, 'selectItem', i));
    }, this);
    
    this.reset();
  },
  
  reset: function(){
    var i = this.map[this.hidden.value];
    if(!i) i = 0;
    this.selectItem(i);
  },
  
  selectItem: function(i) {
    if(this.selected == i) {
      if(this.mode == "image") this.changeImage(i);
     return;
    }
    if(this.selected >= 0) dojo.removeClass(this.items[this.selected], 'selected');
    if(this.mode == "image") this.changeImage(i);
    this.selected = i;
    dojo.addClass(this.items[this.selected], 'selected');
    if(this.hidden.value != this.values[this.selected]){
      this.hidden.value = this.values[this.selected];
      this.fireEvent(this.hidden, 'change');
    }
  },
  
  changeImage: function(i) {
    dojo.style(this.imgitems[this.selected], 'backgroundPosition', '0px 0px');
    dojo.style(this.imgitems[i], 'backgroundPosition', '0px -8px');
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  }
});



dojo.declare("OfflajnText", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.init();
  },
  
  
  init: function() {
    this.hidden = dojo.byId(this.id);
    dojo.connect(this.hidden, 'change', this, 'reset');
    
    this.input = dojo.byId(this.id+'input');
    this.switcher = dojo.byId(this.id+'unit');
  
    
    if(this.validation == 'int'){
      dojo.connect(this.input, 'keyup', this, 'validateInt');
      this.validateInt();
    }else if(this.validation == 'float'){
      dojo.connect(this.input, 'keyup', this, 'validateFloat');
      this.validateFloat();
    }
    dojo.connect(this.input, 'onblur', this, 'change');
    if(this.switcher){
      dojo.connect(this.switcher, 'change', this, 'change');
    }else{
      if(this.attachunit != '')
        this.switcher = {'value': this.attachunit, 'noelement':true};
      
    }
    this.container = dojo.byId('offlajntextcontainer' + this.id);
    if(this.mode == 'increment') {
      this.arrows = dojo.query('.arrow', this.container);
      dojo.connect(this.arrows[0], 'onmousedown', dojo.hitch(this, 'mouseDown', 1));
      dojo.connect(this.arrows[1], 'onmousedown', dojo.hitch(this, 'mouseDown', -1));
    }
    dojo.connect(this.input, 'onfocus', this, dojo.hitch(this, 'setFocus', 1));
    dojo.connect(this.input, 'onblur', this, dojo.hitch(this, 'setFocus', 0));
  },
  
  reset: function(e){
    if(this.hidden.value != this.input.value+(this.switcher? '||'+this.switcher.value : '')){
      var v = this.hidden.value.split('||');
      this.input.value = v[0];
      if(this.switcher && this.switcher.noelement != true){
        this.switcher.value = v[1];
        this.fireEvent(this.switcher, 'change');
      }
      if(e) dojo.stopEvent(e);
      this.fireEvent(this.input, 'change');
    }
  },
  
  change: function(){
    this.hidden.value = this.input.value+(this.switcher? '||'+this.switcher.value : '');
    this.fireEvent(this.hidden, 'change');
    if(this.onoff) this.hider();
  },
  
  setFocus: function(mode) {
    if(mode){
      dojo.addClass(this.input.parentNode, 'focus');
    } else {
      dojo.removeClass(this.input.parentNode, 'focus');
    }
  },
  
  hider: function() {
    if(!this.hiderdiv) {
      this.hiderdiv = dojo.create('div', {'class': 'offlajntext_hider'}, this.container);
      dojo.style(this.hiderdiv, 'width', dojo.position(this.container).w + 'px');
    }
    if(parseInt(this.switcher.value)) {
      dojo.style(this.container, 'opacity', '1');
      dojo.style(this.hiderdiv, 'display', 'none');
    } else {
      dojo.style(this.container, 'opacity', '0.5');
      dojo.style(this.hiderdiv, 'display', 'block');
    }
  },
  
  validateInt: function(){
    var val = parseInt(this.input.value, 10);
    if(!val) val = 0;
    this.input.value = val;
  },
  
  validateFloat: function(){
    var val = parseFloat(this.input.value);
    if(!val) val = 0;
    this.input.value = val;
  },
  
  mouseDown: function(m){
    dojo.connect(document, 'onmouseup', this, 'mouseUp');
    var f = dojo.hitch(this, 'modifyValue', m);
    f();
    this.interval = setInterval(f, 200);
  },
  
  mouseUp: function(){
    clearInterval(this.interval);
  },

  modifyValue: function(m) {
    var val = 0;
    if(this.validation == 'int') {
      val = parseInt(this.input.value);
    } else if(this.validation == 'float') {
      val = parseFloat(this.input.value);
    }
    val = val + m*this.scale;
    if(val < 0 && this.minus == 0) val = 0; 
    this.input.value = val;
    this.change();
    this.fireEvent(this.input, 'change');
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  }
});


dojo.declare("OfflajnOnOff", null, {
	constructor: function(args) {
	 dojo.mixin(this,args);
   this.w = 26;
	 this.init();
  },
  
  
  init: function() {
    this.switcher = dojo.byId('offlajnonoff' + this.id);
    this.input = dojo.byId(this.id);
    this.state = parseInt(this.input.value);
    this.click = dojo.connect(this.switcher, 'onclick', this, 'controller');
    if(this.mode == 'button') {
      this.img = dojo.query('.onoffbutton_img', this.switcher);
      if(dojo.hasClass(this.switcher, 'selected')) dojo.style(this.img[0], 'backgroundPosition', '0px -11px'); 
    } else {
      dojo.connect(this.switcher, 'onmousedown', this, 'mousedown');
    }
    dojo.connect(this.input, 'onchange', this, 'setValue');
  },
  
  controller: function() {
    if(!this.mode) {
      if(this.anim) this.anim.stop();
      this.state ? this.setOff() : this.setOn();
    } else if(this.mode == "button") {
      this.state ? this.setBtnOff() : this.setBtnOn();
    }
  },
    
  setBtnOn: function() {
    dojo.style(this.img[0], 'backgroundPosition', '0px -11px');
    dojo.addClass(this.switcher, 'selected');
    this.changeState(1);
  },
  
  setBtnOff: function() {
    dojo.style(this.img[0], 'backgroundPosition', '0px 0px');
    dojo.removeClass(this.switcher, 'selected');
    this.changeState(0);
  },
  
  setValue: function() {
    if(this.state != this.input.value) {
      this.controller();
    }
  },
  
  changeState: function(state){
    if(this.state != state){
      this.state = state;
      this.stateChanged();
    }
  },  
  
  stateChanged: function(){
    this.input.value = this.state;
    this.fireEvent(this.input, 'change'); 
  },
  
  mousedown: function(e){
    this.startState = this.state;
    this.move = dojo.connect(document, 'onmousemove', this, 'mousemove');
    this.up = dojo.connect(document, 'onmouseup', this, 'mouseup');
    this.startX = e.clientX;
  },
  
  mousemove: function(e){
    var x = e.clientX-this.startX;
    if(!this.startState) x-=this.w;
    if(x > 0){
      x = 0;
      this.changeState(1);
    }
    if(x < -1*this.w){
      x = -1*this.w;
      this.changeState(0);
    }
		var str = x+"px 0px";
    dojo.style(this.switcher,"backgroundPosition",str);
  },
  
  mouseup: function(e){
    dojo.disconnect(this.move);
    dojo.disconnect(this.up);
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  },
  
  getBgpos: function() {
    var pos = dojo.style(this.switcher, 'backgroundPosition');
    if(dojo.isIE <= 8){
      pos = dojo.style(this.switcher, 'backgroundPositionX')+' '+dojo.style(this.switcher, 'backgroundPositionY');
    }
    var bgp = pos.split(' ');
    bgp[0] = parseInt(bgp[0]);
    return !bgp[0] ? 0 : bgp[0];
  },
  
  setOn: function() {
    this.changeState(1);
    
    this.anim = new dojo.Animation({
      curve: new dojo._Line(this.getBgpos(),0),
      node: this.switcher,
      onAnimate: function(){
				var str = Math.floor(arguments[0])+"px 0px";
				dojo.style(this.node,"backgroundPosition",str);
			}
    }).play();
  },
  
  
  setOff: function() {
    this.changeState(0);
      
    this.anim = new dojo.Animation({
      curve: new dojo._Line(this.getBgpos(), -1*this.w),
      node: this.switcher,
      onAnimate: function(){
				var str = Math.floor(arguments[0])+"px 0px";
				dojo.style(this.node,"backgroundPosition",str);
			}
    }).play();
  }
  
});


dojo.declare("OfflajnList", null, {
	constructor: function(args) {
    this.fireshow = 0;
    this.map = {};
    this.list = new Array;
	  dojo.mixin(this,args);
    this.showed = 0;
    this.focus = 0;
    this.zindex = 6;
    window.offlajnlistzindex = 10;
    if(this.height) this.height++;
    this.lineHeight = 20;
    this.init();
  },
  
  init: function() { 
    this.hidden = dojo.byId(this.name);
    this.active = this.hidden;
    
    this.hidden.listobj = this;
    this.hidden.options = this.options;
    this.hidden.selectedIndex = this.selectedIndex;

    dojo.connect(this.hidden, 'onchange', this, 'setValue');
    this.change = 0;
    
    this.container = dojo.byId('offlajnlistcontainer' + this.name);
    dojo.style(this.container, 'minWidth', Math.ceil(dojo.style(this.container, 'width')+1)+'px');
    if(dojo.isIE == 7) {
      var span = dojo.query('#offlajnlistcontainer' + this.name + ' span');
      dojo.style(this.container, 'width', dojo.style(span[0], 'width')+30+'px');
    }
    this.offlajnlist = dojo.query('.offlajnlist', this.container)[0];
    
    this.currentText = dojo.query('.offlajnlistcurrent', this.container)[0];
    dojo.connect(this.container, 'onclick', this, 'controller');
    this.options.forEach(function(o, i){
      this.map[o.value] = i;
    },this);
  },
  
  initSelectBox: function(){
    if(this.selectbox) return;
    
    this.selectbox = dojo.create('div', {'id': 'offlajnlistelements' + this.name, 'class': 'offlajnlistelements', 'innerHTML': this.elements }, this.container, "after");
    this.list = dojo.query('.listelement', this.selectbox);
    
    
    this.list.connect('onmouseenter', this, 'addActive');
    
    dojo.style(this.selectbox, {
      opacity: 0,
      display: 'block'
    });
    
    this.lineHeight = dojo.position(this.list[0]).h;
    dojo.style(this.selectbox, {
      height: (this.height) ? this.height * this.lineHeight + 'px' : 'auto'
    });
    
    if(this.height) {
      this.content = dojo.query('#offlajnlistelements' + this.name + ' .content')[0];
      dojo.style(this.content, 'height', this.list.length * this.lineHeight + 'px');
      this.scrollbar = new OfflajnScroller({
        'extraClass': 'single-select',
        'selectbox': this.selectbox,
        'content': this.content
      });
    }
    
    this.maxW = 0;
    this.list.forEach(function(el, i){
      if (this.options[i].value == 'optgroup') dojo.addClass(el, "optgroup");
      el.i = i;
    },this);
    
    this.list.connect('onclick', this, 'selected');
    
    this.selectbox.h = dojo.marginBox(this.selectbox).h;
    dojo.style(this.selectbox, {
      height: 0
    });
    dojo.connect(document, 'onclick', this, 'blur');
    dojo.connect(this.selectbox, 'onclick', this, 'focused');
    
    if(this.fireshow)
      this.fireEvent(this.hidden, 'click');
  },
  
  controller: function(){
    this.focused();
    this.initSelectBox();
    if(this.showed == 0){
      this.reposition();
      this.showList();
    }else{
      this.hideList();
    }
  },
  
  reposition: function(){
    var pos = dojo.coords(this.container, true);
    if(this.selectbox){
      dojo.style(this.selectbox, {
        left: pos.l + "px",
        top: pos.t + pos.h  + "px",
        width: pos.w -2 +"px" //-2px because of the side-borders
      });
      if(this.content) {
        dojo.style(this.content,{
        
         'width': pos.w - 12 + 'px',
         'float': 'left'
         });
      }
    }
  },
  
  showList: function(){
    if(this.anim) this.anim.stop();
    this.showed = 1;
    dojo.addClass(this.container,'openedlist');
    dojo.addClass(this.selectbox,'openedlist');
    dojo.removeClass(this.active,'active');
    dojo.addClass(this.list[this.hidden.selectedIndex],'selected active');
    if(this.height) {
      var p = this.hidden.selectedIndex * this.lineHeight;
      this.scrollbar.setPosition(p);
    }
    this.active = this.list[this.hidden.selectedIndex];
    
    dojo.style(this.offlajnlist, 'zIndex', ++window.offlajnlistzindex);
    dojo.style(this.selectbox, {
      display: 'block',
      zIndex: window.offlajnlistzindex-1
    });
    window.offlajnlistzindex++;
    
    this.anim = dojo.animateProperty({
      node: this.selectbox,
      properties: {
          opacity : 1,
          height: this.selectbox.h
      }
    }).play();
  },
  
  hideList: function(){
    if(this.anim) this.anim.stop();
    if(!this.selectbox) return;
    
    this.showed = 0;

    var h = dojo.marginBox(this.selectbox).h;
    dojo.removeClass(this.container,'openedlist');
    this.anim = dojo.animateProperty({
      node: this.selectbox,
      properties: {
          opacity : 0,
          height: 0
      },
      onEnd: dojo.hitch(this, function(el){
        dojo.style(el, {
          display: 'none',
          height: '0',
          zIndex: this.zindex-1
        });
        dojo.style(this.offlajnlist, 'zIndex', this.zindex);
        dojo.removeClass(this.selectbox,'openedlist');
      })
    }).play();
  },
  
  selected: function(e){
    if (dojo.hasClass(e.currentTarget, 'optgroup')) return;
    if(this.list[this.hidden.selectedIndex])
      dojo.removeClass(this.list[this.hidden.selectedIndex],'selected active');
    this.hidden.selectedIndex = e.target.i;
    this.hidden.value = this.hidden.options[this.hidden.selectedIndex].value;
    
    this.currentText.innerHTML = this.hidden.options[this.hidden.selectedIndex].text;
    if(this.list[this.hidden.selectedIndex])
      dojo.addClass(this.list[this.hidden.selectedIndex],'selected active');
    this.hideList();
    this.fireEvent(this.hidden, 'change');
    this.change = 0;
  },
  
  addActive: function(e){
    var el = e.target;
    if(el != this.active){
      dojo.removeClass(this.active,'active');
      dojo.addClass(el,'active');
      this.active = el;
    }
  },

  focused: function(){
    this.focus = 1;
  },

  blur: function(e){
    if(!this.focus){
      this.hideList();
    }
    this.focus = 0;
  },

  setValue: function(e) {
    if(!this.change && this.map[this.hidden.value] != this.hidden.selectedIndex) {
      this.change = 1;
      e.target.i = this.map[this.hidden.value] ? this.map[this.hidden.value] : 0;
      this.selected(e);
    }
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  }
});

dojo.declare("OfflajnScroller", null, {
	constructor: function(args) {
   this.scrollspeed = 10;
   this.curr = 0;
	 dojo.mixin(this,args);
	 this.initScrollbar();
  },
  
  initScrollbar: function() {
    (!dojo.isMozilla) ? dojo.connect(this.selectbox, 'onmousewheel', this, 'scrollWheel') : dojo.connect(this.selectbox, 'DOMMouseScroll', this, 'scrollWheel');
    var right = dojo.create('div', {'class': 'gk_hack offlajnscrollerright'}, this.selectbox);
    this.sc = dojo.create('div', {'class': 'gk_hack offlajnscrollerbg'}, right);
    this.scrollbg = dojo.create('div', {'class': 'gk_hack offlajnscrollerscrollbg'}, this.sc);
    this.scrollbtn = dojo.create('div', {'class': 'gk_hack offlajnscrollerscrollbtn'} ,this.sc );
    if(this.extraClass) {
      dojo.addClass(right, this.extraClass);
      dojo.addClass(this.sc, this.extraClass);
      dojo.addClass(this.scrollbg, this.extraClass);
      dojo.addClass(this.scrollbtn, this.extraClass);
    }
    if(this.extraClass == 'multi-select') {
      this.scrollup = dojo.create('div', {'class': 'gk_hack offlajnscrollerarrowup'}, this.sc, 'first');
      this.scrolldown = dojo.create('div', {'class': 'gk_hack offlajnscrollerarrowdown' }, this.sc, 'last');     
      this.scrupc = dojo.connect(this.scrollup, 'onmousedown', this, 'upScroll');
      this.scrdownc = dojo.connect(this.scrolldown, 'onmousedown', this, 'downScroll');   
    }    
    dojo.connect(this.scrollbtn, 'onmousedown', this, 'onscrolldown');
    dojo.connect(this.scrollbg, 'onclick', this, 'scrollTo');
    this.scrbg = dojo.position(this.scrollbg, true);
    this.scrollbtnprop = dojo.position(this.scrollbtn, true);
    
    this.scrollReInit();
  },
  
  scrollReInit: function(){
    dojo.style(this.scrollbtn, 'display', 'block');
    this.maxHeight = parseInt(dojo.position(this.content).h);
    this.windowHeight = parseInt(dojo.style(this.selectbox, 'height'));
    this.scrollRatio = this.maxHeight/this.windowHeight;
    
    this.maxTop = -1 * (this.maxHeight-this.windowHeight);
    if(this.maxTop > 0) this.maxTop = 0;
    var scrollArrowHeight = 0;
    this.scrollHeight = 0;
    var marginVertical = dojo.marginBox(this.scrollbg).h-dojo.position(this.scrollbg).h;
    if(this.extraClass == 'multi-select') {
      scrollArrowHeight = dojo.marginBox(this.scrollup).h;
      this.scrollHeight = (this.windowHeight+(-2*scrollArrowHeight-marginVertical-2));
      this.scrollBtnmaxTop = (this.scrollHeight-this.scrollHeight/this.scrollRatio)-2;
    } else {
      this.scrollHeight = (this.windowHeight-10);
      this.scrollBtnmaxTop = (this.scrollHeight-this.scrollHeight/this.scrollRatio);
    }
    dojo.style(this.scrollbg, 'height', this.scrollHeight+'px');
    var scrollBtn = (this.scrollHeight/this.scrollRatio-2);
    if(scrollBtn<10){
      scrollBtn = 10;
      this.scrollBtnmaxTop = (this.scrollHeight-scrollBtn-2);
    }
    this.scrollBtnH = scrollBtn;
    dojo.style(this.scrollbtn, 'height', scrollBtn+'px');
    if(this.scrollBtnmaxTop < 0) this.scrollBtnmaxTop = 0; 
    if(this.windowHeight > this.maxHeight) this.hideScrollBtn();  
  },
  
  hideScrollBtn: function() {
    dojo.style(this.scrollbtn, 'display', 'none');
  },
  
  goToBottom: function(){
    this.scrolling(-1000,1000);
  },
  
  onscrolldown: function(e) {
    this.scrdown = 1;
    this.currentpos = e.clientY;
    this.scrbtnpos = dojo.style(this.scrollbtn, 'top');
    this.mousemove = dojo.connect(document, 'onmousemove', this, 'onscrollmove');
    this.mouseup = dojo.connect(document, 'onmouseup', this, 'mouseUp');
  },
  
  onscrollmove: function(e) {
    var diff = this.currentpos-e.clientY;
    if(diff == 0) return;
    var lastt = (dojo.style(this.scrollbtn, 'top'));
    var pos = dojo.style(this.content, 'top');
    this.scrolling(diff, 	(((lastt-diff)/this.scrollBtnmaxTop)*this.maxTop-pos)/diff);
    this.currentpos = e.clientY;
  },
  
  scrollTo: function(e) {
    var pos = e.clientY;
    var sc = dojo.position(this.scrollbg);
    var currpos = pos - sc.y;    
    if(currpos < this.maxTop) currpos = maxTop; 
    if(currpos > this.scrollBtnmaxTop) currpos = this.scrollBtnmaxTop;
    dojo.style(this.scrollbtn, 'top', currpos + 'px');
    var scroll = -1*currpos * this.scrollRatio;
    dojo.style(this.content, 'top', scroll + 'px');
  },
  
  setPosition: function(p) {
    var pos = -1*p;
    if(pos < this.maxTop) pos = this.maxTop;
    this.setScrollBtn(pos);
    dojo.style(this.content, 'top', pos + 'px');
  },
  
  onscrollup: function(e) {
    e.stopPropagation();
    this.scrdown = 0;
  },
  
  upScroll: function(e) {
    this.mouseup = dojo.connect(document, 'onmouseup', this, 'mouseUp');
    e.stopPropagation();
    this.btnScroll(1);
  },
  
  downScroll: function(e) {
    this.mouseup = dojo.connect(document, 'onmouseup', this, 'mouseUp');
    e.stopPropagation();
    this.btnScroll(-1);
  },
  
  btnScroll: function(direction){
    this.dscr = 1;
    var fn = dojo.hitch(this, 'scrolling', direction, this.scrollspeed/4);
    fn();
    this.inter = window.setInterval(fn, 50);
  },
    
  scrolling: function(p, ratio) {
    if(ratio == undefined) ratio = this.scrollspeed;
    var pos = dojo.style(this.content, 'top');
    var scr = pos + (p * ratio);

    
    if(scr < this.maxTop) scr = this.maxTop;
    if(scr > 0) scr = 0;
    dojo.style(this.content, 'top', scr + 'px');
   
    this.setScrollBtn(scr);
    this.curr = scr;
    this.onScroll();
  },
  
  onScroll: function(){
  
  },
    
  setScrollBtn: function(val) {
    var top = (this.scrollBtnmaxTop*(val/this.maxTop));
    dojo.style(this.scrollbtn, 'top', top+'px');
  },
  
  mouseUp: function(e) {
    if(this.mousemove)
      dojo.disconnect(this.mousemove);
    if(this.mouseup)
      dojo.disconnect(this.mouseup);
    e.stopPropagation();
    this.inter = window.clearInterval(this.inter);
    if( this.dscr == 1) {
      this.dscr = 0;
    }
  },
  
  scrollWheel: function(e) {
    var pos = 0;
    pos = (e.detail != "") ? e.detail : e.wheelDelta;  
    if(dojo.isMozilla || dojo.isOpera) {  
      if (pos < 0) {
        this.scrolling(1);
      } else {
        this.scrolling(-1);
      }
    } else {
      if (pos < 0) {
        this.scrolling(-1);
      } else {
        this.scrolling(1);
      }
    }
    dojo.stopEvent(e);
  }
  
});


dojo.declare("OfflajnSwitcher", null, {
	constructor: function(args) {
	 dojo.mixin(this,args);
   this.w = 11;
	 this.init();
  },
  
  
  init: function() {
    this.switcher = dojo.byId('offlajnswitcher_inner' + this.id);
    this.input = dojo.byId(this.id);
    this.state = this.map[this.input.value];
    this.click = dojo.connect(this.switcher, 'onclick', this, 'controller');
    dojo.connect(this.input, 'onchange', this, 'setValue');
    this.elements = new Array();
    this.getUnits();
    this.setSwitcher();
  },
  
  getUnits: function() {
    var units = dojo.create('div', {'class': 'offlajnswitcher_units' }, this.switcher.parentNode, "after");
    dojo.forEach(this.units, function(item, i){
      this.elements[i] = dojo.create('span', {'class': 'offlajnswitcher_unit', 'innerHTML': item }, units);
      if(this.mode) {
        this.elements[i].innerHTML = '';
        this.elements[i] = dojo.create('img', {'src': this.url + item }, this.elements[i]);
      }     
      this.elements[i].i = i;
      dojo.connect(this.elements[i], 'onclick', this, 'selectUnit');
    }, this);
  },
  
  getBgpos: function() {
    var pos = dojo.style(this.switcher, 'backgroundPosition');
    if(dojo.isIE <= 8){
      pos = dojo.style(this.switcher, 'backgroundPositionX')+' '+dojo.style(this.switcher, 'backgroundPositionY');
    }
    var bgp = pos.split(' ');
    bgp[1] = parseInt(bgp[1]);
    return !bgp[1] ? 0 : bgp[1];
  },
  
  selectUnit: function(e) {
    this.state = (e.target.i) ? 0 : 1;
    this.controller();
  },
  
  setSelected: function() {
    var s = (this.state) ? 0 : 1;
    dojo.removeClass(this.elements[s], 'selected');
    dojo.addClass(this.elements[this.state], 'selected');
  },
  
  controller: function() {
    if(this.anim) this.anim.stop();
    this.state ? this.setSecond() : this.setFirst();
  },
  
  
  setValue: function() {
    if(this.values[this.state] != this.input.value) {
      this.controller();
    }
  },
  
  setSwitcher: function() {
    (this.state) ? this.setFirst() : this.setSecond();
  },
  
  changeState: function(state){
    if(this.state != state){
      this.state = state;
      this.stateChanged();
    }
    this.setSelected();
  },  
  
  stateChanged: function(){
    this.input.value = this.values[this.state];
    this.fireEvent(this.input, 'change'); 
  },

  fireEvent: function(element,event){
    if ((document.createEventObject && !dojo.isIE) || (document.createEventObject && dojo.isIE && dojo.isIE < 9)){
      var evt = document.createEventObject();
      return element.fireEvent('on'+event,evt);
    }else{
      var evt = document.createEvent("HTMLEvents");
      evt.initEvent(event, true, true );
      return !element.dispatchEvent(evt);
    }
  },
  
  setFirst: function() {
    this.changeState(1);
    var bgp = this.getBgpos();
    this.anim = new dojo.Animation({
      curve: new dojo._Line(bgp, 0),
      node: this.switcher,
      duration: 200,
      onAnimate: function(){
				var str = "center " + Math.floor(arguments[0])+"px";
				dojo.style(this.node,"backgroundPosition",str);
			}
    }).play();
  },
  
  
  setSecond: function() {
    this.changeState(0);  
    var bgp = this.getBgpos();
    this.anim = new dojo.Animation({
      curve: new dojo._Line(bgp, -1*this.w),
      node: this.switcher,
      duration: 200,
      onAnimate: function(){
				var str =  "center " + Math.floor(arguments[0])+"px";
				dojo.style(this.node,"backgroundPosition",str);
			}
    }).play();
  }
  
});

dojo.declare("NextendWPImagemanager", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.init();
  },
  
  init: function() {
    this.hidden = dojo.byId(this.id);
    this.btn = dojo.byId(this.id+'_wp');
    dojo.connect(this.btn, 'click', this, 'new_im_MediaPopupHandler');
  },
  
  new_im_MediaPopupHandler: function (){
  
  	window.send_to_editor = dojo.hitch(this,'loadImage');
  
  	tb_show('', this.admin_url+'media-upload.php?type=image&TB_iframe=true&width=640&height=500');
  	return false;
  },
  
  loadImage: function(html){
    var html = jQuery(html);
    var img = html;
    if(html[0].tagName != 'IMG'){
  		img = jQuery('img',html);
		}
		this.setValue(img.attr('src'));
    
		tb_remove();
  },
  
  setValue: function(image){
    this.hidden.value = image;
    jQuery(this.hidden).trigger('change');
  }
  
});
dojo.addOnLoad(function(){
      new OfflajnRadio({
        id: "paramssize0",
        values: ["0","1"],
        map: [0,1],
        mode: ""
      });
    

      new OfflajnText({
        id: "paramssize1",
        validation: "int",
        attachunit: "px",
        mode: "",
        scale: "",
        minus: 0,
        onoff: ""
      }); 
    

      new OfflajnText({
        id: "paramssize2",
        validation: "int",
        attachunit: "px",
        mode: "",
        scale: "",
        minus: 0,
        onoff: ""
      }); 
    

      new OfflajnCombine({
        id: "paramssize",
        num: 3,
        switcherid: "",
        hideafter: "0"
      }); 
    

      new OfflajnOnOff({
        id: "paramsmousescroll",
        mode: "",
        imgs: ""
      }); 
    

      new OfflajnList({
        name: "paramsshowdots",
        elements: "<div class=\"content\"><div class=\"listelement\">Disabled<\/div><div class=\"listelement\">Dots<\/div><div class=\"listelement\">Dots with numbers<\/div><div class=\"listelement\">Arrows<\/div><div class=\"listelement\">Arrows with numbers<\/div><\/div>",
        options: [{"value":"0","text":"Disabled"},{"value":"1","text":"Dots"},{"value":"4","text":"Dots with numbers"},{"value":"2","text":"Arrows"},{"value":"3","text":"Arrows with numbers"}],
        selectedIndex: 1,
        height: 0,
        fireshow: 0
      });
    

      new OfflajnText({
        id: "paramsautoplay0",
        validation: "int",
        attachunit: "ms",
        mode: "",
        scale: "",
        minus: 0,
        onoff: ""
      }); 
    

      new OfflajnList({
        name: "paramsautoplay1",
        elements: "<div class=\"content\"><div class=\"listelement\">Stop autoplay on mouse enter<\/div><div class=\"listelement\">Restart autoplay when mouse leave<\/div><div class=\"listelement\">Never stop autoplay<\/div><\/div>",
        options: [{"value":"0","text":"Stop autoplay on mouse enter"},{"value":"1","text":"Restart autoplay when mouse leave"},{"value":"2","text":"Never stop autoplay"}],
        selectedIndex: 1,
        height: 0,
        fireshow: 0
      });
    
dojo.addOnLoad(function(){ 
      new OfflajnSwitcher({
        id: "paramsautoplay2",
        units: ["ON","OFF"],
        values: ["1","0"],
        map: {"1":0,"0":1},
        mode: 0,
        url: "http:\/\/localhost\/present\/wp-admin\/..\/modules\/mod_smartslider\/params\/offlajnswitcher\/images\/"
      }); 
    });

      new OfflajnCombine({
        id: "paramsautoplay",
        num: 3,
        switcherid: "paramsautoplay2",
        hideafter: "0"
      }); 
    

      new OfflajnText({
        id: "paramsmainanimation0",
        validation: "int",
        attachunit: "ms",
        mode: "",
        scale: "",
        minus: 0,
        onoff: ""
      }); 
    

      new OfflajnList({
        name: "paramsmainanimation1",
        elements: "<div class=\"content\"><div class=\"listelement\">Linear<\/div><div class=\"listelement\">Quad In<\/div><div class=\"listelement\">Quad Out<\/div><div class=\"listelement\">Quad In Out<\/div><div class=\"listelement\">Cubic In<\/div><div class=\"listelement\">Cubic Out<\/div><div class=\"listelement\">Cubic In Out<\/div><div class=\"listelement\">Quart In<\/div><div class=\"listelement\">Quart Out<\/div><div class=\"listelement\">Quart In Out<\/div><div class=\"listelement\">Quint In<\/div><div class=\"listelement\">Quint Out<\/div><div class=\"listelement\">Quint In Out<\/div><div class=\"listelement\">Sine In<\/div><div class=\"listelement\">Sine Out<\/div><div class=\"listelement\">Sine In Out<\/div><div class=\"listelement\">Expo In<\/div><div class=\"listelement\">Expo Out<\/div><div class=\"listelement\">Expo In Out<\/div><div class=\"listelement\">Circ In<\/div><div class=\"listelement\">Circ Out<\/div><div class=\"listelement\">Circ In Out<\/div><div class=\"listelement\">Back In<\/div><div class=\"listelement\">Back Out<\/div><div class=\"listelement\">Back In Out<\/div><div class=\"listelement\">Bounce In<\/div><div class=\"listelement\">Bounce Out<\/div><div class=\"listelement\">Bounce In Out<\/div><\/div>",
        options: [{"value":"dojo.fx.easing.linear","text":"Linear"},{"value":"dojo.fx.easing.quadIn","text":"Quad In"},{"value":"dojo.fx.easing.quadOut","text":"Quad Out"},{"value":"dojo.fx.easing.quadInOut","text":"Quad In Out"},{"value":"dojo.fx.easing.cubicIn","text":"Cubic In"},{"value":"dojo.fx.easing.cubicOut","text":"Cubic Out"},{"value":"dojo.fx.easing.cubicInOut","text":"Cubic In Out"},{"value":"dojo.fx.easing.quartIn","text":"Quart In"},{"value":"dojo.fx.easing.quartOut","text":"Quart Out"},{"value":"dojo.fx.easing.quartInOut","text":"Quart In Out"},{"value":"dojo.fx.easing.quintIn","text":"Quint In"},{"value":"dojo.fx.easing.quintOut","text":"Quint Out"},{"value":"dojo.fx.easing.quintInOut","text":"Quint In Out"},{"value":"dojo.fx.easing.sineIn","text":"Sine In"},{"value":"dojo.fx.easing.sineOut","text":"Sine Out"},{"value":"dojo.fx.easing.sineInOut","text":"Sine In Out"},{"value":"dojo.fx.easing.expoIn","text":"Expo In"},{"value":"dojo.fx.easing.expoOut","text":"Expo Out"},{"value":"dojo.fx.easing.expoInOut","text":"Expo In Out"},{"value":"dojo.fx.easing.circIn","text":"Circ In"},{"value":"dojo.fx.easing.circOut","text":"Circ Out"},{"value":"dojo.fx.easing.circInOut","text":"Circ In Out"},{"value":"dojo.fx.easing.backIn","text":"Back In"},{"value":"dojo.fx.easing.backOut","text":"Back Out"},{"value":"dojo.fx.easing.backInOut","text":"Back In Out"},{"value":"dojo.fx.easing.bounceIn","text":"Bounce In"},{"value":"dojo.fx.easing.bounceOut","text":"Bounce Out"},{"value":"dojo.fx.easing.bounceInOut","text":"Bounce In Out"}],
        selectedIndex: 6,
        height: 10,
        fireshow: 0
      });
    

      new OfflajnCombine({
        id: "paramsmainanimation",
        num: 2,
        switcherid: "",
        hideafter: "0"
      }); 
    

      new OfflajnText({
        id: "paramssecondaryanimation0",
        validation: "int",
        attachunit: "ms",
        mode: "",
        scale: "",
        minus: 0,
        onoff: ""
      }); 
    

      new OfflajnList({
        name: "paramssecondaryanimation1",
        elements: "<div class=\"content\"><div class=\"listelement\">Linear<\/div><div class=\"listelement\">Quad In<\/div><div class=\"listelement\">Quad Out<\/div><div class=\"listelement\">Quad In Out<\/div><div class=\"listelement\">Cubic In<\/div><div class=\"listelement\">Cubic Out<\/div><div class=\"listelement\">Cubic In Out<\/div><div class=\"listelement\">Quart In<\/div><div class=\"listelement\">Quart Out<\/div><div class=\"listelement\">Quart In Out<\/div><div class=\"listelement\">Quint In<\/div><div class=\"listelement\">Quint Out<\/div><div class=\"listelement\">Quint In Out<\/div><div class=\"listelement\">Sine In<\/div><div class=\"listelement\">Sine Out<\/div><div class=\"listelement\">Sine In Out<\/div><div class=\"listelement\">Expo In<\/div><div class=\"listelement\">Expo Out<\/div><div class=\"listelement\">Expo In Out<\/div><div class=\"listelement\">Circ In<\/div><div class=\"listelement\">Circ Out<\/div><div class=\"listelement\">Circ In Out<\/div><div class=\"listelement\">Back In<\/div><div class=\"listelement\">Back Out<\/div><div class=\"listelement\">Back In Out<\/div><div class=\"listelement\">Bounce In<\/div><div class=\"listelement\">Bounce Out<\/div><div class=\"listelement\">Bounce In Out<\/div><\/div>",
        options: [{"value":"dojo.fx.easing.linear","text":"Linear"},{"value":"dojo.fx.easing.quadIn","text":"Quad In"},{"value":"dojo.fx.easing.quadOut","text":"Quad Out"},{"value":"dojo.fx.easing.quadInOut","text":"Quad In Out"},{"value":"dojo.fx.easing.cubicIn","text":"Cubic In"},{"value":"dojo.fx.easing.cubicOut","text":"Cubic Out"},{"value":"dojo.fx.easing.cubicInOut","text":"Cubic In Out"},{"value":"dojo.fx.easing.quartIn","text":"Quart In"},{"value":"dojo.fx.easing.quartOut","text":"Quart Out"},{"value":"dojo.fx.easing.quartInOut","text":"Quart In Out"},{"value":"dojo.fx.easing.quintIn","text":"Quint In"},{"value":"dojo.fx.easing.quintOut","text":"Quint Out"},{"value":"dojo.fx.easing.quintInOut","text":"Quint In Out"},{"value":"dojo.fx.easing.sineIn","text":"Sine In"},{"value":"dojo.fx.easing.sineOut","text":"Sine Out"},{"value":"dojo.fx.easing.sineInOut","text":"Sine In Out"},{"value":"dojo.fx.easing.expoIn","text":"Expo In"},{"value":"dojo.fx.easing.expoOut","text":"Expo Out"},{"value":"dojo.fx.easing.expoInOut","text":"Expo In Out"},{"value":"dojo.fx.easing.circIn","text":"Circ In"},{"value":"dojo.fx.easing.circOut","text":"Circ Out"},{"value":"dojo.fx.easing.circInOut","text":"Circ In Out"},{"value":"dojo.fx.easing.backIn","text":"Back In"},{"value":"dojo.fx.easing.backOut","text":"Back Out"},{"value":"dojo.fx.easing.backInOut","text":"Back In Out"},{"value":"dojo.fx.easing.bounceIn","text":"Bounce In"},{"value":"dojo.fx.easing.bounceOut","text":"Bounce Out"},{"value":"dojo.fx.easing.bounceInOut","text":"Bounce In Out"}],
        selectedIndex: 6,
        height: 10,
        fireshow: 0
      });
    

      new OfflajnCombine({
        id: "paramssecondaryanimation",
        num: 2,
        switcherid: "",
        hideafter: "0"
      }); 
    

      new OfflajnOnOff({
        id: "paramsslidenumbering",
        mode: "",
        imgs: ""
      }); 
    

      new OfflajnOnOff({
        id: "paramsslideicons",
        mode: "",
        imgs: ""
      }); 
    

          new NextendWPImagemanager({
            id: "paramsshadow",
            admin_url: "http://localhost/present/wp-admin/"
          });
      });
      djConfig = {};})();