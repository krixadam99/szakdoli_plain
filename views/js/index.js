let login_button = document.querySelector("#sign_in_button")
if(login_button){
    console.log("alma")
    login_button.addEventListener("click", ()=>{
        window.location.href = "./index.php?site=login"
    })
}