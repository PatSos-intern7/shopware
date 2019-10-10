Ext.define('Shopware.apps.VirtuaTechnology.model.Technology', {
    extend: 'Shopware.data.Model',

    configure: function() {
        return {
            controller: 'VirtuaTechnology',
            detail: 'Shopware.apps.VirtuaTechnology.view.detail.Technology'
        };
    },

    fields: [
        { name : 'name', type: 'string' },
        { name : 'description', type: 'string'},
        { name : 'logo', type: 'string'},
    ]
});
