{extends file="parent:frontend/detail/data.tpl"}
    {block name='frontend_detail_data_price_default'}
        {debug}
        {if $sUserLoggedIn}
            {$smarty.block.parent}
        {else}
            <p>Login to see prices</p>
        {/if}
    {/block}
    {block name="frontend_detail_data_price"}
        {if $sUserLoggedIn}
            {$smarty.block.parent}
        {/if}
    {/block}

