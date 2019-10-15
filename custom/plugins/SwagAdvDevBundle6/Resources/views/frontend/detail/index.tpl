{extends file="parent:frontend/detail/index.tpl"}

{block name="frontend_detail_index_detail"}
    {* if product has the swag_bundle attribute: include the detail_listing.tpl *}
    {$smarty.block.parent}
    {if $sArticle.attributes.swag_bundle && $sArticle.attributes.swag_bundle->get('has_bundle')}

        {include file="frontend/swag_bundle/detail_listing.tpl" bundles=$sArticle.attributes.swag_bundle->get('bundles')}
    {/if}

{/block}
