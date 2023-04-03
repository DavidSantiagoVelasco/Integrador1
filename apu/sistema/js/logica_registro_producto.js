const id = document.getElementById("id");
const stock = document.getElementById("stock");
const precio = document.getElementById("precio");

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
    if(stock.value < 0){
        warnings += 'Stock no válido\n';
        entrar = true;
    }
    if(precio.value < 1){
        warnings += 'Precio no válido\n';
        entrar = true;
    }
    if(entrar){
        alert(warnings);
    }else{
        form.submit();
    }
});