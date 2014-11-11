{capture assign=new_url}{iURL module=right action=addform}{/capture}
{iScheme name=adminpage3 title="Modyfikacja uprawnień" image="/www/images/admin/config.png" buttons="new $new_url,cancel"}

{iScheme name=boxlight4 notitle=true id="right_container"}
<table id="right_layout">
	<tr>
	    	<td id="right_col1">
			{iInput type=select name=area label="Obszar"}
				{html_options options=$areas selected=$area_id}
			</select>

			{iScheme name=boxlight3 title="Dostępne prawa" id="right_list"}
				{iIncludeTemplate file="$iModTemplateDir/ajax/addgrouprightform.tpl"}
			{/iScheme}
		</td>
    		<td id="right_col2">
			{iScheme name=boxlight3 title="Aktualnie przydzielone prawa" id="right_group"}
				{iIncludeTemplate file="$iModTemplateDir/ajax/addgrouprightform_group.tpl"}
			{/iScheme}
		</td>
	</tr>
</table>

{/iScheme}

{/iScheme}