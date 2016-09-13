<?php
defined( '_VALID_MOS' ) or die( 'Restricted access' );
?>
<br /><br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" width="120">
			<div class="myBox" style="white-space:nowrap;">
				SEGMENTOS<br /><br style="font-size:5px;" />
			</div>
		</td>
		<td>&nbsp;
			
		</td>
	</tr>
	<tr>
		<td colspan="2" height="6" bgcolor="#52759b" style="font-size:6px;">&nbsp;</td>
	</tr>
</table>
<div style="text-align:right;"><br />
	<form action="index.php?option=com_segmentos" method="get">
	<div class="search">
	<input name="busca" id="mod_search_searchword" maxlength="20" alt="busca" class="inputbox" type="text" size="17" value="Busca Rápida"  onblur="if(this.value=='') this.value='Busca Rápida';" onfocus="if(this.value=='Busca Rápida') this.value='';" />&nbsp;<input type="submit" value="OK" class="button"/>
	</div>
	<input type="hidden" name="option" value="com_segmentos" />
</form>
</div>
<br /><br />
<?
$query = "SELECT a.nome, a.endereco, a.telefone1, a.telefone2, a.telefone3, a.site, a.observacao, c.cidade, t.tipo "
."\n FROM anunciantes a, cidade c, tipoanunciante t "
."\n WHERE c.id = a.cidade AND t.idTipo = a.tipo ";

if(strlen($_GET["busca"])>0){
	$query .= " AND (t.tipo like '%%%" . $_GET["busca"] . "%%%'";
	$query .= " OR a.nome like '%%%" . $_GET["busca"] . "%%%'";
	$query .= " OR a.observacao like '%%%" . $_GET["busca"] . "%%%')";
}
else{
	$query .= "AND a.tipo = " . $_GET["tipo"];
}

$query .= "\n ORDER BY nome";

$database->setQuery($query);
$rows = $database->loadObjectList();

if(count($rows) == 0){
	echo("Nenhum registro encontrado.");
}
else{
	foreach ($rows as $row ) {
	?>
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="50" align="left">
					<? if (eregi("MSIE",getenv("HTTP_USER_AGENT")) || eregi("Internet Explorer",getenv("HTTP_USER_AGENT"))) { ?>
						<span class="myBox2">
							<?=str_replace(" ", "&nbsp;", $row->nome)?>
						</span>						
					<? } else { ?>
						<div class="myBox" style="white-space:nowrap;">
							<?=str_replace(" ", "&nbsp;", $row->nome)?>
						</div>
					<? } ?>
				</td>
				<td>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" style="border:solid 1px #d6ad55" cellpadding="0" cellspacing="0">
			<tr>
				<td bgcolor="#FF8000" style="font-size:10px;">&nbsp;</td>
			</tr>
			<tr>
				<td style="color:#666666;border-bottom:solid 1px #d6ad55; padding:5px; font-size:10px">
					<? if(strlen($row->endereco)>0) {?>
						<b>ENDEREÇO:</b> <?=$row->endereco?><br />
					<? } ?>
					<? if(strlen($row->telefone1)>0) {?>
						<b>TELEFONE:</b> <?=$row->telefone1?>
						<? if(strlen($row->telefone2)>0) {?>
							 - <?=$row->telefone2?>
						<? } ?>
						<? if(strlen($row->telefone3)>0) {?>
							 - <?=$row->telefone3?>
						<? } ?>
						<br />
					<? } ?>
					<? if(strlen($row->cidade)>0) {?>
						<b>CIDADE:</b> <?=$row->cidade?><br />
					<? } ?>
					<? if(strlen($row->site)>0) {?>
						<b>SITE:</b> <a target="_blank" href="<? echo("http://" . str_replace("http://", "", $row->site))?>"><?=$row->site?></a><br />
					<? } ?>
					<? if(strlen($row->observacao)>0) {?>
						<b>DESCRIÇÃO:</b> <?=$row->observacao?>
					<? } ?>
				</td>
			</tr>
			<tr>
				<td style="padding:10px;">
					<? if(strlen($row->site)>0) {?>
						<a target="_blank" href="<? echo("http://" . str_replace("http://", "", $row->site))?>"><img src="components/com_segmentos/site.gif" border="0" /></a>&nbsp;
					<? } ?>
					<img src="components/com_segmentos/maisinfo.gif" border="0" />
					&nbsp;
					<img src="components/com_segmentos/email.gif" border="0" />
				</td>
			</tr>
		</table>
		<br /><br />
	<?
	}
}
?>