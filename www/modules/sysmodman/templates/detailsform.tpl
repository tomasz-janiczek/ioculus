{iScheme name=boxlight3 title="Moduł "|cat:$module->name}
	{iScheme name=form action=$action}
		{iScheme name=form_section}
			{iScheme name=form_field_labeled label=Nazwa}
				{$module->name}
			{/iScheme}
			{iScheme name=form_field_labeled label=Autor}
				{$module->author}
			{/iScheme}
			{iScheme name=form_field_labeled label=Wersja}
				{$module->version}
			{/iScheme}
			{iScheme name=form_field_labeled label=Opis}
				{$module->description}
			{/iScheme}
			{iScheme name=form_field_labeled label="Liczba akcji"}
				{$action_count}
			{/iScheme}
		{/iScheme}

		{iScheme name=form_section}
			{iScheme name=xtable id=table}
				{iScheme name=xtable_header}
					<td>{iInput type=checkbox}</td>		
					<td>Nazwa</td>
					<td>Akcje</td>				{/iScheme}
				{iScheme name=xtable_body}
				{section name=i loop=$actions}
					<tr>
						<td>{iInput type=checkbox value=$actions[i].name}</td>
						<td class="name"><a href="{iURL module=$iModuleName action=actiondetailsform modname=$module->name actname=$actions[i]}">{$actions[i]}</a></td>
						<td>
							<a href="{iURL module=$iModuleName action=actiondetailsform modname=$module->name actname=$actions[i]}">Detale</a>
						</td>
					</tr>
				{/section}
				{/iScheme}
			{/iScheme}
		{/iScheme}
		
	{/iScheme}
{/iScheme}
