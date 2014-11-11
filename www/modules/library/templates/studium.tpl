{literal}
<!--[if IE]>
<style>
	#action #library_register td.scheme_boxyellow_td2 {
		padding-top:		15px;
	}	

	#action #library_register p {
		margin-bottom:		15px;
	}	
</style>
<![endif]-->
{/literal}

<table id="library_studium_main">
	<tr>
		<td id="library_studium_main_col1">
			{iScheme name=panel id="library_studium_main_nav" title="Nawigacja" onclick="Core.loadData" module=$iModuleName action=main content=$chapters}
			{/iScheme}

			{if !$iUserLoggedIn}
			{iScheme name=boxyellow title="Logowanie"}
				{iScheme name=login}
				{/iScheme}
			{/iScheme}
			{/if}

			{iScheme name=boxyellow title="Newsletter" id="library_studium_main_newsletter"}
				{iScheme name=content3}
					Chcesz być powiadamiany o nowościach dotyczących studium? Zapisz się na nasz newsletter!
				{/iScheme}
			{/iScheme}

			{iScheme name=boxsilver title="Do pobrania" id="library_download"}
				<table>
					<tr>
						<td>{html_image file="$iImageDir/pdf.gif"}</td>
						<td><a href="{$iUploadDir}/program.pdf">Program studium</a></td>
					</tr>
					<tr>
						<td>{html_image file="$iImageDir/pdf.gif"}</td>
						<td><a href="{$iUploadDir}/zgloszenie_rynek.pdf">Formularz zgłoszeniowy</a></td>
					</tr> 
				</table>
			{/iScheme}
		</td>

		<td id="library_studium_main_col2">
		</td>

		<td id="library_studium_main_col3">
			<span id="library_studium_main_prev_container">
				{if $iActionArgs.id}
					{iIncludeTemplate file="www/modules/library/templates/studium_register_form_ajax.tpl"}
				{else}
					{iScheme name=boxlight4 id=library_studium_main_prev noicon=true}
						<table id="library_intro">
							<tr>
								<td colspan="2" id="library_intro_title">
									<span>P</span>OLITECHNIKA <span>Ś</span>LĄSKA W <span>G</span>LIWICACH
								</td>
							</tr>
							<tr>
								<td id="library_intro_logo">
									{html_image file="$iImageDir/logo_ps_big.gif"}
								</td>
								<td id="library_intro_depart">
									<span class="big"><span>W</span>YDZIAŁ <span>E</span>LEKTRYCZNY</span><br/>
									<div>
									  <span>I</span>NSTYTUT <span>E</span>LEKTROENERGETYKI I <span>S</span>TEROWANIA <span>U</span>KŁADÓW<br/>
									  <span>I</span>NSTYTUT <span>M</span>ETROLOGII I <span>A</span>UTOMATYKI <span>E</span>LEKTROTECHNICZNEJ<br/>
								    </div>
									<span class="big"><span>W</span>YDZIAŁ <span>I</span>NŻYNIERII <span>Ś</span>RODOWISKA I <span>E</span>NERGETYKI</span><br/>
									<div>
									  <span>I</span>NSTYTUT <span>T</span>ECHNIKI <span>C</span>IEPLNEJ<br/>
									 </div>
								</td>
							</tr>
							<tr>
								<td colspan="2" id="library_intro_invite">
									<span>Z</span>APRASZA NA STUDIUM PODYPLOMOWE:
								</td>
							</tr>
							<tr>
								<td colspan="2" id="library_intro_spec">
									<ul>
										<li><span>R</span>YNEK <span>E</span>NERGII</li>
										<li><span>A</span>UDYT <span>E</span>NERGETYCZNY</li>
										<li><span>E</span>NERGETYKA <span>R</span>OZPROSZONA I E-<span>I</span>NFRASTRUKTURA W <span>G</span>MINACH</li>
									</ul>
								</td>
							</tr>
						</table>
					{/iScheme}
				{/if}
			</span>
			
			{iScheme name=bar id=library_register_bar}
				<div>Rekrutacja online!</div>
			{/iScheme}

			{iScheme name=boxlight4 title="Pismo dziekana Wydziału Elektrycznego"}
				{$deans_letter|truncate:1008}
				<p id="library_deans_letter_more"><a href="javascript:Core.loadData('?m=library&aamp;ct=main&amp;id=65')">{html_image file="/www/images/read_more_blue.gif"}</a></p>
			{/iScheme}

			{if $news}
			{iScheme name=boxlight4 notitle=true}
				{section name="i" loop=$news}
					{capture assign=link}{iURL module=library action=main id=$news[i].id}{/capture}
					{iScheme name=content2 title=$news[i].title content=$news[i].description|truncate:500 image=$news[i].image link=$link date=$news[i].date|date_format:"%m-%d-%Y" author=$news[i].author}
					{/iScheme}
				{/section}
			{/iScheme}
			{/if}
		</td>
	</tr>
</table>
