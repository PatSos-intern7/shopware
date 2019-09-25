Ext.define('Shopware.apps.SwagBundle.model.Product', {
    extend: 'Shopware.apps.Base.model.Article',

    configure: function(){
           return {
                related:'Shopware.apps.SwagBundle.view.detail.Product'
            };
    }

    //todo overwrite the `configure` function in order to define an own `related` view  for your product
});
