//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.detail.Product', {
    extend: 'Shopware.grid.Association',
    alias: 'widget.bundle-detail-product-grid',

    configure: function() {
        return {
            controller: 'SwagBundle',
            columns: {
                name: {

                }
            }
        };
    }
});
