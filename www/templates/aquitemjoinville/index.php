<?php defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<?php
		if ($my->id) { initEditor(); } ?>
		<?php mosShowHead(); ?>
		<link href="templates/<?php echo $cur_template; ?>/css/template_css.css" rel="stylesheet" type="text/css" media="screen" />		
	</head>
	<body>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
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
							<td height="32" colspan="2" background="templates/<?php echo $cur_template; ?>/images/fundo_menu.gif" />
								<table width="100%" height="32" cellpadding="0" cellspacing="0">
									<tr>
										<td height="32">
											<? mosLoadModules ( 'top',-2); ?>
										</td>
										<td width="140" align="center"><b>ÁREA RESTRITA</b></td>
										<td width="240">
											<? mosLoadModules ( 'user1',-2); ?>
										</td>
									</tr>
									
								</table>
								
							</td>
						</tr>
						<tr>
							<td height="100" colspan="2" style="padding:10px;" align="center">
								<? mosLoadModules ( 'banner',-2); ?>
							</td>
						</tr>
						<tr height="*">
							<td width="174" valign="top">
								<div style="padding:5px; width:174px;border:solid 2px #A4A4A4;background-image:url(templates/<?php echo $cur_template; ?>/images/fundo_esq.jpg);">
									<? mosLoadModules ( 'left',-2); ?>
								</div>
							</td>
							<td width="607" height="30" valign="top" bgcolor="#FFFFFF" style="color:#454141; padding:5px;">
								<?php mosMainBody(); ?>
							</td>
						</tr>
						
						
						
					</table>
				</td>
				<td width="197">
					<? mosLoadModules ( 'right',-2); ?>
				</td>
			</tr>
		</table>
	</body>
</html>