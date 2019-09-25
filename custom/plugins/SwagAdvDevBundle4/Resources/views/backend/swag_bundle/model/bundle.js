Ext.define('Shopware.apps.SwagBundle.model.Bundle', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'SwagBundle',
            detail:'Shopware.apps.SwagBundle.view.detail.Bundle'
            // todo configure the detail view of this model
            // https://developers.shopware.com/developers-guide/backend-components/detail/
        };
    },

    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'name', type: 'string' },
        { name: 'active', type: 'boolean' }
    ],

    associations:[
        {
            relation:'ManyToMany',
            type:'hasMany',
            model:'Shopware.apps.SwagBundle.model.Product',
            name: 'getProducts',
            associationKey:'products'
        }
    ]


    // todo implement product association
    //todo  https://developers.shopware.com/developers-guide/backend-components/associations/
});
