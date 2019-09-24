{extends file="parent:frontend/index/index.tpl"}
{block name="frontend_index_sidebar"}{/block}
{block name='frontend_index_content'}

    <h4>{$smarty.now} </h4>
    <h4>Im {$currentAction}</h4>
    <a href="{url module="frontend" controller="test" action=$nextPage}">
        {s name='TestNextPage'}{/s}
    </a>
    <ul>
        
    {foreach $productNames as $productName}
        <li>{$productName}</li>
    {/foreach}
    </ul>
{/block}

