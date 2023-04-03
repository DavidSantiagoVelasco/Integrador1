const viejo = document.getElementById("usuario_v");
const nuevo = document.getElementById("usuario_n");

form.addEventListener("submit", (e) => {
  var datos = new FormData(form);
  e.preventDefault();
  let emailValidator = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  let entrar = false;
  let warnings = "";

  if (!emailValidator.test(viejo.value)) {
    entrar = true;
    warnings += 'Usuario actual inválido\n';
  }
  if(!emailValidator.test(nuevo.value)){
    entrar = true;
    warnings += 'Usuario nuevo inválido\n';
  }
  if(nuevo.value == viejo.value){
      entrar = true;
      warnings += 'Los usuarios no pueden ser iguales\n'
  }
  if (entrar) {
    alert(warnings);
  }else{
    form.submit();
  }  
});
