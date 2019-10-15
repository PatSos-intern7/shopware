//{namespace name="bundle/translation"}

Ext.define('Shopware.apps.SwagBundle.view.detail.Bundle', {
    extend: 'Shopware.model.Container',

    configure: function(){
           return {
                controller:'SwagBundle',
               associations:['products']
            };
    }
    //todo Implement the missing parts of this component
    // https://developers.shopware.com/developers-guide/backend-components/detail/#shopware.model.container-basics
});
