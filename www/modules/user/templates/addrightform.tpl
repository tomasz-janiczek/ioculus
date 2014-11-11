{assign var="onClickLink" value="siteGoTo('$onClickAction&areaid=' + this.options[this.selectedIndex].value)"}

{iScheme name="admin"}
	<br/>
	<form method="post" action="{$action}">
		{iInput type="select" name="areaid" label="Obszar" onChange=$onClickLink}
		{html_options options=$areas selected=$selectedArea}
		</select>
		{iInput type="select" name="rightid" label="Prawo"}
		{html_options options=$rights}
		</select>
		{iInput type="submit" value=$button}
	</form>
{/iScheme}
