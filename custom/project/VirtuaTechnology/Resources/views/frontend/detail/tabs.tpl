{extends file='parent:frontend/detail/tabs.tpl'}
{block name="frontend_detail_tabs_navigation_inner"}
    {$smarty.block.parent}
    {if $techList}
        <a href="#" class="tab--link has--content" title="Technology" data-tabname="technologies">{s name='TechnologyTab'}{/s}</a>
    {/if}
{/block}

{block name="frontend_detail_tabs_content_inner"}
{$smarty.block.parent}
    <div class="tab--container">
            <div class="tab--content">
                {block name="frontend_detail_tabs_content_description_description_inner"}
                    {if $techList}
                        {foreach $techList as $tech}
                            <div class="content--description">
                                <h5 class="word-container--word">Name: {$tech.name}</h5>
                                <p>Description: {$tech.description}</p>
                                {if is_null($tech.path)}
                                    {assign var="newpath" value="themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg"}
                                    <a href="/technology/{$tech.url}" alt="{$tech.name}">
                                        <img width="100" height="100" src="{$newpath}">
                                    </a>
                                {else}
                                    <a href="/technology/{$tech.url}" alt="{$tech.name}">
                                        <img width="100" height="100" src="{$tech.path}">
                                    </a>
                                {/if}
                            </div>
                        {/foreach}
                    {/if}
                {/block}
            </div>
    </div>
{/block}


