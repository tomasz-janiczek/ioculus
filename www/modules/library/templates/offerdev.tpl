<table id="library_offer">
	<tr>
		<td id="column_left">
			<table id="row_top">
				{counter start=0 assign=counter}
				{section loop=3 name=j}
				<tr>
					{section loop=2 name=i}
					<td>
						{capture assign=class}{cycle values="library_offer_leftofferbox,library_offer_rightofferbox"}{/capture}
						{counter assign=counter}
						{if $counter <= 2}{assign var=class value=$class|cat:" library_offer_topbox"}{/if}
						{math equation="x - 1" x=$counter assign=s_index}
						{iScheme name="boxlight2" title=$solutions[$s_index].title id=offer$counter class="library_offer_box $class"}
							{iScheme name="content4" image="/www/modules/library/images/egie_offer_$counter.gif" image2=$solutions[$s_index].image description=$foo array=true content=$solutions[$s_index].description}
							{/iScheme}
						{/iScheme}
					</td>
					{/section}
				</tr>
				{/section}
			</table>

			{iScheme name=bar text="Dołącz do eGIE, zarejestruj się za darmo!" id="register"}
			{/iScheme}

			<table id="row_bottom">
				<tr>
					<td>
						{iScheme name="boxgrey2" title="Deweloperzy e-GIE" id="coop" class="library_offer_box"}
							{iScheme name="content9" content=$members description="Poniższe firmy już dołączyły do sieci <b>e-GIE</b>:"}
							{/iScheme}
						{/iScheme}
					</td>
					<td>
						{iScheme name="boxgreen1" title="Narzędzia dla deweloperów" id="tools" class="library_offer_box"}
							{iScheme name="content8" content=$tools}
							{/iScheme}
						{/iScheme}
					</td>
				</tr>
			</table>
		</td>
		
		<td id="column_right">
			{iScheme name="boxblue" title="Wydarzenia" id="opinions" class="library_offer_box"}
				{iScheme name="content7" content=$events}
				{/iScheme}
			{/iScheme}

			{iScheme name="boxgrey1" title="Zapytaj eksperta" id="help" class="library_offer_box"}
				{iScheme name="content6"}
				{/iScheme}
			{/iScheme}
			
			{iScheme name="boxyellow" title="Newsletter" id="newsletter" class="library_offer_box"}
				{iScheme name=content3}
					Brakuje Ci czasu? Zapisz się na newsletter deweloperów, a wiadomości same dotrą do Ciebie!
				{/iScheme}
			{/iScheme}

			{iScheme name="boxsilver" title="Dane teleadresowe" id="contact" class="library_offer_box"}
				{iScheme name="content5"}
				{/iScheme}
			{/iScheme}
		</td>
	</tr>
</table>
