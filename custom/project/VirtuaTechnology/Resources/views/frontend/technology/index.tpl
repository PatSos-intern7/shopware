{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_content_left"}{/block}

{block name="frontend_index_content"}
    {debug}
    {foreach $techList as $tech}
        <div class="glossary--word-container">
            <span class="word-container--word">Name: {$tech.name}</span>
            <a href="/technology/{$tech.name}" alt=""/>
            <div class="word-container--description">Opis: {$tech.description}</div>
{*            <img src="{$tech.path}"</img>*}
        </div>
    {/foreach}
{/block}
