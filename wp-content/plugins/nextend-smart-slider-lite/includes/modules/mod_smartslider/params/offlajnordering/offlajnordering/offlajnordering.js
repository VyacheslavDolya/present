dojo.declare("OfflajnOrdering", null, {
    constructor: function(args) {
        dojo.mixin(this, args);
        this.getOptions();

        this.prev = this.slide = this.node.selectedIndex;
        this.list = this.node.listobj.list;

        dojo.connect(this.node, 'onchange', this, 'onChange');
    },

    getOptions: function() {
        this.options = this.node.options;
    },

    onChange: function() {
        if (dojo.hasClass(this.node.listobj.itemscontainer, 'selected')) {
            dojo.removeClass(this.node.listobj.itemscontainer, 'selected');
            dojo.addClass(this.list[this.slide], 'selected');
            this.node.value = this.prev;
        } else {
            dojo.removeClass(this.node.listobj.list[this.node.selectedIndex], 'selected');

            if (this.node.selectedIndex < this.prev) {
                dojo.place(this.list[this.slide], this.node.listobj.list[this.node.selectedIndex], "before");
            } else {
                dojo.place(this.list[this.slide], this.node.listobj.list[this.node.selectedIndex], "after");
            }

            this.node.listobj.getList();
            dojo.removeClass(this.list[this.node.selectedIndex], 'selected');
            dojo.addClass(this.list[this.slide], 'selected');
            this.prev = this.node.selectedIndex;
        }
    }

});