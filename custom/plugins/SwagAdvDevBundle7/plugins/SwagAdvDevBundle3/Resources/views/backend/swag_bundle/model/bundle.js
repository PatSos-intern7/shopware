Ext.define('Shopware.apps.SwagBundle.model.Bundle', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'SwagBundle'
        };
    },

    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'name', type: 'string' },
        { name: 'active', type: 'boolean' }
    ]

});
