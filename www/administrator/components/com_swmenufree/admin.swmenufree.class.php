<?php
/**
* SWmenuFree v4.0
* http://swonline.biz
* Copyright 2006 Sean White
**/

class swmenufreeMenu extends mosDBTable 
{
var $id = null;
var $main_top= 0;
var $main_left= 0;
var $main_height= 0;
var $main_width= 0;
var $sub_width= 0;
var $main_back= "#FFFFFF";
var $main_over= "#33CCFF";
var $sub_back= "#FFCC99";
var $sub_over= "#FF6600";
var $sub_border= "0px solid #FFFFFF";
var $main_font_color= "#FF9933";
var $main_font_size= 12;
var $sub_font_color= "#000000";
var $sub_font_size= 12;
var $main_border= "0px solid #FFFFFF";
var $sub_border_over= "1px dashed #11B8F4";
var $main_font_color_over= "#FFFFFF";
var $main_border_over= "1px dashed #FFC819";
var $sub_align= "left";
var $main_align= "left";
var $sub_height= 0;
var $sub_font_color_over= "#FFFFFF";
var $position= "relative";
var $orientation= "vertical";
var $font_family= "Arial";
var $sub_font_family= "Arial";
var $font_weight= "normal";
var $font_weight_over= "bold";
var $level1_sub_top= 0;
var $level1_sub_left= 0;
var $level2_sub_top= 0;
var $level2_sub_left= 0;
var $main_back_image= null;
var $main_back_image_over = null;
var $sub_back_image= null;
var $sub_back_image_over= null;
var $specialA= 85;
var $specialB= 300;
var $sub_padding= "5px 5px 5px 5px";
var $main_padding= "5px 5px 5px 5px";


function swmenufreeMenu( &$db ) 
        {
                $this->mosDBTable( '#__swmenufree_config', 'id', $db );
        }


function gosumenu() 
	{

$this->set('main_top', 0);
$this->set('main_left', 0);
$this->set('main_height', 0);
$this->set('main_width', 0);
$this->set('sub_width', 0);
$this->set('main_back', "#FFFFFF");
$this->set('main_over', "#33CCFF");
$this->set('sub_back', "#FFCC99");
$this->set('sub_over', "#FF6600");
$this->set('sub_border', "0px solid #FFFFFF");
$this->set('main_font_color', "#FF9933");
$this->set('main_font_size', 12);
$this->set('sub_font_color', "#000000");
$this->set('sub_font_size', 12);
$this->set('main_border', "0px solid #FFFFFF");
$this->set('sub_border_over', "1px dashed #11B8F4");
$this->set('main_font_color_over', "#FFFFFF");
$this->set('main_border_over', "1px dashed #FFC819");
$this->set('sub_align', "left");
$this->set('main_align', "left");
$this->set('sub_height', 0);
$this->set('sub_font_color_over', "#FFFFFF");
$this->set('position', "relative");
$this->set('orientation', "vertical");
$this->set('font_family', "Arial");
$this->set('sub_font_family', "Arial");
$this->set('font_weight', "normal");
$this->set('font_weight_over', "bold");
$this->set('level1_sub_top', 0);
$this->set('level1_sub_left', 0);
$this->set('level2_sub_top', 0);
$this->set('level2_sub_left', 0);
$this->set('main_back_image', null);
$this->set('main_back_image_over ', null);
$this->set('sub_back_image', null);
$this->set('sub_back_image_over', null);
$this->set('specialA', 85);
$this->set('specialB', 300);
$this->set('sub_padding', "5px 5px 5px 5px");
$this->set('main_padding', "5px 5px 5px 5px");
		  

           return true;
        }


}


?>