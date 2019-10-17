{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_content_left"}{/block}

{block name="frontend_index_content"}
    {if $paginator.prevPageUrl}
        <a href="{$paginator.prevPageUrl}">Prev</a>
    {/if}
    <a href="{$paginator.nextPageUrl}">Next</a>
    {foreach $techList as $tech}
        <div class="glossary--word-container">
            <h4 class="word-container--word">{$tech.name}</h4>
            {if is_null($tech.path)}
                {assign var="newpath" value="themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg"}
                <a href="/technology/{$tech.url}" alt="{$tech.name}">
                    <img width="150" height="150" src="{$newpath}">
                </a>
            {else}
                <a href="/technology/{$tech.url}" alt="{$tech.name}">
                    <img width="150" height="150" src="{$tech.path}">
                </a>
            {/if}
        </div>
    {/foreach}
{/block}
