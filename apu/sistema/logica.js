const nombre = document.getElementById("nombre");
const apellido = document.getElementById("apellido");
const identificacion = document.getElementById("identificacion");
const usuario = document.getElementById("usuario");
const password = document.getElementById("contrase");
const password2 = document.getElementById("contrase2");
const parrafo = document.getElementById("warnings");

let alfabeto = [
  "a","b","c","d","e","f","g","h","i","j","k","l","m","n","ñ","o","p","q","r","s","t","u","v","x","y","z","w"," "
];
let numeros = [
    "1","2","3","4","5","6","7","8","9","0"
];

form.addEventListener("submit", (e) => {
  e.preventDefault();
  let emailValidator = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  let entrar = false;
  let warnings = "";
  parrafo.innerHTML = "";
  for (let i in nombre.value) {
    if (alfabeto.includes(nombre.value[i].toLowerCase()) == false) {
      warnings +=
        "Nombre no válido. Solo se permiten caracteres alfabéticos <br>"
      entrar = true;
      break;
    }
  }

  for (let i in apellido.value) {
    if (alfabeto.includes(apellido.value[i].toLowerCase()) == false) {
      warnings +=
        "Apellido no válido. Solo se permiten caracteres alfabéticos <br>"
      entrar = true;
      break;
    }
  }
  if (!emailValidator.test(usuario.value)) {
    warnings += "Email no válido <br>";
    entrar = true;
  }
  if(password.value != password2.value) {
    warnings += "Las contraseñas no coinciden <br>";
    entrar = true;
  }
  if (password.value.length < 8) {
    warnings += "Contraseña debe tener mínimo 8 caracteres <br>"
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
      warnings += "La cotraseña debe tener mínimo un número<br>"
      entrar = true
  }
  if(contEspeciales == 0){
      warnings += "La cotraseña debe tener mínimo un caracter especial<br>"
      entrar = true
  }
  if (entrar) {
    parrafo.innerHTML = warnings;
  }else{
    form.submit();
  }  
});
