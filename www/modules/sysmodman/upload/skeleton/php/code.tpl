<?php

	class iModule_{$name|capitalize} extends iModule
	{ldelim}
		/* Insert your module variables here */
	{if !$actions}

		{literal}
		function & onMyAction(&$core, &$args)
		{
			/* Insert your action code here */
		
			return true;
		}
		{/literal}
	{else}
{foreach from=$actions item=action_name}

		function & on{$action_name|capitalize}(&$core, &$args)
		{ldelim}
			/* Insert your action code here */
		
			return true;
		{rdelim}
{/foreach}
	{/if}
{rdelim}

?>
