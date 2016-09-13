<?php
/**
* @version $Id: admin.modules.html.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla
* @subpackage Modules
* @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
* @package Joomla
* @subpackage Modules
*/
class HTML_modules {

	/**
	* Writes a list of the defined modules
	* @param array An array of category objects
	*/
	function showModules( &$rows, $myid, $client, &$pageNav, $option, &$lists, $search ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th class="modules" rowspan="2">
			Administrar Módulo <small><small>[ <?php echo $client == 'admin' ? 'Administração' : 'Site';?> ]</small></small>
			</th>
			<td width="right">
			<?php echo $lists['position'];?>
			</td>
			<td width="right">
			<?php echo $lists['type'];?>
			</td>
		</tr>
		<tr>
			<td align="right">
			Filtro:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo htmlspecialchars( $search );?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20px">nº</th>
			<th width="20px">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			Nome do Módulo
			</th>
			<th nowrap="nowrap" width="10%">
			Publicado
			</th>
			<th colspan="2" align="center" width="5%">
			Reordenar
			</th>
			<th width="2%">
			Ordem
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Salvar Ordem" /></a>
			</th>
			<?php
			if ( !$client ) {
				?>
				<th nowrap="nowrap" width="7%">
				Acesso
				</th>
				<?php
			}
			?>
			<th nowrap="nowrap" width="7%">
			Posição
			</th>
			<th nowrap="nowrap" width="5%">
			Páginas
			</th>
			<th nowrap="nowrap" width="5%">
			ID
			</th>
			<th nowrap="nowrap" width="10%" align="left">
			Tipo
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			mosMakeHtmlSafe($row);

			$link = 'index2.php?option=com_modules&client='. $client .'&task=editA&hidemainmenu=1&id='. $row->id;

			$access 	= mosCommonHTML::AccessProcessing( $row, $i );
			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
			$published 	= mosCommonHTML::PublishedProcessing( $row, $i );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="right">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->title;
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo $row->title; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<?php echo $published;?>
				</td>
				<td>
				<?php echo $pageNav->orderUpIcon( $i, ($row->position == @$rows[$i-1]->position) ); ?>
				</td>
				<td>
				<?php echo $pageNav->orderDownIcon( $i, $n, ($row->position == @$rows[$i+1]->position) ); ?>
				</td>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<?php
				if ( !$client ) {
					?>
					<td align="center">
					<?php echo $access;?>
					</td>
					<?php
				}
				?>
				<td align="center">
				<?php echo $row->position; ?>
				</td>
				<td align="center">
				<?php
				if (is_null( $row->pages )) {
					echo 'Nenhuma';
				} else if ($row->pages > 0) {
					echo 'Algumas';
				} else {
					echo 'Todas';
				}
				?>
				</td>
				<td align="center">
				<?php echo $row->id;?>
				</td>
				<td align="left">
				<?php echo $row->module ? $row->module : "User";?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="client" value="<?php echo $client;?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing module
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosCategory The category object
	* @param array <p>The modules of the left side.  The array elements are in the form
	* <var>$leftorder[<i>order</i>] = <i>label</i></var>
	* where <i>order</i> is the module order from the db table and <i>label</i> is a
	* text label associciated with the order.</p>
	* @param array See notes for leftorder
	* @param array An array of select lists
	* @param object Parameters
	*/
	function editModule( &$row, &$orders2, &$lists, &$params, $option ) {
		global $mosConfig_live_site, $mosConfig_cachepath, $my;

		$row->title = htmlspecialchars( $row->title );

		$row->titleA = '';
		if ( $row->id ) {
			$row->titleA = '<small><small>[ '. $row->title .' ]</small></small>';
		}

		mosCommonHTML::loadOverlib();
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			if ( ( pressbutton == 'save' ) && ( document.adminForm.title.value == "" ) ) {
				alert("O Módulo deve possuir um título");
			} else {
				<?php if ($row->module == "") {
					getEditorContents( 'editor1', 'content' );
				}?>
			}
			submitform(pressbutton);
		}
		<!--
		var originalOrder = '<?php echo $row->ordering;?>';
		var originalPos = '<?php echo $row->position;?>';
		var orders = new Array();	// array in the format [key,value,text]
		<?php	$i = 0;
		foreach ($orders2 as $k=>$items) {
			foreach ($items as $v) {
				echo "\n	orders[".$i++."] = new Array( \"$k\",\"$v->value\",\"$v->text\" );";
			}
		}
		?>
		//-->
		</script>
		<table class="adminheading">
		<tr>
			<th class="modules">
			<?php echo $lists['client_id'] ? 'Administração' : 'Site';?>
			- Módulo:
			<small>
			<?php echo $row->id ? 'Editar' : 'Novo';?>
			</small>
			<?php echo $row->titleA; ?>
			</th>
		</tr>
		</table>

		<form action="index2.php" method="post" name="adminForm">

		<table cellspacing="0" cellpadding="0" width="100%">
		<tr valign="top">
			<td width="60%">
				<table class="adminform">
				<tr>
					<th colspan="2">
					Detalhes
					</th>
				</tr>
				<tr>
					<td width="100" align="left">
					Título:
					</td>
					<td>
					<input class="text_area" type="text" name="title" size="35" value="<?php echo $row->title; ?>" />
					</td>
				</tr>
				<!-- START selectable pages -->
				<tr>
					<td width="100" align="left">
					Exibir título:
					</td>
					<td>
					<?php echo $lists['showtitle']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Posição:
					</td>
					<td>
					<?php echo $lists['position']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Ordem do Módulo:
					</td>
					<td>
					<script language="javascript" type="text/javascript">
					<!--
					writeDynaList( 'class="inputbox" name="ordering" size="1"', orders, originalPos, originalPos, originalOrder );
					//-->
					</script>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left">
					Nível de Acesso:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					Publicado:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					</td>
				</tr>
				<tr>
					<td valign="top">
					ID:
					</td>
					<td>
					<?php echo $row->id; ?>
					</td>
				</tr>
				<tr>
					<td valign="top">
					Descrição:
					</td>
					<td>
					<?php echo $row->description; ?>
					</td>
				</tr>
				</table>

				<table class="adminform">
				<tr>
					<th >
					Parâmetros
					</th>
				</tr>
				<tr>
					<td>
					<?php echo $params->render();?>
					</td>
				</tr>
				</table>

				<?php
				if ($row->module == "") {
					?>
					<table class="adminform">
					<tr>
						<td>
							<table align="center">
							<?php
							$visible = 0;
							// check to hide certain paths if not super admin
							if ( $my->gid == 25 ) {
								$visible = 1;
							}
							mosHTML::writableCell( $mosConfig_cachepath, 0, '<strong>Diretório de Cache</strong> ', $visible );
							?>
							</table>
						</td>
					</tr>
					</table>
					<?php
				}
				?>
			</td>
			<td width="40%" >
				<table width="100%" class="adminform">
				<tr>
					<th>
					Páginas / Itens
					</th>
				</tr>
				<tr>
					<td>
					Link(s) do Item de Menu:
					<br />
					<?php echo $lists['selections']; ?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php
		if ($row->module == "") {
			?>
			<tr>
				<td colspan="2">
						<table width="100%" class="adminform">
						<tr>
							<th colspan="2">
							Saída Personalizada
							</th>
						</tr>
						<tr>
							<td valign="top" align="left">
							Conteúdo:
							</td>
							<td>
							<?php
							// parameters : areaname, content, hidden field, width, height, rows, cols
							editorArea( 'editor1',  $row->content , 'content', '800', '400', '110', '40' ) ; ?>
							</td>
						</tr>
						</table>
				</td>
			</tr>
			<?php
		}
		?>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="original" value="<?php echo $row->ordering; ?>" />
		<input type="hidden" name="module" value="<?php echo $row->module; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="client_id" value="<?php echo $lists['client_id']; ?>" />
		<?php
		if ( $row->client_id || $lists['client_id'] ) {
			echo '<input type="hidden" name="client" value="admin" />';
		}
		?>
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}

}
?>
