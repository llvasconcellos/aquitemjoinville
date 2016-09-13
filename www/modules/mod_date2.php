<?php
/**
* Copyright 2007 Ryan Rhode, TY2U.com
* Date2 Joomla! Module - displays current time and date
* v2.1.3
*
* Some parts of the code were taken or derived from sites on the internet.
* These sites include:
*	joomla.org
*	php.net
* 	yaldex.com
*	http://www.cs.tut.fi/~jkorpela/iso8601.html
*	http://www.quirksmode.org/js/date.html
*
*	Changelog
*
*	2.0
*	Added tons of features.
*	No longer uses Joomla function to get the date.
*
*	2.1
*	Fixed some bugs with time zones
*	Added ability to change Daylight Savings Time / Summer Time
*	Added ability to use ISO 8601 date format.
*	Added language support for days of the month.
*	Added alignment.
*
*	2.1.1
*	Fixed bug where it would show blank day on 10th of each month
*
*	2.1.2
*	Fixed bug where it would show am/pm opposite at the 11th hour
*
*	2.1.3 - 31st May 2008
*	31st day no shows correctly
*
*/
// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

// store module parameters
$moduleclass_sfx		= $params->get( 'moduleclass_sfx' );
$pretext 				= $params->get( 'pretext' );
$pretext 				= $params->get( 'pretext' );
$posttext 				= $params->get( 'posttext' );
$method			 		= $params->get( 'method' );
$showdate 				= $params->get( 'showdate' );
$predate 				= $params->get( 'predate' );
$postdate 				= $params->get( 'postdate' );
$showtime 				= $params->get( 'showtime' );
$pretime 				= $params->get( 'pretime' );
$posttime 				= $params->get( 'posttime' );
$order 					= $params->get( 'order' );
$seplines				= $params->get( 'seplines' );
$align					= $params->get( 'align' );
$dateorder				= $params->get( 'dateorder' );
$suffixes 				= $params->get( 'suffixes' );
$suntext 				= $params->get( 'suntext' );
$montext 				= $params->get( 'montext' );
$tuetext 				= $params->get( 'tuetext' );
$wedtext 				= $params->get( 'wedtext' );
$thutext 				= $params->get( 'thutext' );
$fritext 				= $params->get( 'fritext' );
$sattext 				= $params->get( 'sattext' );
$monthformat 			= $params->get( 'monthformat' );
$jantext 				= $params->get( 'jantext' );
$febtext 				= $params->get( 'febtext' );
$martext 				= $params->get( 'martext' );
$aprtext 				= $params->get( 'aprtext' );
$maytext 				= $params->get( 'maytext' );
$juntext 				= $params->get( 'juntext' );
$jultext 				= $params->get( 'jultext' );
$augtext 				= $params->get( 'augtext' );
$septext 				= $params->get( 'septext' );
$octtext 				= $params->get( 'octtext' );
$novtext 				= $params->get( 'novtext' );
$dectext 				= $params->get( 'dectext' );
$dst 					= $params->get( 'dst', 1 );
$ISO8601		 		= $params->get( 'ISO8601' );
$zone 					= $params->get( 'zone' );
$dston 					= $params->get( 'dston' );
$dstoff 				= $params->get( 'dstoff' );
$military 				= $params->get( 'military' );
$hours 					= $params->get( 'hours' );
$minutes 				= $params->get( 'minutes' );
$seconds 				= $params->get( 'seconds' );
$ampm 					= $params->get( 'ampm' );
$amtext 				= $params->get( 'amtext' );
$pmtext 				= $params->get( 'pmtext' );
$sepweek1 				= $params->get( 'sepweek1' );
$sepweek2 				= $params->get( 'sepweek2' );
$sepmonth1 				= $params->get( 'sepmonth1' );
$sepmonth2 				= $params->get( 'sepmonth2' );
$sepday1 				= $params->get( 'sepday1' );
$sepday2 				= $params->get( 'sepday2' );
$sepyear1 				= $params->get( 'sepyear1' );
$sepyear2 				= $params->get( 'sepyear2' );
$sephour1 				= $params->get( 'sephour1' );
$sephour2 				= $params->get( 'sephour2' );
$sepminute1 			= $params->get( 'sepminute1' );
$sepminute2 			= $params->get( 'sepminute2' );
$sepsecond1 			= $params->get( 'sepsecond1' );
$sepsecond2 			= $params->get( 'sepsecond2' );
$sepampm1 				= $params->get( 'sepampm1' );
$sepampm2 				= $params->get( 'sepampm2' );
$d1 					= $params->get( 'd1' );
$d2 					= $params->get( 'd2' );
$d3 					= $params->get( 'd3' );
$d4 					= $params->get( 'd4' );
$d5 					= $params->get( 'd5' );
$d6 					= $params->get( 'd6' );
$d7 					= $params->get( 'd7' );
$d8 					= $params->get( 'd8' );
$d9 					= $params->get( 'd9' );
$d10 					= $params->get( 'd10' );
$d11 					= $params->get( 'd11' );
$d12 					= $params->get( 'd12' );
$d13 					= $params->get( 'd13' );
$d14 					= $params->get( 'd14' );
$d15 					= $params->get( 'd15' );
$d16 					= $params->get( 'd16' );
$d17 					= $params->get( 'd17' );
$d18 					= $params->get( 'd18' );
$d19 					= $params->get( 'd19' );
$d20 					= $params->get( 'd20' );
$d21 					= $params->get( 'd21' );
$d22 					= $params->get( 'd22' );
$d23 					= $params->get( 'd23' );
$d24 					= $params->get( 'd24' );
$d25 					= $params->get( 'd25' );
$d26 					= $params->get( 'd26' );
$d27 					= $params->get( 'd27' );
$d28 					= $params->get( 'd28' );
$d29 					= $params->get( 'd29' );
$d30 					= $params->get( 'd30' );
$d31 					= $params->get( 'd31' );

//if the dateorder box is empty then don't show the date
if (empty($dateorder)) {
	$showdate = 1;
}

//set alignment
if($align=="1"){
	$alignment="left";
}
if($align=="2"){
	$alignment="center";
}
if($align=="3"){
	$alignment="right";
}
if($align != "0"){
	echo "<div style=\"margin:0px auto;width:auto;text-align:".$alignment.";\">";
}

echo $pretext."<span id=\"ty2udate\"></span>".$posttext;

if ($method==0) {
//javascript method

//variables to clean up the strings a bit
$stripthis 	= array("\"\"","++++","+++","++");
$addthis 	= array(""    ,"+"   ,"+"  ,"+" );

//compile javascript date based on desired date order
if ($showdate==0 && !empty($dateorder)) {

	//explode date order
	$exorder = explode(",", $dateorder);

	for ($i = 0; $i <= 3; $i++) {
		switch ($exorder[$i]) {
		case 'w':
			//make weekday with prefix and suffix
			if ($exorder[$i-1]!="") {
				$theDate .= "+";
			}
			$theDate .= "\"".$sepweek1."\"+arday[myday]+\"".$sepweek2."\"";
			if ($exorder[$i+1]!="") {
				$theDate .= "+";
			}
			break;
		case 'd':
			//make day with prefix and suffix
			if ($exorder[$i-1]!="") {
				$theDate .= "+";
			}
			if ($suffixes==0) {
				$theDate .= "\"".$sepday1."\"+ardate[myweekday]+\"".$sepday2."\"";
			}else {
				$theDate .= "\"".$sepday1."\"+myweekday+\"".$sepday2."\"";
			}
			if ($exorder[$i+1]!="") {
				$theDate .= "+";
			}
			break;
		case 'm':
			//make month with prefix and suffix
			if ($exorder[$i-1]!="") {
				$theDate .= "+";
			}
			if ($monthformat==0) {
				$theDate .= "\"".$sepmonth1."\"+armonth[mymonth]+\"".$sepmonth2."\"";
			}else {
				$theDate .= "\"".$sepmonth1."\"+mymonth+\"".$sepmonth2."\"";
			}
			if ($exorder[$i+1]!="") {
				$theDate .= "+";
			}
			break;
		case 'y':
			//make year with prefix and suffix
			if ($exorder[$i-1]!="") {
				$theDate .= "+";
			}
			$theDate .= "\"".$sepyear1."\"+year+\"".$sepyear2."\"";
			if ($exorder[$i+1]!="") {
				$theDate .= "+";
			}
			break;
		default:
			$theDate .= "\"\"";
		}
	}

	//clean up strings
	$theDate 	= str_replace($stripthis, $addthis, $theDate);
	$theDate 	= trim($theDate, "+");

	//add suffix
	$theDate	= $theDate."+\"".$postdate."\"";
}

//compile javascript time based on paramaters
if ($showtime==0) {
	if ($hours==0) {
		$theTime .= "\"".$sephour1."\"+myhours+\"".$sephour2."\"";
	}
	if ($minutes==0) {
		$theTime .= "\"".$sepminute1."\"+mytime+\"".$sepminute2."\"";
	}
	if ($seconds==0) {
		$theTime .= "\"".$sepsecond1."\"+myseconds+\"".$sepsecond2."\"";
	}
	if ($ampm==0 && $military==1) {
		$theTime .= "\"".$sepampm1."\"+mm+\"".$sepampm2."\"";
	}

	//clean up strings
	$theTime 	= str_replace($stripthis, $addthis, $theTime);
	$theTime 	= trim($theTime, "+");

	//add suffix
	$theTime	= $theTime."+\"".$posttime."\"";
}


?>
<script language="javascript" type="text/javascript">
<!--
function ISO8601Local(date) {
// handles years from 0000 to 9999 only
	var offset = date.getTimezoneOffset();
	var offsetSign = "-";
	if (offset <= 0) {
		offsetSign = "+";
		offset = -offset;
	}
	var offsetHours = Math.floor(offset / 60);
	var offsetMinutes = offset - offsetHours * 60;
	return ("000" + date.getFullYear()).slice(-4) +
	"-" + ("0" + (date.getMonth() + 1)).slice(-2) +
	"-" + ("0" + date.getDate()).slice(-2) +
	"T" + ("0" + date.getHours()).slice(-2) +
	":" + ("0" + date.getMinutes()).slice(-2) +
	":" + ("0" + date.getSeconds()).slice(-2) +
	"," + ("00" + date.getMilliseconds()).slice(-3) +
	offsetSign + ("0" + offsetHours).slice(-2) +
	":" + ("0" + offsetMinutes).slice(-2);
}

var ISO8601 = "<?php echo $ISO8601; ?>";

function clock() {
	var newdate = new Date();

	if(ISO8601 == "1") {

		var time = ISO8601Local(newdate);

	} else {

		var day="";
		var month="";
		var myweekday="";
		var year="";
		var mydate = new Date();
		var dston  =  new  Date('<?php echo $dston; ?>');
		var dstoff = new Date('<?php echo $dstoff; ?>');
		dston.setFullYear(newdate.getFullYear());
		dstoff.setFullYear(newdate.getFullYear());

		var dst = "<?php echo $dst; ?>";
		var myzone = newdate.getTimezoneOffset();

		var zone = <?php echo $zone; ?>;
		if (zone <= 0) {
			zone = -zone;
		}

		if (mydate > dston && mydate < dstoff && dst == "1") {
		//date is between dst dates and dst adjust is on.
			zonea = zone - 1;
			var houradjust = 0;
		} else {
			zonea = zone;
			var houradjust = -1;
		};

		newtime=newdate.getTime();

		var newzone =  (zonea*60*60*1000);
		newtimea = newtime+(myzone*60*1000)-newzone;

		mydate.setTime(newtimea);
		myday = mydate.getDay();
		mymonth = mydate.getMonth();
		myweekday= mydate.getDate();
		myyear= mydate.getYear();
		year = myyear;

		if (year < 2000) year = year + 1900;
		myhours = mydate.getHours();

		<?php
		if ($military=="1") {
		//not using military time
		?>

		var mm = "<?php echo $amtext; ?>";
		if (myhours > 11 + houradjust)
			mm = "<?php echo $pmtext; ?>";
		if (myhours > 12 + houradjust)
			myhours -= 12;
		if (myhours == 0) myhours = 12;

		<?php
		}else{
		//using military time
		?>

			if (myhours < 10){
				myhours = "0" + myhours;
			}
			else {
				myhours = "" + myhours;
			};

		<?php
		}
		?>

		myminutes = mydate.getMinutes();

		if (myminutes < 10){
			mytime = "0" + myminutes;
		}
		else {
			mytime = "" + myminutes;
		};

		myseconds = mydate.getSeconds();

		if (myseconds < 10) {
			myseconds = "0" + myseconds;
		} else {
			myseconds = "" + myseconds;
		};

		arday = new Array("<?php echo $suntext; ?>","<?php echo $montext; ?>","<?php echo $tuetext; ?>","<?php echo $wedtext; ?>","<?php echo $thutext; ?>","<?php echo $fritext; ?>","<?php echo $sattext; ?>")
		armonth = new Array("<?php echo $jantext; ?>","<?php echo $febtext; ?>","<?php echo $martext; ?>","<?php echo $aprtext; ?>","<?php echo $maytext; ?>","<?php echo $juntext; ?>","<?php echo $jultext; ?>","<?php echo $augtext; ?>","<?php echo $septext; ?>", "<?php echo $octtext; ?>","<?php echo $novtext; ?>","<?php echo $dectext; ?>")
		ardate = new Array("0th","<?php echo $d1; ?>","<?php echo $d2; ?>","<?php echo $d3; ?>","<?php echo $d4; ?>","<?php echo $d5; ?>","<?php echo $d6; ?>","<?php echo $d7; ?>","<?php echo $d8; ?>","<?php echo $d9; ?>","<?php echo $d10; ?>","<?php echo $d11; ?>","<?php echo $d12; ?>","<?php echo $d13; ?>","<?php echo $d14; ?>","<?php echo $d15; ?>","<?php echo $d16; ?>","<?php echo $d17; ?>","<?php echo $d18; ?>","<?php echo $d19; ?>","<?php echo $d20; ?>","<?php echo $d21; ?>","<?php echo $d22; ?>","<?php echo $d23; ?>","<?php echo $d24; ?>","<?php echo $d25; ?>","<?php echo $d26; ?>","<?php echo $d27; ?>","<?php echo $d28; ?>","<?php echo $d29; ?>","<?php echo $d30; ?>","<?php echo $d31; ?>");

		<?php
		//add prefixes and a line break if they are wanted

		if ($showdate==0 && !empty($dateorder)) {
			$datebreak="";
			if ($seplines == 0 && $order == 1) $datebreak="<br />";
			$predate="\"".$datebreak.$predate."\"+";
		}else{
			$predate="";
		}

		if ($showtime==0) {
			$timebreak="";
			if ($seplines == 0 && $order == 0) {
				$timebreak="<br />";
			}
			$pretime="\"".$timebreak.$pretime."\"+";
		}else{
			$pretime="";
		}

		//adjust some date values if required
		if ($suffixes==1) {
		?>
			myweekday = parseInt(myweekday);
		<?php
		}
		if ($monthformat==1) {
		?>
			mymonth = parseInt(mymonth)+1;
		<?php
		}

		if ($order == 0) {
		//date should be shown first

			if(!empty($theDate)) {
				$theDate .= "+";
			}

			?>

			var time = (<?php echo $predate; ?><?php echo $theDate; ?><?php echo $pretime; ?><?php echo $theTime; ?>);

			<?php

			} else {
			//time should be shown first

			if(!empty($theTime)) {
				$theTime .= "+";
			}

			?>

			var time = (<?php echo $pretime; ?><?php echo $theTime; ?><?php echo $predate; ?><?php echo $theDate; ?>);

		<?php
		}
		?>
}

document.getElementById('ty2udate').innerHTML  = time;

setTimeout("clock()", 1000)

}
window.onload = clock;
//-->
</script>

<?php
} else {
//php method

	if($ISO8601 == 1) {
	//ISO 8601 format

		if($zone < 0){
			$time = date("c", strtotime($zone." hours"));
		} else if ($zone > 0) {
			$time = date("c", strtotime("+".$zone." hours"));
		} else if ($zone == 0) {
			$time = date("c");
		}

	} else {
	//user defined format

		//adjust for DST
		if (date("I") && $dst == "1") {
				$zone++;
		}

		//time adjustment
		if($zone < 0){
			if ($military=="1") {
				$parts = date("w,j,m,Y,g,i,s", strtotime($zone." hours"));
			}else{
				$parts = date("w,j,m,Y,H,i,s", strtotime($zone." hours"));
			}
		} else if ($zone > 0) {
			if ($military=="1") {
				$parts = date("w,j,m,Y,g,i,s", strtotime("+".$zone." hours"));
			}else{
				$parts = date("w,j,m,Y,H,i,s", strtotime("+".$zone." hours"));
			}
		} else if ($zone == 0) {
			if ($military=="1") {
				$parts = date("w,j,m,Y,g,i,s");
			}else{
				$parts = date("w,j,m,Y,H,i,s");
			}
		}

		//explode parts after adjustments
		$parts = explode(",", $parts);

		$weekday 	= $parts[0];
		$day 		= $parts[1];
		$month 		= $parts[2];
		$year 		= $parts[3];
		$hour 		= $parts[4];
		$minute 	= $parts[5];
		$second 	= $parts[6];

		//text arrays
		$daytext = array($suntext,$montext,$tuetext,$wedtext,$thutext,$fritext,$sattext);
		$suffixtext = array("0th",$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12,$d13,$d14,$d15,$d16,$d17,$d18,$d19,$d20,$d21,$d22,$d23,$d24,$d25,$d26,$d27,$d28,$d29,$d30,$d31);
		$monthtext = array($jantext,$febtext,$martext,$aprtext,$maytext,$juntext,$jultext,$augtext,$septext,$octtext,$novtext,$dectext);

		//add prefixes and a line break if they are wanted
		if ($showdate==0 && !empty($dateorder)) {
			$datebreak="";
			if ($seplines == 0 && $order == 1) {
					$datebreak="<br />";
				}
				$predate=$datebreak.$predate;
		}else{
			$predate="";
		}
		if ($showtime==0) {
				$timebreak="";
				if ($seplines == 0 && $order == 0) {
					$timebreak="<br />";
				}
				$pretime=$timebreak.$pretime;
		}else{
			$pretime="";
		}

		//adjust month if using text
		if ($monthformat==0) {
			$month = intval($month)-1;
		}

		//compile php date based on desired date order
		if ($showdate==0 && !empty($dateorder)) {

			//explode date order
			$exorder = explode(",", $dateorder);

			for ($i = 0; $i <= 3; $i++) {
				switch ($exorder[$i]) {
				case 'w':
					//make weekday with prefix and suffix
					$theDate .= $sepweek1.$daytext[$weekday].$sepweek2;
					break;
				case 'd':
					//make day with prefix and suffix
					if ($suffixes==0) {
						$theDate .= $sepday1.$suffixtext[$day].$sepday2;
					}else {
						$theDate .= $sepday1.$day.$sepday2;
					}
					break;
				case 'm':
					//make month with prefix and suffix
					if ($monthformat==0) {
						$theDate .= $sepmonth1.$monthtext[$month].$sepmonth2;
					}else {
						$theDate .= $sepmonth1.$month.$sepmonth2;
					}
					break;
				case 'y':
					//make year with prefix and suffix
					$theDate .= $sepyear1.$year.$sepyear2;
					break;
				default:
					$theDate .= "";
				}
			}
		}

		//compile php time based on paramaters
		if ($showtime==0) {
			if ($hours==0) {
				$theTime .= $sephour1.$hour.$sephour2;
			}
			if ($minutes==0) {
				$theTime .= $sepminute1.$minute.$sepminute2;
			}
			if ($seconds==0) {
				$theTime .= $sepsecond1.$second.$sepsecond2;
			}
			if ($ampm==0 && $military==1) {
				if (date("a")=="am") {
					$theTime .= $sepampm1.$amtext.$sepampm2;
				}else{
					$theTime .= $sepampm1.$pmtext.$sepampm2;
				}
			}
		}

		if ($order == 0) {
		//date should be shown first

			if(!empty($theDate)) {
				$theDate .= "";
			}

			$time = ($predate.$theDate.$postdate.$pretime.$theTime.$posttime);

		} else {
		//time should be shown first

			if(!empty($theTime)) {
				$theTime .= "";
			}

			$time = ($pretime.$theTime.$posttime.$predate.$theDate.$postdate);
		}
	}

	echo $time;

}
if($align != "0"){
	echo "</div>";
}
?>