let back_button = document.querySelector("#back_button")
let user_input = document.querySelector("#user_input")
let password_input = document.querySelector("#user_password")
let show_password_image = document.querySelector("#show_password_image")

let clicked_inputs = []


// Event listeners
back_button.addEventListener("click", ()=>{
    window.location = "./"
})

if(user_input){
    user_input.addEventListener("click", ()=>{
        if(!clicked_inputs.includes(user_input)){
            clicked_inputs.push(user_input)
            user_input.value= ""
        }
    })
}

if(password_input){
    password_input.addEventListener("click", ()=>{
        if(!clicked_inputs.includes(password_input)){
            clicked_inputs.push(password_input)
            password_input.value= ""
        }
    })    
}

// Is the show password eye opened?
let opened = true
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