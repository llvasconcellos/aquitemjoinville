<?php
/**
* @version $Id: admin.sections.html.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla
* @subpackage Sections
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
* @subpackage Sections
*/
class sections_html {
	/**
	* Writes a list of the categories for a section
	* @param array An array of category objects
	* @param string The name of the category section
	*/
	function show( &$rows, $scope, $myid, &$pageNav, $option ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			 <th class="sections">
			Administrar Seções
			</th>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="20">
			nº
			</th>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onClick="checkAll(<?php echo count( $rows );?>);" />
			</th>
			<th class="title">
			Nome da Seção 
			</th>
			<th width="10%">
			Publicado
			</th>
			<th colspan="2" width="5%">
			Reordenar
			</th>
			<th width="2%">
			Ordem
			</th>
			<th width="1%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )"><img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" /></a>
			</th>
			<th width="8%">
			Acesso
			</th>
			<th width="12%" nowrap="nowrap">
			ID da Seção
			</th>
			<th width="12%" nowrap="nowrap">
			Categorias
			</th>
			<th width="12%" nowrap="nowrap">
			Ativo
			</th>
			<th width="12%" nowrap="nowrap">
			Lixeira
			</th>

		</tr>
		<?php
		$k = 0;
		for ( $i=0, $n=count( $rows ); $i < $n; $i++ ) {
			$row = &$rows[$i];
			mosMakeHtmlSafe($row);
			$link = 'index2.php?option=com_sections&scope=content&task=editA&hidemainmenu=1&id='. $row->id;

			$access 	= mosCommonHTML::AccessProcessing( $row, $i );
			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );
			$published 	= mosCommonHTML::PublishedProcessing( $row, $i );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td width="20" align="right">
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td width="20">
				<?php echo $checked; ?>
				</td>
				<td width="35%">
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->name. " ( ". $row->title ." )";
				} else {
					?>
					<a href="<?php echo $link; ?>">
					<?php echo $row->name. " ( ". $row->title ." )"; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<?php echo $published;?>
				</td>
				<td>
				<?php echo $pageNav->orderUpIcon( $i ); ?>
				</td>
				<td>
				<?php echo $pageNav->orderDownIcon( $i, $n ); ?>
				</td>
				<td align="center" colspan="2">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
				<?php echo $access;?>
				</td>
				<td align="center">
				<?php echo $row->id; ?>
				</td>
				<td align="center">
				<?php echo $row->categories; ?>
				</td>
				<td align="center">
				<?php echo $row->active; ?>
				</td>
				<td align="center">
				<?php echo $row->trash; ?>
				</td>
				<?php
				$k = 1 - $k;
				?>
			</tr>
			<?php
		}
		?>
		</table>

		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="scope" value="<?php echo $scope;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.  Note that the <var>section</var> property <b>must</b> be defined
	* even for a new record.
	* @param mosCategory The category object
	* @param string The html for the image list select list
	* @param string The html for the image position select list
	* @param string The html for the ordering list
	* @param string The html for the groups select list
	*/
	function edit( &$row, $option, &$lists, &$menus ) {
		global $mosConfig_live_site;

		if ( $row->name != '' ) {
			$name = $row->name;
		} else {
			$name = "Nova Seção";
		}
		if ($row->image == "") {
			$row->image = 'blank.png';
		}

		mosMakeHtmlSafe( $row, ENT_QUOTES, 'descrição' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( pressbutton == 'menulink' ) {
				if ( form.menuselect.value == "" ) {
					alert( "Selecione um menu" );
					return;
				} else if ( form.link_type.value == "" ) {
					alert( "Por favor, selecione um tipo de menu" );
					return;
				} else if ( form.link_name.value == "" ) {
					alert( "Por favor, informe um nome para este item do menu" );
					return;
				}
			}

			if (form.name.value == ""){
				alert("Seção tem que possuir um nome");
			} else if (form.title.value ==""){
				alert("A seção tem que possuir um título");
			} else {
				<?php getEditorContents( 'editor1', 'description' ) ; ?>
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th class="sections">
			Seção:
			<small>
			<?php echo $row->id ? 'Editar' : 'Nova';?>
			</small>
			<small><small>
			[ <?php echo stripslashes($name); ?> ]
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
					Detalhes da Seção
					</th>
				<tr>
				<tr>
					<td width="100">
					Âmbito:
					</td>
					<td width="85%" colspan="2">
					<strong>
					<?php echo $row->scope; ?>
					</strong>
					</td>
				</tr>
				<tr>
					<td>
					Título:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="title" value="<?php echo $row->title; ?>" size="50" maxlength="50" title="Um nome abreviado para ser utilizado nos menus" />
					</td>
				</tr>
				<tr>
					<td>
					<?php echo (isset($row->section) ? "Categoria" : "Seção");?> Nome:
					</td>
					<td colspan="2">
					<input class="text_area" type="text" name="name" value="<?php echo $row->name; ?>" size="50" maxlength="255" title="Um nome longo para ser utilizado nos cabeçalhos" />
					</td>
				</tr>
				<tr>
					<td>
					Ordenação:
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
					<?php
						$path = $mosConfig_live_site . "/images/";
						if ($row->image != "blank.png") {
							$path.= "stories/";
						}
					?>
					<img src="<?php echo $path . $row->image;?>" name="imagelib" width="80" height="80" border="2" alt="Pré-visualizar" />
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
			<td valign="top">
				<?php
				if ( $row->id > 0 ) {
					?>
					<table class="adminform">
					<tr>
						<th colspan="2">
					        Link Menu 
						</th>
					<tr>
					<tr>
						<td colspan="2">
					        Este irá criar um novo item de menu no menu que você selecionou
						<br /><br />
						</td>
					<tr>
					<tr>
						<td valign="top" width="100px">
					        Selecione um Menu 
						</td>
						<td>
						<?php echo $lists['menuselect']; ?>
						</td>
					<tr>
					<tr>
						<td valign="top" width="100px">
						Tipo do Menu 
						</td>
						<td>
						<?php echo $lists['link_type']; ?>
						</td>
					<tr>
					<tr>
						<td valign="top" width="100px">
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
						<th>
						&nbsp;
						</th>
					</tr>
					<tr>
						<td>
						Links de menus disponíveis somente depois de salvar a seção
						</td>
					</tr>
					</table>
					<?php
				}
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
			</td>
		</tr>
		</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="scope" value="<?php echo $row->scope; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="hidemainmenu" value="0" />
		<input type="hidden" name="oldtitle" value="<?php echo $row->title ; ?>" />
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<?php
	}


	/**
	* Form to select Section to copy Category to
	*/
	function copySectionSelect( $option, $cid, $categories, $contents, $section ) {
		?>
		<form action="index2.php" method="post" name="adminForm">
		<br />
		<table class="adminheading">
		<tr>
			<th class="sections">
			Copiar Seção
			</th>
		</tr>
		</table>

		<br />
		<table class="adminform">
		<tr>
			<td width="3%"></td>
			<td align="left" valign="top" width="30%">
			<strong>Copie para a seção abaixo:</strong>
			<br />
			<input class="text_area" type="text" name="title" value="" size="35" maxlength="50" title="The new Section name" />
			<br /><br />
			</td>
			<td align="left" valign="top" width="20%">
			<strong>Categories being copied:</strong>
			<br />
			<?php
			echo "<ol>";
			foreach ( $categories as $category ) {
				echo "<li>". $category->name ."</li>";
				echo "\n <input type=\"hidden\" name=\"category[]\" value=\"$category->id\" />";
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
				echo "\n <input type=\"hidden\" name=\"content[]\" value=\"$content->id\" />";
			}
			echo "</ol>";
			?>
			</td>
			<td valign="top">
			Isto copiará; as categorias listadas
			<br />
			e todos os artigos dentro da categoria (igualmente listada)
			<br />
			para a nova Seção criada.
			</td>.
		</tr>
		</table>
		<br /><br />

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="section" value="<?php echo $section;?>" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="scope" value="content" />
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
