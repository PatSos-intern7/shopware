
Ext.define('Shopware.apps.VirtuaTechnology.view.list.Window', {
    extend: 'Shopware.window.Listing',
    alias: 'widget.technology-list-window',
    height: 450,
    title :'{s name=window_title}Product listing{/s}',

    configure: function() {
        return {
            listingGrid: 'Shopware.apps.VirtuaTechnology.view.list.Technology',
            listingStore: 'Shopware.apps.VirtuaTechnology.store.Technology'
        };
    }
});
