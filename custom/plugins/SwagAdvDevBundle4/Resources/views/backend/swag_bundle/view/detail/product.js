//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.detail.Product', {
    extend: 'Shopware.grid.Association',
    alias: 'ViewDetailProduct',

    configure: function(){
           return {
                controller:'SwagBundle',
               columns:{
                    name:{}
               }
            };
    }

    //todo Implement the Shopware.grid.Association. This component requires the controller property.
    //todo  https://developers.shopware.com/developers-guide/backend-components/associations/
});
