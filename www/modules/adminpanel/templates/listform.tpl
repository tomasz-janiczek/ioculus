{capture assign=user_link}{iURL module=user action=listform}{/capture}
{capture assign=group_link}{iURL module=group action=listform}{/capture}
{capture assign=right_link}{iURL module=right action=listform}{/capture}
{capture assign=module_link}{iURL module=sysmodman action=listform}{/capture}
{capture assign=area_link}{iURL module=right action=listareaform}{/capture}
{capture assign=archive_link}{iURL module=archive action=listform}{/capture}
{capture assign=article_link}{iURL module=article action=listsectionform}{/capture}

{iScheme name=boxlight3 title="Panel administracyjny" id=container}
	<div class="column first_column">
		{iScheme name=button title="Menadżer użytkowników" link=$user_link image="$iImageDir/user.png"}
		{/iScheme}
		{iScheme name=button title="Menadżer grup" link=$group_link image="$iImageDir/user.png"}
		{/iScheme}
		{iScheme name=button title="Menadżer uprawnień" link=$right_link image="$iImageDir/config.png"}
		{/iScheme}
	</div>

	<div class="column">
		{iScheme name=button title="Menadżer obszarów" link=$area_link image="$iImageDir/module.png"}
		{/iScheme}
		{iScheme name=button title="Menadżer modułów" link=$module_link image="$iImageDir/module.png"}
		{/iScheme}
		{iScheme name=button title="Menadżer archiwów" link=$archive_link image="$iImageDir/sections.png"}
		{/iScheme}
	</div>

	<div class="column">
		{iScheme name=button title="Menadżer artykułów" link=$article_link image="$iImageDir/article.png"}
		{/iScheme}
	</div>

{/iScheme}
