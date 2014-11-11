<table id="library_offer">
	<tr>
		<td id="column_left">
			<table id="row_top">

				<tr>
					<td class="row_top_td">
<!--						{capture assign=class}{cycle values="library_offer_leftofferbox,library_offer_rightofferbox"}{/capture}
						{counter assign=counter}
						{if $counter <= 2}{assign var=class value=$class|cat:" library_offer_topbox"}{/if} -->

						{iScheme name="boxlight2" title="Infrastruktura" id=offer1 class="library_offer_box library_offer_leftofferbox library_offer_topbox"}
							{iScheme name="content4" image="/www/modules/library/images/egie_offer_1.gif" image2="www/images/illustration_19.jpg"}
								Prosty i szybki dobór Integratorów Usług Infrastrukturalnych, oraz deweloperów branżowych.
								<div>Produkty i usługi tej kategorii:</div>
								<ul>
									<li>Integrator Usług<br/>Infrastrukturalnych</li>
								</ul>
							{/iScheme}
						{/iScheme}
					</td>

					<td class="row_top_td">
						{iScheme name="boxlight2" title="Energetyka" id=offer2 class="library_offer_box library_offer_rightofferbox library_offer_topbox"}
							{iScheme name="content4" image="www/modules/library/images/egie_offer_2.gif" image2="www/images/illustration_18.jpg"}
								Minimalizacja kosztów wytwarzania energii i jej zużycia - audyt energetyczny, energetyka odnawialna.
								<div>Produkty i usługi tej kategorii:</div>
								<ul>
									<li>Audyt energetyczny</li>
								</ul>
							{/iScheme}
						{/iScheme}
					</td>

				</tr>

				<tr>
					<td class="row_top_td">
						{iScheme name="boxlight2" title="Informacja" id=offer3 class="library_offer_box library_offer_leftofferbox"}
							{iScheme name="content4" image="www/modules/library/images/egie_offer_3.gif" image2="www/images/illustration_20.jpg"}
								Natychmiastowy dostęp do najświeższych i najistotniejszych dla gminy informacji, z kraju i zza granicy.
								<div>Produkty i usługi tej kategorii:</div>
								<ul>
									<li>Doradztwo europejskie</li>
								</ul>
							{/iScheme}
						{/iScheme}
					</td>

					<td class="row_top_td">
						{iScheme name="boxlight2" title="Technologia" id=offer4 class="library_offer_box library_offer_rightofferbox"}
							{iScheme name="content4" image="/www/modules/library/images/egie_offer_4.gif" image2="www/images/illustration_15.jpg"}
								Profesjonalne narzędzia informatyczne wspomagające działalność gminy. Outsourcing informatyczny.
								<div>Produkty i usługi tej kategorii:</div>
								<ul>
									<li>Giełda pracy</li>
									<li>Kiosk pracy</li>
								</ul>
							{/iScheme}
						{/iScheme}
					</td>

				</tr>

				<tr>
					<td class="row_top_td">
						{iScheme name="boxlight2" title="Promocja" id=offer5 class="library_offer_box library_offer_leftofferbox"}
							{iScheme name="content4" image="www/modules/library/images/egie_offer_5.gif" image2="www/images/illustration_16.jpg"}
								Szeroka, skuteczna promocja gmin wśród potencjalnych inwestorów. Marketing konwencjonalny i sieciowy.
								<div>Produkty i usługi tej kategorii:</div>
								<ul>
									<li>Reklama internetowa</li>
								</ul>
							{/iScheme}
						{/iScheme}
					</td>

					<td class="row_top_td">
						{iScheme name="boxlight2" title="Kontakt" id=offer6 class="library_offer_box library_offer_rightofferbox"}
							{iScheme name="content4" image="/www/modules/library/images/egie_offer_6.gif" image2="www/images/illustration_23.jpg"}
								Sprawny i tani kontakt z gminami z całej Polski - fora, tele-konferencje, systemy wiadomości prywatnych.
								<div>Produkty i usługi tej kategorii:</div>
							{/iScheme}
						{/iScheme}
					</td>

				</tr>

			</table>
			
			{html_image file="/www/images/button_register_big.jpg" id="register"}

			<table id="row_bottom">
				<tr>
					<td>
						{iScheme name="boxgrey2" title="Gminy e-GIE" id="coop" class="library_offer_box"}
							{iScheme name="content9" content=$members description="Poniższe gminy już dołączyły do sieci <b>e-GIE</b>:"}
							{/iScheme}
						{/iScheme}
					</td>
					<td>
						{iScheme name="boxgreen1" title="Narzędzia dla gmin" id="tools" class="library_offer_box"}
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
					Brakuje Ci czasu? Zapisz się na newsletter informacyjny gmin, a wiadomości same dotrą do Ciebie!
				{/iScheme}
			{/iScheme}

			{iScheme name="boxsilver" title="Dane teleadresowe" id="contact" class="library_offer_box"}
				{iScheme name="content5"}
				{/iScheme}
			{/iScheme}
		</td>
	</tr>
</table>
