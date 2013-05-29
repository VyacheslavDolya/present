dojo.require("dojo.data.ItemFileReadStore");
dojo.require("dijit.Tree");

dojo.declare("ArticlesTree", null, {
	constructor: function(args) {
	  dojo.mixin(this, args);
		this.input = dojo.byId(this.id);
		this.input.loaded = dojo.hitch(this, 'loaded');
		this.container = this.input.parentNode.children[0];
    this.hider = this.container.children[0];
    
		window.panel = dojo.query(".jpane-slider")[0];
	  this.tree = new dijit.Tree({
      dndController: "Offlajn_dndSelector",
			store:new dojo.data.ItemFileReadStore({
				data: {
			    identifier: "id",
			    label: "label",
			    items: this.json
			  }
			}),
			autoExpand: true,
      onLoad: dojo.hitch(this, 'onTreeLoad')
		}, this.node);
    dojo.connect(this.input, 'change', this, 'loadSelected'); 
    
	},
	
	loaded: function(){
    if(this.input.combineobj){
      console.log(this.input.combineobj.fields[0]);
      dojo.connect(this.input.combineobj.fields[0], "onchange", this, "onSwitch");
      this.onSwitch();
    }
  },
  
  onSwitch: function(){
	  var value = this.input.combineobj.fields[0].value;
    if(this.anim) this.anim.stop();
    if(value==0){
      this.anim = dojo.animateProperty({
        node: this.container,
        properties: {
            opacity : 1
        },
        onEnd : dojo.hitch(this,function() {
                  dojo.style(this.hider, "display", "none");
                })
      }).play();
    }else{
      this.anim = dojo.animateProperty({
        node: this.container,
        properties: {
            opacity : 0.15
        },
        onBegin : dojo.hitch(this,function() {
                  dojo.style(this.hider, "display", "block");
                })
      }).play();
    }
  },
  
  onTreeLoad: function(){
    this.loadSelected();
    
    dojo.connect(this.tree.dndController, 'setSelection', this, function(){
      if(this.timer) clearTimeout(this.timer);
      this.timer = setTimeout(dojo.hitch(this, 'saveSelected'), 300);
    });
    
		this.all = dojo.byId(this.node+"-all");
    dojo.connect(this.all, 'click', this.tree.dndController, 'selectAll');
    
		this.none = dojo.byId(this.node+"-none");
    dojo.connect(this.none, 'click', this.tree.dndController, 'selectNone');
    
		this.collapse = dojo.byId(this.node+"-collapse");
    dojo.connect(this.collapse, 'click', this, 'collapseAll');
    
		this.expand = dojo.byId(this.node+"-expand");
    dojo.connect(this.expand, 'click', this, 'expandAll');
  },
  
  loadSelected: function(){
    var s = this._selectedString();
    if(s != this.input.value){
      var selected = dojo.fromJson(this.input.value);
      var map = this.tree._itemNodesMap;
      var dnd = this.tree.dndController;
      for(var i = 0; i < selected.length; i++){
        var node = map[selected[i]][0];
        if(node)
          dnd.addTreeNode(node, true);
      }
    }
  },
  
  saveSelected: function(){
    var s = this._selectedString();
    if(s != this.input.value){
      this.input.value = s;
      this.fireEvent(this.input, 'change');
    }
  },
  
  _selectedString: function(){
    var selected = this.tree.selectedItems;
    var sel = [];
    for(var i = 0; i < selected.length; i++){
      if(selected[i].id)
        sel[i] = selected[i].id[0];
    }
    return dojo.toJson(sel);
  },
  
  collapseAll: function(){
    var map = this.tree._itemNodesMap;
    for(var k in map){
      if(map[k][0] != this.tree.rootNode)
        map[k][0].collapse();
    }
  },
  
  expandAll: function(){
    var map = this.tree._itemNodesMap;
    for(var k in map){
      if(map[k][0] != this.tree.rootNode)
        map[k][0].expand();
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