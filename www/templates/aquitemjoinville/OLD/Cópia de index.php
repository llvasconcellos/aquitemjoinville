<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
		<?php
		if ($my->id) { initEditor(); } ?>
		<?php mosShowHead(); ?>
		<script type="text/javascript"></script>
		<link href="templates/<?php echo $cur_template; ?>/css/template_css.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
		<table width="1100" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td colspan="3" width="100%" height="132" background="templates/<?php echo $cur_template; ?>/images/cabecalho.jpg">
					<div id="logo"></div>
				</td>
			</tr>
			<tr>
				<td width="19" background="templates/<?php echo $cur_template; ?>/images/lesq.gif" style="background-position:top; background-repeat:no-repeat; background-color:#1C1916;">&nbsp;
					
				</td>
				<td width="152" valign="top" align="left" style="border-left:3px solid #23201d; background-image:url(templates/<?php echo $cur_template; ?>/images/fundo_listrado.gif)">
					<div style="width:152px; height:60px; background-image:url(templates/<?php echo $cur_template; ?>/images/liberdade.jpg); background-repeat:no-repeat;">
					</div>
					<div style="width:100%; padding-left:7px; padding-right:7px;">
						<?php mosLoadModules('left');?>
					</div>
				</td>
				<td width="929" valign="top" id="conteudo">
					<br />
					<? if ($_REQUEST["option"] == "com_contact"){ ?>
						<table style="width: 100%" width="100%" border="0" cellpadding="5" cellspacing="5">
							<tbody>
								<tr>
									<td valign="top" width="208">
									<table style="width: 208px" border="0" cellpadding="3" cellspacing="0">
										<tbody>
											<tr>
												<td style="border: 1px solid #2d2a28">
												<img src="http://localhost/NovoMobtex/images/stories/foto_empresa.jpg" alt="foto_empresa.jpg" title="foto_empresa.jpg" style="margin: 5px; float: left; width: 204px; height: 267px" width="204" height="267" /></td>
											</tr>
											<tr>
												<td style="border: medium none ; height: 5px; font-size: 5px">
												&nbsp;
												</td>
											</tr>
											<tr>
												<td style="border: 1px solid #2d2a28; padding: 5px" valign="middle" align="center">CONHE&Ccedil;A AS LINHAS
												</td>
											</tr>
											<tr>
												<td style="border: 1px solid #2d2a28; padding: 5px; background-image: url('http://localhost/NovoMobtex/templates/mobtex/images/fundobolinha.gif')" valign="middle" align="center">
												<img src="http://localhost/NovoMobtex/images/stories/fitness.png" alt="fitness.png" title="fitness.png" width="136" height="45" /></td>
											</tr>
											<tr>
												<td style="border: 1px solid #2d2a28; padding: 5px; background-image: url('http://localhost/NovoMobtex/templates/mobtex/images/fundobolinha.gif')" valign="middle" align="center">
												<img src="http://localhost/NovoMobtex/images/stories/diverse.png" alt="diverse.png" title="diverse.png" width="136" height="45" /></td>
											</tr>
											<tr>
												<td style="border: 1px solid #2d2a28; padding: 5px; background-image: url('http://localhost/NovoMobtex/templates/mobtex/images/fundobolinha.gif')" valign="middle" align="center">
												<img src="http://localhost/NovoMobtex/images/stories/shoes.png" alt="shoes.png" title="shoes.png" width="136" height="45" /></td>
											</tr>
										</tbody>
									</table>
									</td>
									<td valign="top">
									<table style="border: 1px solid #2d2a28" width="330">
										<tbody>
											<tr>
												<td style="border: 1px solid #2d2a28; background-color: #171411; height: 50px" valign="top">
												<hr size="1" width="100%" color="#ffbc2d" />
												CONTATO</td>
											</tr>
											<tr>
												<td valign="top">
													<?php mosMainBody(); ?>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>

					<? } 
					else{ 
						mosMainBody(); 
					}
					?>
					<br /><br />
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<div id="footer" style="color:#989898;">
						<?php mosLoadModules('footer');?>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>