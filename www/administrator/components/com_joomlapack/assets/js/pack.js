/*
	JoomlaPack
	The all-in-one backup component for Joomla!
	Copyright (c)2006-2008 JoomlaPack Developers
	This software is distributed according to the rules of the GNU General Public
	License, version 2 or any later version published by the FSF at your discretion.
	
	This file contains JavaScript code necessary for the backup operation.
*/


/*
 * (S)AJAX Error Trap and Reporting
 */

// Variables used by the detection code
var CUBEArray = null; // The latest CUBEArray returned
var LastDomain = "";

var DoDebug = false;

var isError = false;

// Assign the error handler
sajax_fail_handle = SAJAXTrap;

function WriteDebug( myString )
{
	if(DoDebug) {
		document.getElementById("Debug").innerHTML += myString;
	}
}

// Callback triggered when (S)AJAX fails to eval the proxy's response
function SAJAXTrap( myData ) {
	x_errorTrapReport( myData, SAJAXTrap_cb );
}

function SAJAXTrap_cb( myRet ) {
	document.getElementById("Timeout").style.display = "block";
	markError( LastDomain );
}

/**
 * Main functionality
 */
function do_Start( onlyDBMode ) {
	WriteDebug("Starting new backup...");
	document.getElementById("Welcome").style.display = "none";
	document.getElementById("Init").style.display = "block";
	x_tick( 1, onlyDBMode, do_Start_cb );
}

function do_Start_cb( myRet ) {
	WriteDebug("done<br/>");
	if(!isError)
	{
		CUBEArray = myRet;
		ParseCUBEArray();
		do_tick();
	}
}

function do_tick() {
	if(!isError) {
		WriteDebug("Tick()&nbsp;&nbsp;");
		x_tick( 0, 0, do_tick_cb );
	}
}

function do_tick_cb( myRet )
{
	WriteDebug("done tick()<br/>");
	CUBEArray = myRet;
	check = ParseCUBEArray();

	if ( typeof(CUBEArray) != "object" ) {
		AllDone();
	} else {
		if( CUBEArray['Domain'] == "finale" )
		{
			AllDone();
		} else {
			if(check != false)
			{
				do_tick();
			}
		}
	}
}

function getRowIdForDomain( myDomain )
{
	if( myDomain == "PackDB" ) return "domDB";
	if( myDomain == "Packing" ) return "domPacking";
	if( myDomain == "finale" ) return "domFinished";
	return "domDB";
}

function getPicIdForDomain( myDomain )
{
	if( myDomain == "PackDB" ) return "picDB";
	if( myDomain == "Packing" ) return "picPacking";
	if( myDomain == "finale" ) return "picFinished";
	return "picDB";
}

function markOK( myDomain )
{
	document.getElementById( getPicIdForDomain(myDomain) ).innerHTML = '<img src="components/com_joomlapack/assets/images/ok_small.png" />';
	document.getElementById( getRowIdForDomain(myDomain) ).className = "ok";
}

function markActive( myDomain )
{
	document.getElementById( getPicIdForDomain(myDomain) ).innerHTML = '<img src="components/com_joomlapack/assets/images/arrow_small.png" />';
	document.getElementById( getRowIdForDomain(myDomain) ).className = "active";
}

function markError( myDomain )
{
	document.getElementById( getPicIdForDomain(myDomain) ).innerHTML = '<img src="components/com_joomlapack/assets/images/error_small.png" />';
	document.getElementById( getRowIdForDomain(myDomain) ).className = "error";
}

function ParseCUBEArray() {
	WriteDebug("Parsing CUBE Array -- " + CUBEArray['Domain'] + " | " + CUBEArray['Step'] + "<br/>");
	if ( typeof( CUBEArray ) != "object" ) {
		AllDone();
	} else {
		var ThisDomain = CUBEArray['Domain'];

		if( ThisDomain != LastDomain ) {
			if( LastDomain != "" ) markOK( LastDomain );
			markActive( ThisDomain );
		} 	

		// Propagate error message
		if( CUBEArray['Error'] != '' )
		{
			isError = true;
			markError(ThisDomain);
			document.getElementById("Timeout").style.display = "block";
			document.getElementById("JoomlapackErrorMessage").style.display = "block";
			document.getElementById("JoomlapackErrorMessage").innerHTML = CUBEArray['Error']; 
			return;
		}
		
		// Propagate warnings
		if( CUBEArray['Warnings'] != '' )
		{
			document.getElementById("Warnings").style.display = "block";
			document.getElementById("WarningsContents").innerHTML += CUBEArray['Warnings']; 
		}
				
		if ( CUBEArray['Domain'] == "finale" ) {
			AllDone();
		}

		document.getElementById("JPStep").innerHTML = CUBEArray['Step'];
		document.getElementById("JPSubstep").innerHTML = CUBEArray['Substep'];
		
		LastDomain = CUBEArray['Domain'];
	}
}

function AllDone() {
	WriteDebug("All done<br/>");
	markOK( LastDomain );
	markOK( 'finale' );
	document.getElementById("Timeout").style.display = "none";
	document.getElementById("Status").style.display = "none";
	document.getElementById("AllDone").style.display = "block";
}