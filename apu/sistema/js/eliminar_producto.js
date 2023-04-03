const id = document.getElementById("id");

form.addEventListener("submit", (e) => {
    e.preventDefault();
    let entrar = false;
    let warnings = "";
    for(let i in id.value){
        if(id.value[i] == ' '){
            warnings += 'No se permiten espacios en el ID del producto\n';
            entrar = true;
            break;
        }
    }
    if(entrar){
        alert(warnings);
    }else{
        form.submit();
    }
});