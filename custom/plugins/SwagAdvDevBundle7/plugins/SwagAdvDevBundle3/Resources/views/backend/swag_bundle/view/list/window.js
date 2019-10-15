//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.list.Window', {
    extend: 'Shopware.window.Listing',
    title: 'Bundle overview',
    alias: 'shopware.widget-list-window',
    height: 450,

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.SwagBundle.view.list.Bundle',
            listingStore: 'Shopware.apps.SwagBundle.store.Bundle'
        };
    }
});
