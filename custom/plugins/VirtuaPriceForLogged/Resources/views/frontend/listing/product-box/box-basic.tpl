{extends file="parent:frontend/listing/product-box/box-basic.tpl"}
    {block name="frontend_listing_box_article_price"}
        {if $userLoggedIn}
            {$smarty.block.parent}
        {else}
            <p>Login to see prices</p>
        {/if}
    {/block}


