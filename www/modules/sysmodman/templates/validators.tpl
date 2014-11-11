{iScheme name="admin}
	{oculusTable}
		<tr>
			<th id="title">{$param->name}</th>
			<th colspan="3"></th>
		</tr>
		<tr>
			<th>Nazwa</th>
			<th colspan="3">Lista argumentów</th>
		</tr>
		{if $iActionName == "validators"}
			{assign var="list" value=$param->_validators}
		{else}
			{assign var="list" value=$param->_modifiers}
		{/if}
		{foreach from=$list key=key item=value}
		<tr>
			<td>{$value->name}</td>
			<td>
			{if !empty($value->params)}
			{foreach from=$value->params key=vName item=vValue}
				{$vName}="{$vValue}"
			{/foreach}
			{else}
			Brak
			{/if}
			</td>
		</tr>
		{/foreach}
	{/oculusTable}
{/iScheme}
