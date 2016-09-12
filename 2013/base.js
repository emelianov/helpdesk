//base.js v4.0.2

function hlRow(theRow, thePointerColor){
 if (thePointerColor== '' || typeof(theRow.style)=='undefined') return false;
 if (typeof(document.getElementsByTagName)!='undefined')
  var theCells = theRow.getElementsByTagName('td');
 else
  if (typeof(theRow.cells)!='undefined')
   var theCells = theRow.cells;
  else
   return false;
 var rowCellsCnt=theCells.length;
 for (var c=0;c<rowCellsCnt;c++){
  theCells[c].style.backgroundColorOld = theCells[c].style.backgroundColor;
  theCells[c].style.backgroundColor = thePointerColor;
 }
 return true;
}

function noRow(theRow, thePointerColor){
 if (thePointerColor== '' || typeof(theRow.style)=='undefined') return false;
 if (typeof(document.getElementsByTagName)!='undefined')
  var theCells = theRow.getElementsByTagName('td');
 else
  if (typeof(theRow.cells)!='undefined')
   var theCells = theRow.cells;
  else
   return false;
 var rowCellsCnt=theCells.length;
 for (var c=0;c<rowCellsCnt;c++){
  theCells[c].style.backgroundColor = theCells[c].style.backgroundColorOld;
 }
 return true;
}


function getCookie(Name) {          
 var dc = document.cookie;
 var find = Name + "=";
 if (dc.length != 0){  					             
  var start = dc.indexOf(find); 							            
 } 								          
 if (start != -1){  										               
  start += find.length; 													         
  var stop = dc.indexOf(";", start); 															           
  if (stop == -1){ 																		                 
   stop = dc.length; 																					              
  } 																						               
  return unescape(dc.substring(start, stop)); 																										       
 } else {
  return false;
 } 																											  
}


function setCSS(name) {
 var expire = new Date();
 expire.setTime(expire.getTime() + 365*24*3600);
 document.cookie = 'TMN_SKIN=' + name + ';expires=' + expire.toGMTString() + '; path=/;';
 document.location = document.location;
}

