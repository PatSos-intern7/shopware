Ext.define('Shopware.apps.SwagBundle.model.Bundle', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'SwagBundle'
            // todo configure the detail view of this model
            // https://developers.shopware.com/developers-guide/backend-components/detail/
        };
    },

    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'name', type: 'string' },
        { name: 'active', type: 'boolean' }
    ]

    // todo implement product association
    //todo  https://developers.shopware.com/developers-guide/backend-components/associations/
});
