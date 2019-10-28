{extends file="parent:frontend/technology/index.tpl"}

{block name="frontend_index_content"}
  <div class="product--detail" >
	<h1>{$name}</h1>
    <p>{$description}</p>
     {if is_null($path)}
         {assign var="path" value="themes/Frontend/Responsive/frontend/_public/src/img/no-picture.jpg"}
     {/if}
    <img width="200" height="200" src="{$path}">
        </div>
{/block}

