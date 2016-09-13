<?php
/**
* @version $Id: admin.config.html.php 10002 2008-02-08 10:56:57Z willebil $
* @package Joomla / Tradução JoomlaClube 2008 - www.joomlaclube.com.br
* @subpackage Config
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
* @subpackage Config
*/
class HTML_config {

	function showconfig( &$row, &$lists, $option) {
		global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_session_type, $mainframe;

		$tabs = new mosTabs(0);
		?>
		<script type="text/javascript">
		<!--
		function saveFilePerms() {
			var f = document.adminForm;
			if (f.filePermsMode0.checked)
				f.config_fileperms.value = '';
			else {
				var perms = 0;
				if (f.filePermsUserRead.checked) perms += 400;
				if (f.filePermsUserWrite.checked) perms += 200;
				if (f.filePermsUserExecute.checked) perms += 100;
				if (f.filePermsGroupRead.checked) perms += 40;
				if (f.filePermsGroupWrite.checked) perms += 20;
				if (f.filePermsGroupExecute.checked) perms += 10;
				if (f.filePermsWorldRead.checked) perms += 4;
				if (f.filePermsWorldWrite.checked) perms += 2;
				if (f.filePermsWorldExecute.checked) perms += 1;
				f.config_fileperms.value = '0'+''+perms;
			}
		}
		function changeFilePermsMode(mode) {
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('filePermsValue').style.display = 'none';
						document.getElementById('filePermsTooltip').style.display = '';
						document.getElementById('filePermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('filePermsValue').style.display = '';
						document.getElementById('filePermsTooltip').style.display = 'none';
						document.getElementById('filePermsFlags').style.display = '';
				} // switch
			} // if
			saveFilePerms();
		}
		function saveDirPerms() {
			var f = document.adminForm;
			if (f.dirPermsMode0.checked)
				f.config_dirperms.value = '';
			else {
				var perms = 0;
				if (f.dirPermsUserRead.checked) perms += 400;
				if (f.dirPermsUserWrite.checked) perms += 200;
				if (f.dirPermsUserSearch.checked) perms += 100;
				if (f.dirPermsGroupRead.checked) perms += 40;
				if (f.dirPermsGroupWrite.checked) perms += 20;
				if (f.dirPermsGroupSearch.checked) perms += 10;
				if (f.dirPermsWorldRead.checked) perms += 4;
				if (f.dirPermsWorldWrite.checked) perms += 2;
				if (f.dirPermsWorldSearch.checked) perms += 1;
				f.config_dirperms.value = '0'+''+perms;
			}
		}
		function changeDirPermsMode(mode) 	{
			if(document.getElementById) {
				switch (mode) {
					case 0:
						document.getElementById('dirPermsValue').style.display = 'none';
						document.getElementById('dirPermsTooltip').style.display = '';
						document.getElementById('dirPermsFlags').style.display = 'none';
						break;
					default:
						document.getElementById('dirPermsValue').style.display = '';
						document.getElementById('dirPermsTooltip').style.display = 'none';
						document.getElementById('dirPermsFlags').style.display = '';
				} // switch
			} // if
			saveDirPerms();
		}
		function submitbutton(pressbutton) {
			var form = document.adminForm;

			// do field validation
			if (form.config_session_type.value != <?php echo $row->config_session_type; ?> ){
				if ( confirm('Tem a certeza que quer mudar o `Método de Autenticação de Sessão`? \n\n Isto irá fazer com que todas as atuais sessões do Site sejam eliminadas d \n\n') ) {
					submitform( pressbutton );
				} else {
					return;
				}
			} else {
				submitform( pressbutton );
			}
		}
		//-->
		</script>
		<form action="index2.php" method="post" name="adminForm">
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="250"><table class="adminheading"><tr><th nowrap="nowrap" class="config">Configuração Global</th></tr></table></td>
			<td width="270">
				<span class="componentheading">configuration.php está:
				<?php echo is_writable( '../configuration.php' ) ? '<b><font color="green"> Permissão para escrita</font></b>' : '<b><font color="red"> Não tem permissão para escrita</font></b>' ?>
				</span>
			</td>
			<?php
			if (mosIsChmodable('../configuration.php')) {
				if (is_writable('../configuration.php')) {
					?>
					<td>
						<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
						<label for="disable_write">Tornar inalterável após salvar</label>
					</td>
					<?php
				} else {
					?>
					<td>
						<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
						<label for="enable_write">Anular proteção e sobrescrever</label>
					</td>
				<?php
				} // if
			} // if
			?>
		</tr>
		</table>
			<?php
		$tabs->startPane("configPane");
		$tabs->startTab("Site","site-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Site Off-line:</td>
				<td><?php echo $lists['offline']; ?></td>
			</tr>
			<tr>
				<td valign="top">Mensagem Off-line:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_offline_message"><?php echo $row->config_offline_message; ?></textarea><?php
					$tip = 'Uma mensagem a ser exibida caso o site esteja Off-line';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td valign="top">Mensagem de erro de sistema:</td>
				<td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_error_message"><?php echo $row->config_error_message; ?></textarea><?php
					$tip = 'Uma mensagem a ser exibida caso o Joomla! não consiga efetuar uma ligação à base de dados';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Nome do site:</td>
				<td><input class="text_area" type="text" name="config_sitename" size="50" value="<?php echo $row->config_sitename; ?>"/></td>
			</tr>
			<tr>
				<td>Exibir links não autorizados:</td>
				<td><?php echo $lists['shownoauth']; ?><?php
					$tip = 'Se escolher `Sim´, serão exibidos os links para conteúdos que exigem registro.  O usuário deverá autenticar-se para ver o artigo completo.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Permitir cadastro de usuários:</td>
				<td><?php echo $lists['allowUserRegistration']; ?><?php
					$tip = 'Se escolher `Sim´, permite que usuários se registrem';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Ativação de novas contas:</td>
				<td><?php echo $lists['useractivation']; ?>
				<?php
					$tip = 'Se escolher `Sim´, o usuário receberá um e-mail com um link de ativação da sua conta antes de poder autenticar.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Requerer e-mail único:</td>
				<td><?php echo $lists['uniquemail']; ?><?php
					$tip = 'Se escolher `Sim´, os usuários não poderam partilhar o mesmo endereço de e-mail';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Autenticação no site - Frontend:</td>
				<td>
					<?php echo $lists['frontend_login']; ?>
					<?php
					$tip = 'Se escolher `Não´, impossibilita a autenticação no Site frontend, até mesmo quando não associado a um item de menu. Também impede a funcionalidade de Inscrição.';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Parâmetros do usuário no frontend:</td>
				<td>
					<?php echo $lists['frontend_userparams']; ?>
					<?php
					$tip = 'Se escolher `Não´, impede a funcionalidade de parâmetros de usuário no frontend';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Depurar site:</td>
				<td>
					<?php echo $lists['debug']; ?>
					<?php
					$tip = 'Se escolher `Sim´, exibe informações de diagnóstico e erros de SQL quando existirem';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Editor padrão WYSIWYG:</td>
				<td><?php echo $lists['editor']; ?></td>
			</tr>
			<tr>
				<td>Tamanho da Lista:</td>
				<td>
					<?php echo $lists['list_limit']; ?>
					<?php
					$tip = 'Configura o tamanho das listas da administração para todos os usuários';
					echo mosToolTip( $tip );
					?>
				</td>
			</tr>
			<tr>
				<td>Ícone de favoritos do site:</td>
				<td>
				<input class="text_area" type="text" name="config_favicon" size="20" value="<?php echo $row->config_favicon; ?>"/>
				<?php
				$tip = 'Se deixado em branco ou se o arquivo não for encontrado, o favicon.ico padrão será usando.';
				echo mosToolTip( $tip, 'Favourite Icon' );
				?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Localização","Locale-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Idioma do Site:</td>
				<td><?php echo $lists['lang']; ?></td>
			</tr>
			<tr>
				<td width="185">Fuso Horário:</td>
				<td>
				<?php echo $lists['offset']; ?>
				<?php
				$tip = "Data/hora atual configurada para exibição: " . mosCurrentDate(_DATE_FORMAT_LC2);
				echo mosToolTip($tip);
				?>
				</td>
			</tr>
			<tr>
				<td width="185">Diferença do Servidor:</td>
				<td>
				<input class="text_area" type="text" name="config_offset" size="15" value="<?php echo $row->config_offset; ?>" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<td width="185">Código do País:</td>
				<td>
				<input class="text_area" type="text" name="config_locale" size="15" value="<?php echo $row->config_locale; ?>"/>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Conteúdo","content-page");
			?>
			<table class="adminform">
			<tr>
				<td colspan="3">* Estes parâmeteros controlam os elementos de saída *<br/><br/></td>
			</tr>
			<tr>
				<td width="260">Títulos como Link:</td>
				<td width="150"><?php echo $lists['link_titles']; ?></td>
				<td><?php
					$tip = 'Se escolher `Sim´, o título dos artigos serão linkados para os artigos';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td width="200">Link leia mais:</td>
				<td width="150"><?php echo $lists['readmore']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, o link ´Ler mais´ será exibido caso o conteúdo possua um texto principal';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Avaliação/Votação do Item:</td>
				<td><?php echo $lists['vote']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, o sistema de votação será habilitado para itens de conteúdo';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Nomes dos Autores:</td>
				<td><?php echo $lists['hideAuthor']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, o nome do autor será exibido. Esta é a configuração global mas pode ser alterada no menu e nos níveis do item.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Data e Hora de Criação:</td>
				<td><?php echo $lists['hideCreateDate']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, a data e hora que um item foi criado será exibido. Esta é a configuração global mas pode ser alterada no menu e nos níveis do item.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Data e Hora de Alteração:</td>
				<td><?php echo $lists['hideModifyDate']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, a data e hora que um item foi alterado será exibido. Esta é a configuração global mas pode ser alterada no menu e nos níveis do item.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Acessos:</td>
				<td><?php echo $lists['hits']; ?></td>
				<td><?php
					$tip = 'Se configurado para exibir, os acesso para o item específico será exibido.  Esta é a configuração global mas pode ser alterada no menu e nos níveis do item.';
					echo mosToolTip( $tip );
				?></td>
			</tr>
			<tr>
				<td>Ícone PDF:</td>
				<td><?php echo $lists['hidePdf']; ?></td>
				<?php
				if (!is_writable( "$mosConfig_absolute_path/media/" )) {
					echo "<td align=\"left\">";
					echo mosToolTip('Opção não disponível pois o diretório /media não possui permissão para escrita');
					echo "</td>";
				} else {
					?>
					<td>&nbsp;</td>
					<?php
				}
				?>
			</tr>
			<tr>
				<td>Ícone Impressora:</td>
				<td><?php echo $lists['hidePrint']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Ícone E-mail:</td>
				<td><?php echo $lists['hideEmail']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Ícones:</td>
				<td><?php echo $lists['icons']; ?></td>
				<td><?php echo mosToolTip('Imprimir, PDF e Email podem utilizar Icones ou Texto'); ?></td>
			</tr>
			<tr>
				<td>Tabela de Índice em artigos de múltiplas páginas:</td>
				<td><?php echo $lists['multipage_toc']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Botão ` Voltar ´:</td>
				<td><?php echo $lists['back_button']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Navegação de Item de Conteúdo:</td>
				<td><?php echo $lists['item_navigation']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Modo de Compatibilidade de Itemid:</td>
				<td><?php echo $lists['itemid_compat']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<input type="hidden" name="config_multilingual_support" value="<?php echo $row->config_multilingual_support?>">
			<?php
		$tabs->endTab();
		$tabs->startTab("Base Dados","db-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Nome do Servidor:</td>
				<td><input class="text_area" type="text" name="config_host" size="25" value="<?php echo $row->config_host; ?>"/></td>
			</tr>
			<tr>
				<td>Nome de Utilizador MySQL:</td>
				<td><input class="text_area" type="text" name="config_user" size="25" value="<?php echo $row->config_user; ?>"/></td>
			</tr>
			<tr>
				<td>Base de Dados MySQL:</td>
				<td><input class="text_area" type="text" name="config_db" size="25" value="<?php echo $row->config_db; ?>"/></td>
			</tr>
			<tr>
				<td>Prefixo da Base de Dados MySQL:</td>
				<td>
				<input class="text_area" type="text" name="config_dbprefix" size="10" value="<?php echo $row->config_dbprefix; ?>"/>
				&nbsp;<?php echo mosWarning('!! NÃO ALTERE A NÃO SER QUE TENHA UMA BASE DE DADOS COM UM PREFIXO DE TABELAS DIFERENTE DESTE !!'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Servidor","server-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Caminho Absoluto:</td>
				<td width="450"><strong><?php echo $row->config_absolute_path; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>URL do Site:</td>
				<td><strong><?php echo $row->config_live_site; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Palavra Secreta:</td>
				<td><strong><?php echo $row->config_secret; ?></strong></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Compressão GZIP de Páginas:</td>
				<td>
				<?php echo $lists['gzip']; ?>
				<?php echo mosToolTip('Memória de Compressão de saída caso seja suportado'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Duração da Sessão do Usuário:</td>
				<td>
				<input class="text_area" type="text" name="config_lifetime" size="10" value="<?php echo $row->config_lifetime; ?>"/>
				&nbsp;segundos&nbsp;
				<?php echo mosWarning('Fim de sessão automático após este tempo de inatividade. Quanto mais alto o valor maior o risco de segurança!'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Duração da Sessão de Administração:</td>
				<td>
				<input class="text_area" type="text" name="config_session_life_admin" size="10" value="<?php echo $row->config_session_life_admin; ?>"/>
				&nbsp;segundos&nbsp;
				<?php echo mosWarning('Fim de sessão automático após este tempo de inatividade. Quanto mais alto o valor maior o risco de segurança!'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Lembre de página de Admin Expirada:</td>
				<td>
				<?php echo $lists['admin_expired']; ?>
				<?php echo mosToolTip('Se a sessão expirar, e se efetuar novo início de sessão num espaço de tempo inferior a 10 minutos, será redirecionado à página que estava a tentando acessar quando foi desligado.'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Método de Autenticação de sessão:</td>
				<td>
				<?php echo $lists['session_type']; ?>
				&nbsp;&nbsp;
				<?php echo mosWarning('Não mude a menos que saiba o que está a fazer!<br /> <br /> Se tem muitos usuários AOL ou condicionados por Proxys, poderá considerar a utilização da configuração Nível 2' ); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Relatório de Erros:</td>
				<td><?php echo $lists['error_reporting']; ?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Servidor de Ajuda:</td>
				<td><input class="text_area" type="text" name="config_helpurl" size="50" value="<?php echo $row->config_helpurl; ?>"/></td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0644;
				if ($row->config_fileperms!='') {
					$mode = 1;
					$flags = octdec($row->config_fileperms);
				} // if
				?>
				<td valign="top">Criação de Arquivos:</td>
				<td>
					<fieldset><legend>Permissões de Arquivos</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="filePermsMode0">Não aplicar CHMOD a novos arquivos (usar padrão do servidor)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="filePermsMode1">Aplicar CHMOD a novos arquivos </label>
									<span id="filePermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									para: <input class="text_area" type="text" readonly="readonly" name="config_fileperms" size="4" value="<?php echo $row->config_fileperms; ?>"/>
									</span>
									<span id="filePermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Selecione esta opção para definir as permissões para novos arquivos criados'); ?>
									</span>
								</td>
							</tr>
							<tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="0" cellspacing="1" border="0">
										<tr>
											<td style="padding:0px">Usuário:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsUserWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="filePermsUserExecute">execução</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Grupo:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsGroupWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="filePermsGroupExecute">execução</label></td>
											<td><input type="checkbox" id="applyFilePerms" name="applyFilePerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyFilePerms">
													Aplicar a arquivos existentes
													&nbsp;<?php
													echo mosWarning(
														'Selecionando aqui serão aplicadas as permissões a <em>todos os arquivos existentes</em> do site.<br/>'.
														'<b>USO INAPROPRIADO DESTA OPÇÃO PODE DEIXAR O SITE INOPERANTE!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">Geral:</td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="filePermsWorldWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="4"><label for="filePermsWorldExecute">execução</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<?php
				$mode = 0;
				$flags = 0755;
				if ($row->config_dirperms!='') {
					$mode = 1;
					$flags = octdec($row->config_dirperms);
				} // if
				?>
				<td valign="top">Criação de Diretórios:</td>
				<td>
					<fieldset><legend>Permissões de Diretórios</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
								<td><label for="dirPermsMode0">Não aplicar CHMOD a novos diretórios (usar padrão do servidor)</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
								<td>
									<label for="dirPermsMode1">Aplicar CHMOD a novos diretórios para </label> 
									<span id="dirPermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
									to: <input class="text_area" type="text" readonly="readonly" name="config_dirperms" size="4" value="<?php echo $row->config_dirperms; ?>"/>
									</span>
									<span id="dirPermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
									&nbsp;<?php echo mosToolTip('Selecione esta opção para definir as permissões para os novos diretórios a serem criados'); ?>
									</span>
								</td>
							</tr>
							<tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
								<td>&nbsp;</td>
								<td>
									<table cellpadding="1" cellspacing="0" border="0">
										<tr>
											<td style="padding:0px">Usuário:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsUserWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsUserSearch">execução</label></td>
										</tr>
										<tr>
											<td style="padding:0px">Grupo:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsGroupWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" width="70"><label for="dirPermsGroupSearch">execução</label></td>
											<td><input type="checkbox" id="applyDirPerms" name="applyDirPerms" value="1"/></td>
											<td nowrap="nowrap">
												<label for="applyDirPerms">
													Aplicar a diretórios existentes
													&nbsp;<?php
													echo mosWarning(
														'Selecione para aplicar as permissões a <em>todos os diretórios existentes</em> no site.<br/>'.
														'<b>O USO INAPROPRIADO DESTA OPÇÃO PODE DEIXAR O SITE INOPERANTE!</b>'
													);?>
												</label>
											</td>
										</tr>
										<tr>
											<td style="padding:0px">Todos:</td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldRead">leitura</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px"><label for="dirPermsWorldWrite">escrita</label></td>
											<td style="padding:0px"><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
											<td style="padding:0px" colspan="3"><label for="dirPermsWorldSearch">execução</label></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<?php
				$rgmode = 0;
				if( defined( 'RG_EMULATION' ) ) {
					$rgmode = RG_EMULATION;
				}
				?>
				<td valign="top">Registro Emulação de Globals:</td>
				<td>
					<fieldset><legend>Register Globals Emulation</legend>
						<table cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td><input type="radio" id="rgemulation" name="rgemulation" value="0"<?php if (!$rgmode) echo ' checked="checked"'; ?>/></td>
								<td><label for="rgemulation">OFF - more secure and the preferred setting</label></td>
							</tr>
							<tr>
								<td><input type="radio" id="rgemulation" name="rgemulation" value="1"<?php if ($rgmode) echo ' checked="checked"'; ?>/></td>
								<td><label for="rgemulation">ON - better compatibility but less secure</label></td>
							</tr>
							</tr>
						</table>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>

			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Metadados","metadata-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185" valign="top">Metadados de Descrição Global do Site:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaDesc"><?php echo $row->config_MetaDesc; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Palavras-Chave do Site:</td>
				<td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_MetaKeys"><?php echo $row->config_MetaKeys; ?></textarea></td>
			</tr>
			<tr>
				<td valign="top">Exibir Metadados de Título:</td>
				<td>
				<?php echo $lists['MetaTitle']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Exibir a tag de título quando exibir artigos'); ?>
				</td>
			  	</tr>
			<tr>
				<td valign="top">Exibir Metadados de Autor:</td>
				<td>
				<?php echo $lists['MetaAuthor']; ?>
				&nbsp;&nbsp;&nbsp;
				<?php echo mosToolTip('Exibir a tag de autor quando exibir artigos'); ?>
				</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("E-mail","mail-page");
			?>
			<table class="adminform">
			<tr>
				<td width="185">Emissor de E-mail:</td>
				<td><?php echo $lists['mailer']; ?></td>
			</tr>
			<tr>
				<td>E-Mail do Remetente:</td>
				<td><input class="text_area" type="text" name="config_mailfrom" size="50" value="<?php echo $row->config_mailfrom; ?>"/></td>
			</tr>
			<tr>
				<td>Nome do Remetente:</td>
				<td><input class="text_area" type="text" name="config_fromname" size="50" value="<?php echo $row->config_fromname; ?>"/></td>
			</tr>
			<tr>
				<td>Caminho do Sendmail:</td>
				<td><input class="text_area" type="text" name="config_sendmail" size="50" value="<?php echo $row->config_sendmail; ?>"/></td>
			</tr>
			<tr>
				<td>Autenticação de SMTP:</td>
				<td><?php echo $lists['smtpauth']; ?></td>
			</tr>
			<tr>
				<td>Utilizador SMTP:</td>
				<td><input class="text_area" type="text" name="config_smtpuser" size="50" value="<?php echo $row->config_smtpuser; ?>"/></td>
			</tr>
			<tr>
				<td>Senha SMTP:</td>
				<td><input class="text_area" type="text" name="config_smtppass" size="50" value="<?php echo $row->config_smtppass; ?>"/></td>
			</tr>
			<tr>
				<td>Servidor SMTP:</td>
				<td><input class="text_area" type="text" name="config_smtphost" size="50" value="<?php echo $row->config_smtphost; ?>"/></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Cache","cache-page");
			?>
			<table class="adminform" border="0">
			<?php
			if (is_writeable($row->config_cachepath)) {
				?>
				<tr>
					<td width="185">Cache:</td>
					<td width="500"><?php echo $lists['caching']; ?></td>
					<td>&nbsp;</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td>Diretório de Cache:</td>
				<td>
				<input class="text_area" type="text" name="config_cachepath" size="50" value="<?php echo $row->config_cachepath; ?>"/>
				<?php
				if (is_writeable($row->config_cachepath)) {
					echo mosToolTip('O atual Diretório de Cache é <b>Possui permissão para escrita</b>');
				} else {
					echo mosWarning('O diretório de cache não possui permissão para escrita - por favor configure este diretório para CHMOD 0766 antes de ativar a cache');
				}
				?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Duração da Cache:</td>
				<td><input class="text_area" type="text" name="config_cachetime" size="5" value="<?php echo $row->config_cachetime; ?>"/> segundos</td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("Estatísticas","stats-page");
			?>
			<table class="adminform">
			<tr>
				<td width="250">Estatísticas:</td>
				<td width="100"><?php echo $lists['enable_stats']; ?></td>
				<td><?php echo mostooltip('Ativar/Desativar estatísticas do site'); ?></td>
			</tr>
			<tr>
				<td>Registro de acessos ao conteúdo por data:</td>
				<td><?php echo $lists['log_items']; ?></td>
				<td><span class="error"><?php echo mosWarning('CUIDADO : Serão recolhidas grandes quantidades de dados. Por motivos de segurança não deve utilizar esta funcionalidade. Utilize um componente ou serviço independente'); ?></span></td>
			</tr>
			<tr>
				<td>Registro de palavras pesquisadas:</td>
				<td><?php echo $lists['log_searches']; ?></td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->startTab("SEO","seo-page");
			?>
			<table class="adminform">
			<tr>
				<td width="250"><strong>Otimização para motores de busca</strong></td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>URLs Amigáveis para motores de busca:</td>
				<td><?php echo $lists['sef']; ?>&nbsp;</td>
				<td><span class="error"><?php echo mosWarning('Somente Apache! Renomear htaccess.txt para .htaccess antes de ativar'); ?></span></td>
			</tr>
			<tr>
				<td>Títulos dinâmicos de páginas:</td>
				<td><?php echo $lists['pagetitles']; ?></td>
				<td><?php echo mosToolTip('Alterar dinamicamente o título da página para refletir o conteúdo visualizado'); ?></td>
			</tr>
			</table>
			<?php
		$tabs->endTab();
		$tabs->endPane();

		// show security setting check
		josSecurityCheck();
		?>

		<input type="hidden" name="option" value="<?php echo $option; ?>"/>
		<input type="hidden" name="config_absolute_path" value="<?php echo $row->config_absolute_path; ?>"/>
		<input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>"/>
		<input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>"/>
	  	<input type="hidden" name="task" value=""/>
		<input type="hidden" name="<?php echo josSpoofValue(); ?>" value="1" />
		</form>
		<script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<?php
	}

}
?>