//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.list.Bundle', {
    extend: 'Shopware.grid.Panel',
    alias: 'widget.bundle-listing-grid',
    region: 'center',

    configure: function(){
        return {
            detailWindow:'Shopware.apps.SwagBundle.view.detail.Window'
        };
    }

    // TODO implement the configure function to define the detail window
});
