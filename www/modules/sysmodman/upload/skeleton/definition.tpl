<?xml version="1.0" encoding="utf-8"?>
<module>
	<author>{$author|default:"Unknown"}</author>
	<version>0.1</version>
	<description>{$description|default:"No description available"}</description>	
	
	<!-- Define your actions here -->
{foreach from=$actions item=action_name}

	<action name="{$action_name}">
		<!-- Define your action params here -->
	</action>
{/foreach}
</module>
