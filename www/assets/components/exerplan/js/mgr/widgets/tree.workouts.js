ExerPlan.tree.Workouts = function(config) {
    config = config || {};

    Ext.QuickTips.init();

    var workoutsTree = new Ext.tree.TreeLoader({
        id: 'exerplan-treeloader-workoutstree',
        dataUrl: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/workouts/getTreeList'
        },
        listeners: {
            load: function(object, node, response) {
                var data = Ext.util.JSON.decode(response.responseText);
                var dataArray = data.results;
                var workoutsTreeCmp = Ext.getCmp('exerplan-tree-workouts');
                var root = workoutsTreeCmp.getRootNode();
                Ext.each(dataArray, function(item, i) {
                    root.appendChild(item);
                });
            }
        }
    });

    Ext.apply(config, {
        id: 'exerplan-tree-workouts',
        xtype: 'treepanel',
        loader: workoutsTree,
        root: {
            nodeType: 'async',
            text: _('exerplan.workouts'),
            draggable: false,
            id: 'workoutsRoot',
            expanded: true
        },
        rootVisible: false,
        tbar: [{
                id: 'exerplan-menu-workoutstree-refresh',
                text: _('exerplan.refresh'),
                handler: this.refreshTree
            }],
        title: _('exerplan.workoutstree.title'),
        autoScroll: true,
        enableDD: false,
        containerScroll: true,
        listeners: {
            click: function(node) {
                return this.galleriesPanel(node);
            },
            render: function() {
                return this.getRootNode().expand(true);
            },
            collapse: function(panel) {
                var contentPanel = Ext.getCmp('exerplan-panel-galleries-content');
                return contentPanel.doLayout();
            },
            expand: function(panel) {
                var contentPanel = Ext.getCmp('exerplan-panel-galleries-content');
                return contentPanel.doLayout();
            }
        }
    });

    ExerPlan.tree.Workouts.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.tree.Workouts, Ext.tree.TreePanel, {
    refreshTree: function() {
        var workoutsTreeCmp = Ext.getCmp('exerplan-tree-workouts');
        return workoutsTreeCmp.getLoader().load(workoutsTreeCmp.root);
    },
    galleriesPanel: function(node) {
        var contentPanel = Ext.getCmp('exerplan-panel-galleries-content');
        contentPanel.removeAll();
        contentPanel.update({
            cls: 'container',
            layout: 'border'
        });

        contentPanel.add({
            xtype: 'exerplan-panel-galleries',
            node: node,
            preventRender: true,
            region: 'center'
        });

        var container = Ext.getCmp('modx-content');

        return container.doLayout();
    }

});
Ext.reg('exerplan-tree-workouts', ExerPlan.tree.Workouts);