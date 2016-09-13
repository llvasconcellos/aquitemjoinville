<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<?php
		if ($my->id) { initEditor(); } ?>
		<?php mosShowHead(); ?>
		<?php
		   if (eregi("MSIE",getenv("HTTP_USER_AGENT")) || eregi("Internet Explorer",getenv("HTTP_USER_AGENT"))) {
		   		?>
					<link href="templates/<?php echo $cur_template; ?>/css/template_ie_css.css" rel="stylesheet" type="text/css" media="screen" />		
				<?
		   }
		   else {
		   	?>
				<link href="templates/<?php echo $cur_template; ?>/css/template_css.css" rel="stylesheet" type="text/css" media="screen" />		
			<?
		   }
		?>
		<script language="javascript">
			function selecionaAnunciante(idTipo){
				self.location = "index.php?option=com_segmentos&tipo=" + idTipo;
			}
		</script>
		<script type="text/JavaScript" src="curvycorners.js"></script>
	</head>
	<body>
		<table width="1000" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr height="30">
				<td height="30" valign="middle" style="color:#FFFFFF"><? mosLoadModules ( 'header',-2); ?></td>
				<td width="196">&nbsp;</td>
			</tr>
			<tr>
				<td valign="top">
					<table width="100%" cellpadding="0" border="0">
						<tr>
							<td valign="top" height="130"><img src="templates/<?php echo $cur_template; ?>/images/logo.jpg" /></td>
							<td valign="top" align="center"><img src="images/cabec.jpg" /></td>
						</tr>
						<tr>
							<td height="32" colspan="2" style="background-repeat:repeat-x;" background="templates/<?php echo $cur_template; ?>/images/fundo_menu.gif" />
								<table width="100%" height="32" cellpadding="0" cellspacing="0">
									<tr>
										<td height="32">
											<? mosLoadModules ( 'top',-2); ?>
										</td>
										<td width="130" align="center"><b>ÁREA RESTRITA</b></td>
										<td width="230">
											<? mosLoadModules ( 'user1',-2); ?>
										</td>
									</tr>
									
								</table>
							</td>
						</tr>
						<tr>
							<td height="100" colspan="2" style="padding-top:10px; padding-bottom: 10px;" align="center">
								<? mosLoadModules ( 'banner',-2); ?>
							</td>
						</tr>
						<tr height="*">
							<td width="165" valign="top">
								<?php
								   if (eregi("MSIE",getenv("HTTP_USER_AGENT")) || eregi("Internet Explorer",getenv("HTTP_USER_AGENT"))) {
										?>
											<div style="padding:5px; width:165px;border:solid 2px #A4A4A4;background-image:url(templates/<?php echo $cur_template; ?>/images/fundo_esq.jpg);">	
										<?
								   }
								   else {
									?>
										<div style="padding:5px; width:174px;border:solid 2px #A4A4A4;background-image:url(templates/<?php echo $cur_template; ?>/images/fundo_esq.jpg);">
									<?
								   }
								?>
								
									<? mosLoadModules ( 'left',-2); ?>										
								</div>
							</td>
							<td width="607" height="30" valign="top" bgcolor="#FFFFFF" style="color:#454141; padding:5px;">
								<table width="100%" cellpadding="2" cellspacing="0">
									<tr>
										<td valign="top">
											<?php if(mosCountModules('user2') ||  mosCountModules('user3') ||  mosCountModules('user4')){ ?>
												<table width="100%">
													<tr>
														<?php if(mosCountModules('user2')){ ?>
															<td align="center">
															<? mosLoadModules ( 'user2', -2 ); ?>
															</td>
														<? } ?>
														<?php if(mosCountModules('user3')){ ?>
															<td align="center">
															<? mosLoadModules ( 'user3', -2 ); ?>
															</td>
														<? } ?>
														<?php if(mosCountModules('user4')){ ?>
															<td align="center">
															<? mosLoadModules ( 'user4', -2 ); ?>
															</td>
														<? } ?>
													</tr>
												</table>
											<? } ?>
											<?php mosMainBody(); ?>
											<? mosLoadModules ( 'user5', -2 ); ?>
										</td>
										<?php if(mosCountModules('inset')){ ?>
											<td width="150" align="center" valign="top">
											<? mosLoadModules ( 'inset', -2 ); ?>
											</td>
										<? } ?>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td width="197" valign="top" align="center">
					<? mosLoadModules ( 'right',-2); ?>
				</td>
			</tr>
			<tr>
				<td>
					<div style="text-align:center; line-height:44px; height:44px; border:solid 1px #cecece; margin-left:2px; margin-right:2px; margin-top:5px; margin-bottom:5px; background-image:url(templates/<?php echo $cur_template; ?>/images/fundo_rodape.jpg);background-repeat:repeat-x;">
						<? mosLoadModules ( 'footer',-2); ?>
					</div>
				</td>
			</tr>
			<tr>
				<td height="30" valign="middle" align="center">
					Copyright &copy; Todos os direitos reservados&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvido por:&nbsp;<img align="absmiddle" src="templates/<?php echo $cur_template; ?>/images/ugabuga.gif" />
				</td>
			</tr>
		</table>
	</body>
	<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6684551-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</html>
<script type="text/JavaScript">
	  settings = {
		  tl: { radius: 10 },
		  tr: { radius: 10 },
		  bl: { radius: 0 },
		  br: { radius: 0 },
		  antiAlias: true,
		  autoPad: false,
		  validTags: ["div", "span"]
	  }
	  /*
	  Usage:

	  newCornersObj = new curvyCorners(settingsObj, classNameStr);
	  newCornersObj = new curvyCorners(settingsObj, divObj1[, divObj2[, divObj3[, . . . [, divObjN]]]]);
	  */
	  var myBoxObject = new curvyCorners(settings, "myBox");
	  myBoxObject.applyCornersToAll();	
	   var myBoxObject = new curvyCorners(settings, "myBox2");
	  myBoxObject.applyCornersToAll();	
</script>