dojo.require("dojo.dnd.common");
dojo.require("dijit.tree._dndContainer");
dojo.require("dijit.tree._dndSelector");

dojo.declare("Offlajn_dndSelector",
	dijit.tree._dndSelector,
	{
		userSelect: function(node, multi, range){
      if(this.isTreeNodeSelected(node)){
        this.recurseParentSelection(node, false);
        this.recurseSelection(node, false);
      }else{
        this.recurseSelection(node, true);
      }
		},
    
    recurseSelection: function(node, state){
      var childs = node.getChildren();
      if(childs.length > 0){
        for(var i = 0; i < childs.length; i++){
          this.recurseSelection(childs[i], state);
        }
      }
      this.changeSelectedNode(node, state);
    },
    
    recurseParentSelection: function(node, state){
      var parent = node.getParent();
      if(parent){
        this.recurseParentSelection(parent, state);
        this.changeSelectedNode(parent, state);
      }
    },
    
    changeSelectedNode: function(node, state){
      if(state && !this.isTreeNodeSelected(node))
          this.addTreeNode(node, false);
      else if(!state && this.isTreeNodeSelected(node))
          this.removeTreeNode(node);
    },
    
    selectAll: function(){
      this.recurseSelection(this.tree.rootNode, true);
    }
});
