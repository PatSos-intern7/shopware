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
    ],

    associations: [{
        relation: 'ManyToOne',
        field: 'logo',
        type: 'hasMany',
        model: 'Shopware.apps.Base.model.Media',
        name: 'getMedia',
        associationKey: 'media'
    }]
});