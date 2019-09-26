//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.detail.Bundle', {
    extend: 'Shopware.model.Container',
    alias: 'widget.bundle-detail-product-container',

    configure: function() {
        return {
            controller: 'SwagBundle',
            associations: [ 'products' ]
        };
    }
});
