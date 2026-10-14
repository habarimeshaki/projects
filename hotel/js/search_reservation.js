function search_reservation(){
    const input = document.getElementById("search_input").value.toUpperCase();
    const parent = document.getElementById("content");

    let elements = parent.getElementsByTagName("td");

    for(let i = 0; i < elements.length; i++){
        if(elements[i].innerHTML.toUpperCase().indexOf(input) > -1){
            elements[i].parentElement.style.display = "block";
        }
        else{
            elements[i].parentElement.style.display = "none";
        }
    }
}