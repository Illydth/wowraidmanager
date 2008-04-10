<!-- flooble Expandable Content header start -->
// Expandable content script from flooble.com.
// For more information please visit:
//   http://www.flooble.com/scripts/expand.php
// Copyright 2002 Animus Pactum Consulting Inc.
//----------------------------------------------
var ie4 = false; if(document.all) { ie4 = true; }
function getObject(id) { if (ie4) { return document.all[id]; } else { return document.getElementById(id); } }
function toggle(link, divId) { var lText = link.innerHTML; var d = getObject(divId);
 if (lText == '+') { link.innerHTML = '-'; d.style.display = 'block'; }
 else { link.innerHTML = '+'; d.style.display = 'none'; } }
<!-- flooble Expandable Content header end   -->
                