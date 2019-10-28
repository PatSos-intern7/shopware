{extends file="parent:frontend/detail/content/buy_container.tpl"}
{block name='frontend_detail_data_attributes'}
    {if isset($featuredProducts)}
        <div class="panel has--border is--rounded">
            <div class="panel--title is--underline"> Featured Products </div>
            {include file="frontend/_includes/product_slider.tpl" articles=$featuredProducts}
        </div>
    {/if}
    {$smarty.block.parent}
{/block}
