<?php
/**
* @version 1.0.4
* @package RSform! 1.0.4
* @copyright (C) 2007 www.rsjoomla.com
* @license Commercial License, http://www.rsjoomla.com/license/forme.html
*/
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$html .= '
<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_forme/calendar/yahoo.js"></script>
<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_forme/calendar/event.js" ></script>
<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_forme/calendar/dom.js" ></script>
<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_forme/calendar/calendar.js"></script>
<link type="text/css" rel="stylesheet" href="'.$mosConfig_live_site.'/components/com_forme/calendar/calendar.css">

<script language="javascript">
    YAHOO.namespace("example.calendar");
</script>




';
?>