{extends file="parent:frontend/index/index.tpl"}
{block name='frontend_index_content'}

    <h4>{$smarty.now} </h4>
    <h4>Im {$currentAction}</h4>
    <a href="{url module="frontend" controller="test" action=$nextPage}">
        {s name='TestNextPage'} {$smarty.now} {/s}
    </a>
{/block}
