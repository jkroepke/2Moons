function contar(form,name) {
  n = document.forms[form][name].value.length;
  t = 5000;
  if (n > t) {
    document.forms[form][name].value = document.forms[form][name].value.substring(0, t);
  }
  else {
    document.forms[form]['result'].value = t-n;
  }
}
