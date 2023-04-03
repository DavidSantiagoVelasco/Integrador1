const usuario = document.getElementById("usuario");
const password = document.getElementById("contra");
const password2 = document.getElementById("contra2");

let alfabeto = [
  "a","b","c","d","e","f","g","h","i","j","k","l","m","n","ñ","o","p","q","r","s","t","u","v","x","y","z","w"," "
];
let numeros = [
    "1","2","3","4","5","6","7","8","9","0"
];

form.addEventListener("submit", (e) => {
  var datos = new FormData(form);
  e.preventDefault();
  let emailValidator = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  let entrar = false;
  let warnings = "";
  if (!emailValidator.test(usuario.value)) {
    warnings += "Email no válido\n";
    entrar = true;
  }
  if(password.value != password2.value) {
    warnings += "Las contraseñas no coinciden\n";
    entrar = true;
  }
  if (password.value.length < 8) {
    warnings += "Contraseña debe tener mínimo 8 caracteres\n"
    entrar = true;
  }
  let contNumber = 0
  let contEspeciales = 0
  for (let i in password.value) {
      if(numeros.includes(password.value[i])){
          contNumber += 1
      }else if(!alfabeto.includes(password.value[i].toLowerCase())){
          contEspeciales += 1
      }
  }
  if(contNumber == 0){
      warnings += "La cotraseña debe tener mínimo un número\n"
      entrar = true
  }
  if(contEspeciales == 0){
      warnings += "La cotraseña debe tener mínimo un caracter especial\n"
      entrar = true
  }
  if (entrar) {
      alert(warnings);
  }else{
    form.submit();
  }  
});
