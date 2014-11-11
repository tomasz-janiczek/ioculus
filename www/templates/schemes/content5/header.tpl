<p class="{$iScheme.class}_title">
	{$iScheme.attr.title|default:"eGmina, Infrastruktura, Energetyka Spółka z o.o."}
</p>
<p class="{$iScheme.class}_address">
	{$iScheme.attr.address|default:"ul. Bolesława Krzywoustego 2<br/>lokal 618, 44-100 Gliwice"}
</p>
<p class="{$iScheme.class}_numbers">
	KRS: {$iScheme.attr.krs|default:"0000267079"}<br/>
	REGON: {$iScheme.attr.regon|default:"240533845"}
</p>
<p class="{$iScheme.class}_media">
	{capture assign=mail}{mailto address="kontakt@egie.pl" encode=hex}{/capture}
	{$iScheme.attr.media|default:"Tel: (+48) 660 796 109<br/>E-Mail: $mail"}
</p>
