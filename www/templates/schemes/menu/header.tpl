<tr><td>
	<table class="scheme_menu_button_list">
	<tr>
	{assign var=buttons value=","|explode:$iScheme.attr.buttons} 
	{section name=i loop=$buttons}
		<td class="scheme_menu_button">
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
			{if $buttons[i]|count_words >= 5}
				{assign var=field value=$params[4]}
			{/if}
		
			{if $name == "move"}
				{iScheme name=button title="Przesuń" image="/www/images/admin/move_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "cancel"}
				{iScheme name=button title="Anuluj" image="/www/images/admin/cancel_f2.png" link=$url|default:"javascript:history.back()" compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "apply"}
				{iScheme name=button title="Zastosuj" image="/www/images/admin/apply_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "archive"}
				{iScheme name=button title="Archiwum" image="/www/images/admin/archive_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "copy"}
				{iScheme name=button title="Kopiuj" image="/www/images/admin/copy_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "delete"}
				{iScheme name=button title="Usuń" image="/www/images/admin/delete_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "clear"}
				{iScheme name=button title="Wyczyść" image="/www/images/admin/delete_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "edit"}
				{iScheme name=button title="Edytuj" image="/www/images/admin/edit_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "help"}
				{iScheme name=button title="Pomoc" image="/www/images/admin/help_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "new"}
				{iScheme name=button title="Nowy" image="/www/images/admin/new_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "save"}
				{iScheme name=button title="Zapisz" image="/www/images/admin/save_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "upload"}
				{iScheme name=button title="Upload" image="/www/images/admin/upload_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "preview"}
				{iScheme name=button title="Podgląd" image="/www/images/admin/preview_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "areas"}
				{iScheme name=button title="Obszary" image="/www/images/admin/globe1_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "rights"}
				{iScheme name=button title="Prawa" image="/www/images/admin/globe1_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{elseif $name == "refresh"}
				{iScheme name=button title="Odśwież" image="/www/images/admin/globe1_f2.png" link=$url compileId=$compile_id  confirm=$confirm field=$field}
				{/iScheme}
			{/if}
		</td>
	{/section}
	</tr>
	</table>