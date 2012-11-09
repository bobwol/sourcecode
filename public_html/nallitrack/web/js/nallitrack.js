
$.fn.dataTableExt.oSort['title-string-asc']  = function(a,b) {
    var x = a.match(/title="(.*?)"/)[1].toLowerCase();
    var y = b.match(/title="(.*?)"/)[1].toLowerCase();
    return ((x < y) ? -1 : ((x > y) ?  1 : 0));
};
$.fn.dataTableExt.oSort['title-string-desc'] = function(a,b) {
    var x = a.match(/title="(.*?)"/)[1].toLowerCase();
    var y = b.match(/title="(.*?)"/)[1].toLowerCase();
    return ((x < y) ?  1 : ((x > y) ? -1 : 0));
};	

// misc jQuery stuff to make the UI work better
$(function(){
	$('.tabs').tabs();	
	$('.accordion').accordion({ header: "h3" });	
	$('.datePicker').datepicker({ inline: true });

	// close prompts
	$('a.close').live('click', function() {
		$(this).parent().parent().get(0).style.display  = 'none';
	});

	// Used to select the text of the current field when it receives focus
	$('input').live('focus', function() {
		$(this).get(0).select();
	});


   		// Use the each() method to gain access to each elements attributes
			   $('a[rel]').each(function()
			   {
			      $(this).qtip(
			      {
			         content: {
			            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
			            text: '<img class="throbber" src="/projects/qtip/images/throbber.gif" alt="Loading..." />',
			            url: $(this).attr('rel'), // Use the rel attribute of each element for the url to load
			            title: {
			               text: 'Nallitrack - ' + $(this).text(), // Give the tooltip a title using each elements text
			               button: 'Close' // Show a close link in the title
			            }
			         },
			         position: {
			            corner: {
			               target: 'bottomMiddle', // Position the tooltip above the link
			               tooltip: 'topMiddle'
			            },
			            adjust: {
			               screen: true // Keep the tooltip on-screen at all times
			            }
			         },
			         show: {
			            when: 'click', 
			            solo: true // Only show one tooltip at a time
			         },
			         hide: 'unfocus',
			         style: {
			            tip: true, // Apply a speech bubble tip to the tooltip at the designated tooltip corner
			            border: {
			               width: 0,
			               radius: 4
			            },
			            name: 'light', // Use the default light style
			            width: 480 // Set the tooltip width
			         }
			      })
			   });


});

function setSelect(selectObj, val, delimiter ) {
	var hasSelected = false;
	var optVal=new Array();
	var opt = selectObj.options;

	for (var i=0; i < opt.length; i++) {
		optVal[0] = opt[i].value;
		if (delimiter === undefined) {
			optVal[0] = opt[i].value;
		}else{
			optVal = opt[i].value.split(delimiter);
		}
		if(optVal[0] == val) {
			hasSelected = true;
			opt[i].selected = 'selected';
		}
	}
	return hasSelected;
}

function getSelect(selectObj) {
	var x = selectObj.selectedIndex;
	var y = selectObj.options;
	return y[x].value;
}

function selectAll(selectObj, setting) {
    // is the select box a multiple select box?
    if (selectObj.type == "select-multiple") {
        for (var i = 0; i < selectObj.options.length; i++) {
            selectObj.options[i].selected = setting;
        }
    }
}
// set the radio button with the given value as being checked
// do nothing if there are no radio buttons
// if the given value does not exist, all the radio buttons
// are reset to unchecked
function setCheckedValue(radioObj, newValue) {
	if(!radioObj) return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
}

// return the value of the radio button that is checked
// OR return an empty string if none are checked, 
// OR return an empty string if there are no radio buttons
function getCheckedValue(radioObj) {
	if(!radioObj) return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function validNumber(iNum, lowLimit, highLimit) {
	// return codes
	var tooHi = 3;
	var tooLo = 2;
	var nonNumber = 1;
	var	retVal = 0;
	if(isFinite(iNum)&& !(!iNum || /^\s*$/.test(iNum))) {
		if(iNum < lowLimit ){ retVal = tooLo; }
		if(iNum > highLimit ){ retVal = tooHi; }
	} else {
		retVal = nonNumber;
	}
	return retVal;
}

function isLeapYear(iYear) {
	return (iYear%4 == 0) && ((iYear%100 != 0) || (iYear%400 == 0))
}
				
function isValidDate(sDate) {
	var arrDate = sDate.split('/',3);
	var arrLastDayOfMonth = [00,31,28,31,30,31,30,31,31,30,31,30,31];
	var validFlg = false;
	//only supports the format "mm/dd/yyyy"
	if(arrDate.length == 3) {
		var intDay = parseInt(arrDate[1]);
		var intMonth = parseInt(arrDate[0]);
		var intYear = parseInt(arrDate[2]);
		if(intDay>=1 && (intMonth>=1 && intMonth<=12)) {
			if(isLeapYear(intYear)) arrLastDayOfMonth[2] = 29;
			if(intDay<=arrLastDayOfMonth[intMonth]) {
				validFlg = true;
			}
		}
	}
	return validFlg;
}

