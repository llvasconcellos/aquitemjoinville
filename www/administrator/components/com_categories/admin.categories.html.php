<?php
/**
* @version $Id: admin.categories.html.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla / Tradução JoomlaClube 2008 - www.joomlaclube.com.br
* @subpackage Categories
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
* @subpackage Categories
*/
class categories_html {

	/**
	* Writes a list of the categories for a section
	* @param array An array of category objects
	* @param string The name of the category section
	*/
	function show( &$rows, $section, $section_name, &$pageNav, &$lists, $type ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<?php
			if ( $section == 'content') {
				?>
				<th class="categories">
				Administrar Categoria <small><small>[ Conteúdo: Todos ]</small></small>
				</th>
				<td width="right">
				<?php echo $lists['sectionid'];?>
				</td>
				<?php
			} else {
				if ( is_numeric( $section ) ) {
					$query = 'com_content&sectionid=' . $section;
				} else {
					if ( $section == 'com_contact_details' ) {
						$query = 'com_contact';
					} else {
						$query = $section;
					}
				}
				?>
				<th class="categories">
				Administrar Categoria <small><small>[ <?php echo $section_name;?> ]</small></small>
				</th>
				<?php
			}
			?>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="10" align="left">
			nº
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			Nome Categoria
			</th>
			<th width="10%">
			Publicado
			</th>
			<?php
			if ( $section != 'content') {
				?>
				<th colspan="2" width="5%">
				Reordenar
				</th>
				<?php
			}
			?>
			<th width="2%">
			Ordem
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Salvar Ordem" /></a>
			</th>
			<th width="10%">
			Acesso
			</th>
			<?php
			if ( $section == 'content') {
				?>
				<th width="12%" align="left">
				Seção
				</th>
				<?php
			}
			?>
			<th width="5%" nowrap="nowrap">
			ID da Categoria
			</th>
			<?php
			if ( $type == 'content') {
				?>
				<th width="5%">
				Ativo
				</th>
				<th width="5%">
				Lixeira
				</th>
				<?php
			} else {
				?>
				<th width="20%">
				</th>
				<?php
			}
			?>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row 	= &$rows[$i];
			mosMakeHtmlSafe($row);
			$row->sect_link = 'index2.php?option=com_sections&task=editA&hidemainmenu=1&id='. $row->section;

			$link = 'index2.php?option=com_categories&section='. $section .'&task=editA&hidemainmenu=1&id='. $row->id;
			if ($row->checked_out_contact_category) {
				$row->checked_out = $row->checked_out_contact_category;
			}
			$access 	= mosCommonHTML::AccessProcessing( $row, $i );
			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
			$published 	= mosCommonHTML::PublishedProcessing( $row, $i );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out_contact_category && ( $row->checked_out_contact_category != $my->id ) ) {
					echo stripslashes( $row->name ) .' ( '. stripslashes( $row->title ) .' )';
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo stripslashes( $row->name ) .' ( '. stripslashes( $row->title ) .' )'; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<?php echo $published;?>
				</td>
				<?php
				if ( $section != 'content' ) {
					?>
					<td>
					<?php echo $pageNav->orderUpIcon( $i ); ?>
					</td>
					<td>
					<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
					</td>
					<?php
				}
				?>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<?php echo $access;?>
				</td>
				<?php
				if ( $section == 'content' ) {
					?>
					<td align="left">
					<a href="<?php echo $row->sect_link; ?>" title="Editar Seção">
					<?php echo $row->section_name; ?>
					</a>
					</td>
					<?php
				}
				?>
				<td align="center">
				<?php echo $row->id; ?>
				</td>
				<?php
				if ( $type == 'content') {
					?>
					<td align="center">
					<?php echo $row->active; ?>
					</td>
					<td align="center">
					<?php echo $row->trash; ?>
					</td>
					<?php
				} else {
					?>
					<td>
					</td>
					<?php
				}
				$k = 1 - $k;
				?>
			</tr>
			<?php
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	* @param mosCategory The category object
	* @param string
	* @param array
	*/
	function edit( &$row, &$lists, $redirect, $menus ) {
		if ($row->image == "") {
			$row->image = 'blank.png';
		}

		if ( $redirect == 'content' ) {
			$component = 'Conteúdo';
		} else {
			$component = ucfirst( substr( $redirect, 4 ) );
			if ( $redirect == 'com_contact_details' ) {
				$component = 'Contato';
			}
		}
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'description' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton, section) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "Por favor, Selecione um menu" );
					return;
				} else if ( form.link_type.value == "" ) {
					alert( "Por favor, selecione um tipo de menu" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "Por favor, informe um nome para este item do menu" );
					return;
				}
			}

			if ( form.name.value == "" ) {
				alert("Categoria deve ter um nome");
			} else if (form.title.value ==""){
				alert("A Categoria deve ter um título");
			} else {
				<?php getEditorContents( 'editor1', 'description' ) ; ?>
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="categories">
			Categoria:
			<small>
			<?php echo $row->id ? 'Editar' : 'Nova';?>
			</small>
			<small><small>
			[ <?php echo $component; ?>: <?php echo stripslashes($row->name); ?> ]
			</small></small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td valign="top" width="60%">
				<table class="adminform">
				<tr>
					<th colspan="3">
					Detalhes da Categoria
					</th>
				<tr>
				<tr>
					<td>
					Título da Categoria:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo stripslashes( $row->title ); ?>" size="50" maxlength="50" title="Um nome abreviado para ser utilizado nos menus" />
					</td>
				</tr>
				<tr>
					<td>
					Nome Categoria:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="name" value="<?php echo stripslashes( $row->name ); ?>" size="50" maxlength="255" title="Um nome longo para ser utilizado nos cabeçalhos" />
					</td>
				</tr>
				<tr>
					<td>
					Seções:
					</td>
					<td colspan="2">
					<?php echo $lists['section']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Ordenando:
					</td>
					<td colspan="2">
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Imagem:
					</td>
					<td>
					<?php echo $lists['image']; ?>
					</td>
					<td rowspan="5" width="50%">
					<script language="javascript" type="text/javascript">
					if (document.forms[0].image.options.value!=''){
					  jsimg='../images/stories/' + getSelectedValue( 'adminForm', 'image' );
					} else {
					  jsimg='../images/M_images/blank.png';
					}
					document.write('<img src=' + jsimg + ' name="imagelib" width="80" height="80" border="2" alt="Preview" />');
					</script>
					</td>
				</tr>
				<tr>
					<td>
					Posição da Imagem:
					</td>
					<td>
					<?php echo $lists['image_position']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Nível de Acesso:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td>
					Publicado:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
					Descrição:
					</td>
				</tr>
				<tr>
					<td colspan="3">
					<?php
					// parameters : areaname, content, hidden field, width, height, rows, cols
					editorArea( 'editor1',  $row->description , 'description', '100%;', '300', '60', '20' ) ; ?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" width="40%">
				<?php
				if ( $row->id > 0 ) {
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
						Link to Menu
						</th>
					<tr>
					<tr>
						<td colspan="2">
					Este irá criar um novo item de menu no menu que você selecionou <br />
						<br /><br />
						</td>
					<tr>
					<tr>
						<td valign="top" width="100">
					Selecione um Menu 
						</td>
						<td>
						<?php echo $lists['menuselect']; ?>
						</td>
					<tr>
					<tr>
						<td valign="top" width="100">
					Tipo do Menu 
						</td>
						<td>
						<?php echo $lists['link_type']; ?>
						</td>
					<tr>
					<tr>
						<td valign="top" width="100">
					Nome do Menu 
						</td>
						<td>
						<input type="text" name="link_name" class="inputbox" value="" size="25" />
						</td>
					<tr>
					<tr>
						<td>
						</td>
						<td>
						<input name="menu_link" type="button" class="button" value="Link to Menu" onClick="submitbutton('menulink');" />
						</td>
					<tr>
					<tr>
						<th colspan="2">
					Links de menus existentes 
						</th>
					</tr>
					<?php
					if ( $menus == NULL ) {
						?>
						<tr>
							<td colspan="2">
							Nenhum
							</td>
						</tr>
						<?php
					} else {
						mosCommonHTML::menuLinksSecCat( $menus );
					}
					?>
					<tr>
						<td colspan="2">
						</td>
					</tr>
					</table>
					<?php
				} else {
					?>
					<table class="adminform" width="40%">
					<tr>
						<th>&nbsp;
						
						</th>
					</tr>
					<tr>
						<td>
						Links de menus dispon&iacute;veis somente depois de salva a categoria
						</td>
					</tr>
					</table>
					<?php
				}
				// content
				if ( $row->section > 0 || $row->section == 'content' ) {
					?>
					<br />
					<table class="adminform">
					<tr>
						<th colspan="2">
						Diretórios MOSImage
						</th>
					<tr>
					<tr>
						<td colspan="2">
						<?php echo $lists['folders']; ?>
						</td>
					<tr>
					</table>
					<?php
				}
				?>
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="com_categories" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="sectionid" value="<?php echo $row->section; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}


	/**
	* Form to select Section to move Category to
	*/
	function moveCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			Mover Categoria
			</th>
		</tr>
		</table>

		<br />
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectionmove' )) {
				alert( "Por favor, selecione uma Seção para mover a Categoria " );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Mover para a Seção:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Categoria que esta sendo movida:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong>Itens de conteúdo que serão movidos:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			A categoria aqui listada
			<br />
			e todo o seu conteúdo, serão copiados
			<br />
			para a seção selecionada.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}


	/**
	* Form to select Section to copy Category to
	*/
	function copyCategorySelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="categories">
			Copiar Categoria
			</th>
		</tr>
		</table>

		<br />
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (!getSelectedValue( 'adminForm', 'sectionmove' )) {
				alert( "Por favor, selecione uma Seção para copiar a Categoria " );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Copiar para a seção:</strong>
			<br />
			<?php echo $SectionList ?>
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Categoria que esta sendo copiada:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $items as $item ) {
				echo "<li>". $item->name ."</li>";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top" width="20%">
			<strong>Itens de conteúdo que serão copiados:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $contents as $content ) {
				echo "<li>". $content->title ."</li>";
				echo "\n <input type=\"hidden\" name=\"item[]\" value=\"$content->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			As categorias aqui listadas
			<br />
			e todo o seu conteúdo, serão copiados
			<br />
			para a seção selecionada.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $sectionOld;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		<input type="hidden" name="task" value="" />
		<?php
		foreach ( $cid as $id ) {
			echo "\n <input type=\"hidden\" name=\"cid[]\" value=\"$id\" />";
		}
		?>
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}

}
?>
