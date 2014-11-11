<tr><td>
	<table class="scheme_menubig_button_list">
	<tr>
	{assign var=buttons value=","|explode:$iScheme.attr.buttons} 
	{section name=i loop=$buttons}
		<td class="scheme_menubig_button">
			{assign var=params value=" "|explode:$buttons[i]} 

			{assign var=url value=""}
			{assign var=compile_id value="false"}
			{assign var=confirm value="false"}

			{if $buttons[i]|count_words >= 1}
				{assign var=name value=$params[0]}
			{/if}
			{if $buttons[i]|count_words >= 2}
				{assign var=url value=$params[1]}
			{/if}
			{if $buttons[i]|count_words >= 3}
				{if $params[2] == "true"} {assign var=compile_id value="scheme_table_checkbox"}
				{elseif $params[2] != "false"} {assign var=compile_id value=$params[2]}
				{/if}
			{/if}
			{if $buttons[i]|count_words >= 4}
				{if $params[3] == "true"} {assign var=confirm value="true"}
				{else} {assign var=confirm value="false"} {/if}
			{/if}
		
			{if $name == "user"}
				{iScheme name=button title="Menadżer Użytkowników" image="/www/images/admin/user.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "group"}
				{iScheme name=button title="Menadżer Grup" image="/www/images/admin/user.png" link=$url|default:"javascript:history.back()" compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "article"}
				{iScheme name=button title="Menadżer Artykułów" image="/www/images/admin/addedit.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "right"}
				{iScheme name=button title="Menadżer Praw" image="/www/images/admin/config.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "gallery"}
				{iScheme name=button title="Menadżer Galerii" image="/www/images/admin/mediamanager.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "archive"}
				{iScheme name=button title="Menadżer Archiwów" image="/www/images/admin/sections.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "module"}
				{iScheme name=button title="Menadżer Modułów" image="/www/images/admin/module.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "edit"}
				{iScheme name=button title="Menadżer" image="/www/images/admin/edit.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "help"}
				{iScheme name=button title="Pomoc" image="/www/images/admin/help.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "new"}
				{iScheme name=button title="Nowy" image="/www/images/admin/new.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "save"}
				{iScheme name=button title="Zapisz" image="/www/images/admin/save.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "upload"}
				{iScheme name=button title="Upload" image="/www/images/admin/upload.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "preview"}
				{iScheme name=button title="Podgląd" image="/www/images/admin/preview.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{elseif $name == "areas"}
				{iScheme name=button title="Obszary" image="/www/images/admin/globe1.png" link=$url compileId=$compile_id  confirm=$confirm}
				{/iScheme}
			{/if}
		</td>
	{/section}
	</tr>
	</table>