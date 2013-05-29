dojo.declare("OfflajnTextUnit", null, {
  constructor: function(args){
    dojo.mixin(this, args);
    this.init();
  },
  
  init: function() {
    this.realInput = dojo.byId(this.id);
    this.unit = this.units.split(" ");
    dojo.forEach(this.part = dojo.query(".part",this.id + "_container"),function(element){
      element.text = dojo.query("input[type=text]",element)[0];
      element.unit = dojo.query(".unit span",element)[0];
      dojo.connect(element.text,"onchange",this,"changeValue");
      dojo.connect(element.text,"onfocus",function(){dojo.addClass(element.text,"onfocus")});
      dojo.connect(element.text,"onblur",function(){dojo.removeClass(element.text,"onfocus")});
      dojo.connect(element.unit,"onclick",this,"changeUnit");
      dojo.connect(this.realInput, 'onchange', this, 'setValues');
    },this);
    this.setValues();
  },
  
  changeUnit: function(evt){
    evt.currentTarget.innerHTML = this.getNextUnit(evt.currentTarget.innerHTML);
    this.changeValue();
  },
  
  changeValue: function(){
    this.realInput.value = "";
    dojo.forEach(this.part,function(element){
      this.realInput.value += element.text.value;
      this.realInput.value += (this.attachUnit)? element.unit.innerHTML+" " : " ";
    },this);
    this.realInput.value = this.realInput.value.slice(0,-1);
  },
  
  getNextUnit: function(actUnit){
    var i = 0;
    while (this.unit[i] != actUnit && i < this.unit.length) i++;
    return i+1<this.unit.length ? this.unit[++i] : this.unit[0];
  },
  
  setValues: function() {
    var val = this.realInput.value.split(" ");
    dojo.forEach(this.part,function(element, i){
      element.text.value = val[i].replace(this.unit[0], '');
  }, this);
  }
});