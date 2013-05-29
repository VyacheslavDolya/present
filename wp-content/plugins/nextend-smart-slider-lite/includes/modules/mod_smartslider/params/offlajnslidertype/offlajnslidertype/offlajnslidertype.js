
dojo.declare("ThemeConfigurator", null, {
	constructor: function(args) {
	 dojo.mixin(this,args);
	 
	 this.paramstype = dojo.byId('paramstype');
	 dojo.connect(this.paramstype, 'onchange', this, 'changeType');
   
   this.typedetails = dojo.byId('type-details');
   this.typetitle = dojo.byId('type-title');
   
   this.themedetails = dojo.byId('thememanager-details');
   this.themetitle = dojo.byId('thememanager-title');
   
   this.themechooser = dojo.byId('themechooser-details');

   this.changeType();
  },
  
  changeType: function(e){
    if(this.chooserconnect)
      dojo.disconnect(this.chooserconnect);
      
    this.type = this.paramstype.options[this.paramstype.selectedIndex].value;
    
    dojo.addClass(this.typetitle, 'offlajnloading');
    this.typedetails.innerHTML = '';
    var xhrArgs = {
      url: this.url,
      content: {
        'offlajnformrenderer': '1',
        'key': this.data[this.type].html
      },
      load: dojo.hitch(this, function(data){
        dojo.removeClass(this.typetitle, 'offlajnloading');
        this.typedetails.innerHTML = data;

        this.themechooser.innerHTML = this.data[this.type].chooser.html;
        this.chooserconnect = dojo.connect(this.themechooser, 'onchange', this, 'changeTheme');
        eval(this.data[this.type].script);
        
        this.loadExternals(this.typedetails);
        
        dojo.addOnLoad(this, function(){
          this.changeTheme();
        });
        dojo.global.toolTips.connectToolTips(this.typedetails);
      }),
      preventCache: true,
      error: function(error){
      }
    }
    var deferred = dojo.xhrPost(xhrArgs);
    /*
    dojo.byId('type-details').innerHTML = eval('this.data.'+this.type+'.html');
    eval(this.data[this.type].script);
    
    var themechooser = dojo.byId('themechooser-details');
    themechooser.innerHTML = eval('this.data.'+this.type+'.chooser.html');
    this.chooserconnect = dojo.connect(themechooser, 'onchange', this, 'changeTheme');
    dojo.addOnLoad(this,function(){
      this.changeTheme();
    });*/
  },
  
  changeTheme: function(e){
    var paramstheme = dojo.byId('paramstheme');
    this.theme = paramstheme.options[paramstheme.selectedIndex].value;

    dojo.addClass(this.themetitle, 'offlajnloading');
    this.themedetails.innerHTML = '';
    var xhrArgs = {
      url: this.url,
      content: {
        'offlajnformrenderer': '1',
        'key': this.data[this.type].themes[this.theme].html,
        'key2': this.data[this.type].html
      },
      load: dojo.hitch(this, function(data){
        dojo.removeClass(this.themetitle, 'offlajnloading');
        this.themedetails.innerHTML = data;
        this.loadExternals(this.themedetails);
        if(this.cTheme != this.theme || this.type != this.cType){
          this.changeSkin();
        }
        dojo.global.toolTips.connectToolTips(this.themedetails);
      }),
      preventCache: true,
      error: function(error){
      }
    }
    var deferred = dojo.xhrPost(xhrArgs);
  
    /*var paramstheme = dojo.byId('paramstheme');
    this.theme = paramstheme.options[paramstheme.selectedIndex].value;
   
    var themechooser = dojo.byId('thememanager-details');
    themechooser.innerHTML = eval('this.data.'+this.type+'.themes.'+this.theme+'.html');
    eval(eval('this.data.'+this.type+'.themes.'+this.theme+'.script'));*/
  },
  
  changeSkin: function(){
    var el = dojo.byId('paramsskin');
    if(!el) el = dojo.byId('paramsskin');
    if(el.selectedIndex != undefined){
      el.selectedIndex = 1;
      el.value = el.options[el.selectedIndex].value;
      this.fireEvent(el, 'change');
    }else{
      el.changeSkin = dojo.hitch(this, 'changeSkin');
    }
   // changeSkinsthemeskin(el);
  },
  
  loadExternals: function(el){
      window.head = document.getElementsByTagName('head')[0];
      dojo.query('link',el).forEach(function(el){
        dojo.place(el, head);
      });
      dojo.query('script',el).forEach(function(el){
        var fileref=document.createElement('script');
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", dojo.attr(el, 'src'));
        dojo.place(fileref, head);
      });
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
