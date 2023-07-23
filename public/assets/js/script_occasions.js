window.onload = function(){
    const selectCategorie = document.getElementById("categorieSelect");

    const redirectCategorie = () => {   
        location.href=document.getElementById("categorieSelect").value;
    }
    
    selectCategorie.addEventListener('change', redirectCategorie)

    const selectType = document.getElementById("typeSelect");

    const redirectType = () => {   
        location.href=document.getElementById("typeSelect").value;
    }
    
    selectType.addEventListener('change', redirectType)
}


