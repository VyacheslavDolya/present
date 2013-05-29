dojo.require("dojo.window");

dojo.declare("NextendConfigurator", null, {
	constructor: function(args) {
    dojo.mixin(this,args);
    this.container = dojo.query('.nextend-configurator-container', this.node)[0];
    this.containerinner = dojo.query('.nextend-configurator-container-inner', this.node)[0];
    this.showed = false;
    this.onResize();
    dojo.connect(window, 'resize', this, 'onResize');
    
    
    dojo.connect(this.containerinner, 'click', dojo.stopEvent);
    dojo.connect(this.node, 'click', this, 'hideOverlay');
    dojo.connect(this.save, 'click', this, 'hideOverlay');
    dojo.connect(this.button, 'click', this, 'showOverlay');
  },
  
  onResize: function(){
    this.vs = dojo.window.getBox();
    if(this.showed) this.showOverlay();
  },
  
  showOverlay: function(){
    dojo.style(this.node, 'display', 'block');
    var vs = this.vs;
    dojo.contentBox(this.node,{
      w: vs.w,
      h: vs.h
    });
    dojo.marginBox(this.container,{
      w: vs.w,
      h: vs.h
    });
    
    if(this.showed == false) this.onResize();
    this.showed = true;
    setTimeout(dojo.hitch(this,'fireEvent',window, 'resize'), 500);
  },
  
  hideOverlay: function(){
    this.showed = false;
    dojo.style(this.node, 'display', 'none');
    this.message.innerHTML = 'Now you should save the module settings to apply changes!';
  }
});