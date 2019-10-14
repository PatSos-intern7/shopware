{extends file="parent:frontend/listing/product-box/product-price.tpl"}
{block name='frontend_listing_box_article_price_default'}
    {if $userLoggedIn}
        {$smarty.block.parent}
    {else}
        <p>Login to see prices</p>
    {/if}
{/block}
