function MM_jumpMenu(targ,selObj,restore)
{
  eval(targ+".location=\""+selObj.options[selObj.selectedIndex].value+"\"");
  if (restore) selObj.selectedIndex=0;
}
