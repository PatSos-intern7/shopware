{extends file="parent:frontend/detail/index.tpl"}

{block name="frontend_detail_index_detail"}
    {* if product has the swag_bundle attribute: include the detail_listing.tpl *}
    {$smarty.block.parent}
{/block}
