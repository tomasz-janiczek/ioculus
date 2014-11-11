{iScheme name=boxlight3 title="Akcja "|cat:$module->name|cat:"::"|cat:$action->name}
	{iScheme name=form action=$action id=details}
		{iScheme name=form_section}
			{iScheme name=form_field_labeled label=Nazwa}
				{$action->name}
			{/iScheme}
			{iScheme name=form_field_labeled label=Moduł}
				{$module->name}
			{/iScheme}
			{iScheme name=form_field_labeled label="Buforowanie"}
				{if $action->cacheLifeTime == 0}Nie{elseif $action->cacheLifeTime == -1}Tak, permamentnie{else}Tak, na {$action->cacheLifeTime} sekund{/if}
			{/iScheme}
			{iScheme name=form_field_labeled label="Stronicowanie"}
				{if $action->paginate}Tak{else}Nie{/if}
			{/iScheme}

			{iScheme name=form_field_empty}
				{foreach from=$action->modes item=params key=mode}
				<p class="title">Parametry trybu {$mode}</p>
					{iScheme name=xtable}
						{iScheme name=xtable_header}
							<td>Nazwa</td>
							<td>Wartość</td>						{/iScheme}
						{iScheme name=xtable_body}
						{foreach from=$params item=value key=param}
							{if $param == style}
							{foreach from=$value item=styleValue key=styleName}
							<tr>
								<td>Styl dla {$styleName}</td>
								<td>	{$styleValue|default:Brak}</td>
							</tr>
							{/foreach}
							{else}
							<tr>
								<td>{$param}</td>
								<td>	{$value|default:Brak}</td>
							</tr>
							{/if}
						{/foreach}
						{/iScheme}
					{/iScheme}
				{/foreach}
			{/iScheme}

		{/iScheme}
		
	{/iScheme}
{/iScheme}
