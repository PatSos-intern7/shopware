Ext.define('Shopware.apps.VirtuaTechnology.model.Technology', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'VirtuaTechnology'
        };
    },

    fields: [
        { name : 'id', type: 'int'},
        { name : 'name', type: 'string' },
        { name : 'description', type: 'string', useNull: true },
        { name : 'logo', type: 'string', useNull: true },
        { name : 'url', type: 'string' }
    ]
});
