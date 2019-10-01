{extends file="parent:frontend/detail/content/buy_container.tpl"}
{block name='frontend_detail_data_attributes'}
    <div class="panel has--border is--rounded">
        <div class="panel--title is--underline"> Featured Products </div>
{*        {HERE INCLUDE PRODUCT SLIDER}*}
    </div>
    {$smarty.block.parent}
{/block}
