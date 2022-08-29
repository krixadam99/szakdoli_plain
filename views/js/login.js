let back_button = document.querySelector("#back_button")
back_button.addEventListener("click", ()=>{
    window.location = "./"
})

let user_input = document.querySelector("#user_input")
user_input.addEventListener("click", ()=>{
    user_input.value= ""
})

let password_input = document.querySelector("#user_password")
password_input.addEventListener("click", ()=>{
    password_input.value= ""
})

let opened = true
let show_password_image = document.querySelector("#show_password_image")
if(show_password_image){
    show_password_image.addEventListener("click", (event)=>{
        event.preventDefault()
        if(opened){
            opened = !opened
            show_password_image.src= "./views/css/pics/closed_eye.png"
            if(password_input){
                password_input.type = "password"
            }
        }else{
            opened = !opened
            show_password_image.src= "./views/css/pics/opened_eye.png"
            if(password_input){
                password_input.type = "text"
            }
        }
    })
}