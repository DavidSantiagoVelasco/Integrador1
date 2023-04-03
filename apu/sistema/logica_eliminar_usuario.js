const usuario = document.getElementById("usuario");
const password = document.getElementById("contrase");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  var datos = new FormData(form);
  let emailValidator = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  let entrar = false;

  if (!emailValidator.test(usuario.value)) {
    entrar = true;
  }
  if (entrar) {
    alert('Email no válido');
  }else{
    form.submit();
  }  
});
