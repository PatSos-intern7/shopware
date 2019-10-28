{extends file="parent:frontend/listing/product-box/box-basic.tpl"}
    {block name="frontend_listing_box_article_price"}
        {if $logged === true}
            {$smarty.block.parent}
        {else}
            <p>Login to see pricess</p>
        {/if}

    {/block}
    {block name='frontend_listing_box_article_unit'}
        {if $logged === true}
            {$smarty.block.parent}
        {/if}
    {/block}

