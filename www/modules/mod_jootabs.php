<?php
// JooTabs for Joomla! CMS //
// Created by: Ricardo Sousa and Andy Sikumbang //
// Released by: TemplatePlazza.com  - Best Joomla! Templates //
// Date Release: October 2007 //
// Based on: EASY TABS 1.2 Produced and Copyright by Koller Juergen www.kollermedia.at | www.austria-media.at //
// What's this? A way to easy add tabs to Joomla CMS //
// Version: 1.0 //
// Compability: Joomla 1.X //
// Copyright: 2007 - TemplatePlazza and AiediLabs (Ricardo Sousa) //
defined( '_VALID_MOS' ) or die( 'Restricted access' );

 $numbertab = $params->get( 'numbertab', 2) ;     // Select how many tabs you want to use -- max: 10
 $firsttabopen = $params->get( '1tabopen', 1);    // select the 1st tab to open... If you want to open the 1st tab just need to put 1
 $autochange = $params->get( 'autochange', 0) ; // select if you want to autochange the
 $changedelay =  $params->get( 'changedelay', 80) ; // select how many seconds should tabs wait before change automatic
 $changestop =  $params->get( 'changestop', 0) ; // Select if the autochange of tabs should stop if user mouseover any tab
 $nameidlinks =  $params->get( 'nameidlinks', tablink) ; // Individual name for the set of links. If you copy the module YOU SHOULD CHANGE THIS!
 $nameidarea =  $params->get( 'nameidarea', tabcontent) ; // Individual name for the space of tabs. If you copy the module YOU SHOULD CHANGE THIS!
 $changetype =  $params->get( 'changetype', mouseover) ; // Select if you want to select a tab by MouseOver or Click!
 $tab_template =  $params->get( 'tab_template', 1) ; // template style
  $width_tab =  $params->get( 'width_tab', 300) ; // tab width
 $tab1 =  $params->get( 'tab1', user1); // Module to use in the 1st Tab
 $tab1name =  $params->get( 'tab1name', Tab1); // Title of the 1st Tab
 $tab2 =  $params->get( 'tab2', user2); // Module to use in the 2nd Tab
 $tab2name =  $params->get( 'tab2name', Tab2); // Title of the 2nd Tab
 $tab3 =  $params->get( 'tab3', user1); // Module to use in the 3rd Tab
 $tab3name =  $params->get( 'tab3name', Tab3); // Title of the 3rd Tab
 $tab4 =  $params->get( 'tab4', user2); // Module to use in the 4th Tab
 $tab4name =  $params->get( 'tab4name', Tab4); // Title of 4th  Tab
 $tab5 =  $params->get( 'tab5', user1); // Module to use in the 5th Tab
 $tab5name =  $params->get( 'tab5name', Tab5); // Title of the 5th Tab
 $tab6 =  $params->get( 'tab6', user2); // Module to use in the 6th Tab
 $tab6name =  $params->get( 'tab6name', Tab6); // Title of 6th Tab
 $tab7 =  $params->get( 'tab7', user1); // Module to use in the 7th Tab
 $tab7name =  $params->get( 'tab7name', Tab7); // Title of the 7th Tab
 $tab8 =  $params->get( 'tab8', user2); // Module to use in the 8th Tab
 $tab8name =  $params->get( 'tab8name', Tab8); // Title of 8th Tab
 $tab9 =  $params->get( 'tab9', user1); // Module to use in the 9th Tab
 $tab9name =  $params->get( 'tab9name', Tab8); // Title of the 9th Tab
 $tab10 =  $params->get( 'tab10', user2); // Module to use in the 10th Tab
 $tab10name =  $params->get( 'tab10name', Tab10); // Title of 10th Tab
  $titleshow =  $params->get( 'titleshow', 1); // Show or not the titles of the modules inside the tabs
  ?>

  
<!-- Move this line into head section of template to make your web valid xhtml --> 
<link href="modules/mod_jootabs/style<?php echo $tab_template; ?>.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
/*
EASY TABS 1.2 Produced and Copyright by Koller Juergen
www.kollermedia.at | www.austria-media.at
*/

var tablink_idname = new Array("<?php echo $nameidlinks; ?>")
var tabcontent_idname = new Array("<?php echo $nameidarea; ?>")
var tabcount = new Array("<?php echo $numbertab; ?>")
var loadtabs = new Array("<?php echo $firsttabopen; ?>")
var autochangemenu = <?php echo $autochange; ?>;
var changespeed = <?php echo $changedelay; ?>;
var stoponhover = <?php echo $changestop; ?>;

function easytabs(menunr, active) {if (menunr == autochangemenu){currenttab=active;}if ((menunr == autochangemenu)&&(stoponhover==1)) {stop_autochange()} else if ((menunr == autochangemenu)&&(stoponhover==0))  {counter=0;}menunr = menunr-1;for (i=1; i <= tabcount[menunr]; i++){document.getElementById(tablink_idname[menunr]+i).className='tab'+i;document.getElementById(tabcontent_idname[menunr]+i).style.display = 'none';}document.getElementById(tablink_idname[menunr]+active).className='tab'+active+' tabactive';document.getElementById(tabcontent_idname[menunr]+active).style.display = 'block';}var timer; counter=0; var totaltabs=tabcount[autochangemenu-1];var currenttab=loadtabs[autochangemenu-1];function start_autochange(){counter=counter+1;timer=setTimeout("start_autochange()",1000);if (counter == changespeed+1) {currenttab++;if (currenttab>totaltabs) {currenttab=1}easytabs(autochangemenu,currenttab);restart_autochange();}}function restart_autochange(){clearTimeout(timer);counter=0;start_autochange();}function stop_autochange(){clearTimeout(timer);counter=0;}

window.onload=function(){
var menucount=loadtabs.length; var a = 0; var b = 1; do {easytabs(b, loadtabs[a]);  a++; b++;}while (b<=menucount);
if (autochangemenu!=0){start_autochange();}
}
</script>


<?php
// preparing the new variable to be able to stop or the click or the mouseover depending of user selection //
       if($changetype == mouseover) {
                $notselected = onclick;
                       } else {
                      $notselected = mouseover;
                     }

// preparing the option to show or not the titles of the modules inside the tabs
           if($titleshow == 1) {
                $showtitle = -2;
                       } else {
                      $showtitle = -1;
                     }
                     ?>


<!-- jooTabs - Joomla tabs by http://templateplazza.com -->
<!--Start of the menu -->
<div class="jootab" style="width:<?php echo $width_tab; ?>px;">
<ul>
<?php if ($numbertab >= 1)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '1');" onFocus="easytabs('1', '1');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>1"><?php echo $tab1name; ?></li>
<?php } ?>

<?php if ($numbertab >= 2)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '2');" onFocus="easytabs('1', '2');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>2"><?php echo $tab2name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 3)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '3');" onFocus="easytabs('1', '3');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>3"><?php echo $tab3name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 4)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '4');" onFocus="easytabs('1', '4');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>4"><?php echo $tab4name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 5)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '5');" onFocus="easytabs('1', '5');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>5"><?php echo $tab5name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 6)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '6');" onFocus="easytabs('1', '6');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>6"><?php echo $tab6name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 7)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '7');" onFocus="easytabs('1', '7');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>7"><?php echo $tab7name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 8)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '8');" onFocus="easytabs('1', '8');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>8"><?php echo $tab8name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 9)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '9');" onFocus="easytabs('1', '9');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>9"><?php echo $tab9name; ?> </li>
<?php } ?>

<?php if ($numbertab >= 10)  { ?>
<li on<?php echo $changetype; ?>="easytabs('1', '10');" onFocus="easytabs('1', '10');" on<?php echo $notselected; ?>="return false;"  title="" id="<?php echo $nameidlinks; ?>10"><?php echo $tab10name; ?></li>
<?php } ?>

</ul>
</div>
<!--End of the menu -->

<?php if ($numbertab >= 1)  { ?>
<!--Start Tabcontent 1 -->
<div id="<?php echo $nameidarea; ?>1"  style="width:<?php echo $width_tab; ?>px;">	<?php mosLoadModules ( $tab1 , $showtitle ); ?></div>
<!--End Tabcontent 1-->
<?php } ?>

<?php if ($numbertab >= 2)  { ?>
<!--Start Tabcontent 2-->
<div id="<?php echo $nameidarea; ?>2"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab2 , $showtitle ); ?></div>
<!--End Tabcontent 2 -->
<?php } ?>

<?php if ($numbertab >= 3)  { ?>
<!--Start Tabcontent 3-->
<div id="<?php echo $nameidarea; ?>3"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab3 , $showtitle ); ?></div>
<!--End Tabcontent 3 -->
<?php } ?>

<?php if ($numbertab >= 4)   { ?>
<!--Start Tabcontent 4-->
<div id="<?php echo $nameidarea; ?>4" style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab4 , $showtitle ); ?></div>
<!--End Tabcontent 4 -->
<?php } ?>

<?php if ($numbertab >= 5)  { ?>
<!--Start Tabcontent 5-->
<div id="<?php echo $nameidarea; ?>5"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab5 , $showtitle ); ?></div>
<!--End Tabcontent 5 -->
<?php } ?>

<?php if ($numbertab >= 6)  { ?>
 <!--Start Tabcontent 6-->
<div id="<?php echo $nameidarea; ?>6"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab6 , $showtitle ); ?></div>
<!--End Tabcontent 6 -->
<?php } ?>

<?php if ($numbertab >= 7)  { ?>
 <!--Start Tabcontent 7-->
<div id="<?php echo $nameidarea; ?>7"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab7 , $showtitle ); ?></div>
<!--End Tabcontent 7 -->
<?php } ?>

<?php if ($numbertab >= 8)  { ?>
  <!--Start Tabcontent 8-->
<div id="<?php echo $nameidarea; ?>8"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab8 , $showtitle ); ?></div>
<!--End Tabcontent 8-->
<?php } ?>

<?php if ($numbertab >= 9)  { ?>
  <!--Start Tabcontent 9-->
<div id="<?php echo $nameidarea; ?>9"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab9 , $showtitle ); ?></div>
<!--End Tabcontent 9-->
<?php } ?>

<?php if ($numbertab >= 10)  { ?>
  <!--Start Tabcontent 10-->
<div id="<?php echo $nameidarea; ?>10"  style="width:<?php echo $width_tab; ?>px;"><?php mosLoadModules ( $tab10 , $showtitle ); ?></div>
<!--End Tabcontent 10-->
<?php } ?>