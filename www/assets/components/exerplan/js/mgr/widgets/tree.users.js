ExerPlan.tree.Users = function(config) {
    config = config || {};

    Ext.QuickTips.init();

    var usersTree = new Ext.tree.TreeLoader({
        id: 'exerplan-treeloader-userstree',
        dataUrl: ExerPlan.config.connectorUrl,
        baseParams: {
            action: 'mgr/usergroups/getList'
        },
        listeners: {
            load: function(object, node, response) {
                if (node.attributes.id === 'usersRoot') {
                    var data = Ext.util.JSON.decode(response.responseText);
                    var dataArray = data.results;
                    var usersTreeCmp = Ext.getCmp('exerplan-tree-users');
                    var root = usersTreeCmp.getRootNode();
                    Ext.each(dataArray, function(user, i) {
                        root.appendChild(user);
                    });
                } else {
                    var childData = Ext.util.JSON.decode(response.responseText);
                    var childDataArray = childData.results;
                    Ext.each(childDataArray, function(child, i) {
                        node.appendChild(child);
                    });
                }
                /* overide the loader */
                this.baseParams = {
                    action: 'mgr/users/getList'
                };
            },
            beforeload: function(object, node, callback) {
                if (node.attributes.id !== 'usersRoot') {
                    this.baseParams.ugid = node.attributes.ugid;
                }
            }
        }
    });

    Ext.apply(config, {
        id: 'exerplan-tree-users',
        xtype: 'treepanel',
        loader: usersTree,
        root: {
            nodeType: 'async',
            text: _('exerplan.usergroups'),
            draggable: false,
            id: 'usersRoot',
            expanded: true
        },
        rootVisible: false,
        tbar: [{
                id: 'exerplan-menu-userstree-expand-all',
                text: _('exerplan.expand_all'),
                handler: function() {
                    var usersTreeCmp = Ext.getCmp('exerplan-tree-users');
                    usersTreeCmp.expandAll();
                }
            }, {
                id: 'exerplan-menu-userstree-collapse-all',
                text: _('exerplan.collapse_all'),
                handler: function() {
                    var usersTreeCmp = Ext.getCmp('exerplan-tree-users');
                    usersTreeCmp.collapseAll();
                }
            }, {
                id: 'exerplan-menu-userstree-refresh',
                text: _('exerplan.refresh'),
                handler: this.refreshTree
            }],
        title: _('exerplan.userstree.title'),
        autoScroll: true,
        enableDD: false,
        containerScroll: true,
        listeners: {
            click: function(node) {
                if (!node.attributes.username) {
                    return this.usergroupsPanel(node);
                } else {
                    node.expand(true);
                    return this.usersPanel(node);
                }
            },
            render: function() {
                return this.getRootNode().expand(true);
            },
            collapse: function(panel) {
                var contentPanel = Ext.getCmp('exerplan-panel-users-content');
                return contentPanel.doLayout();
            },
            expand: function(panel) {
                var contentPanel = Ext.getCmp('exerplan-panel-users-content');
                return contentPanel.doLayout();
            }
        }
    });

    ExerPlan.tree.Users.superclass.constructor.call(this, config);
};

Ext.extend(ExerPlan.tree.Users, Ext.tree.TreePanel, {
    refreshTree: function(parentId) {
        parentId = Number(parentId) ? Number(parentId) : 0;

        var usersTreeCmp = Ext.getCmp('exerplan-tree-users');
        usersTreeCmp.getLoader().baseParams = {
            action: 'mgr/usergroups/getList'
        };

        return usersTreeCmp.getLoader().load(usersTreeCmp.root);
    },
    usergroupsPanel: function(node) {
        var contentPanel = Ext.getCmp('exerplan-panel-users-content');
        contentPanel.removeAll();
        contentPanel.update({
            cls: 'container',
            layout: 'border',
            defaults: {
                bodyStyle: 'padding:20px'
            }
        });

        contentPanel.add({
            xtype: 'exerplan-panel-usergroups',
            node: node,
            preventRender: true,
            region: 'center'
        });

        var container = Ext.getCmp('modx-content');

        return container.doLayout();
    },
    usersPanel: function(node) {
        var contentPanel = Ext.getCmp('exerplan-panel-users-content');
        contentPanel.removeAll();
        contentPanel.update({
            cls: 'container',
            layout: 'border',
            defaults: {
                bodyStyle: 'padding:20px'
            }
        });

        contentPanel.add({
            xtype: 'exerplan-panel-users',
            node: node,
            preventRender: true,
            region: 'center'
        });

        var container = Ext.getCmp('modx-content');

        return container.doLayout();
    }

});
Ext.reg('exerplan-tree-users', ExerPlan.tree.Users);