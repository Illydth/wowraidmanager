function formatTimeDayDMYGerman( time )
{
  function zeropad( n ){ return n>9 ? n : '0'+n; }
  var t = time instanceof Date ? time : new Date( time );
  var Y = t.getFullYear();
  var M = t.getMonth(); // month-1
  var D = t.getDate();
  var d = t.getDay(); // 0..6 == sun..sat
  var day = ['So','Mo','Di','Mi','Do','Fr','Sa'][d];
  var h = t.getHours();
  var m = t.getMinutes();
  var s = t.getSeconds();
  return day + ',&nbsp;' + zeropad(D) + '.' + zeropad(M + 1) + '.' + Y;
}

function formatTimeDayMDYEnglish( time )
{
  function zeropad( n ){ return n>9 ? n : '0'+n; }
  var t = time instanceof Date ? time : new Date( time );
  var Y = t.getFullYear();
  var M = t.getMonth(); // month-1
  var D = t.getDate();
  var d = t.getDay(); // 0..6 == sun..sat
  var day = ['Su','Mo','Tu','We','Th','Fr','Sa'][d];
  var h = t.getHours();
  var m = t.getMinutes();
  var s = t.getSeconds();
  return day + ':&nbsp;' + zeropad(M + 1) + '/' + zeropad(D) + '/' + Y;
}