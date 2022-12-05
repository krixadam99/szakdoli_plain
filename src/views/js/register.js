//Functions
/**
 * This method is responsible for changing the password show/hide eyes according to its previous state.
 * 
 * @param {Element} element The eye element for hiding and showing a password.
 */
function change_eyes(element){
    element.addEventListener("click", (event)=>{
        event.preventDefault()
        let password_input =  element.previousElementSibling
        let opened = element.src.includes("opened_eye")
        if(opened){
            element.src= "./views/css/pics/closed_eye.png"
            if(password_input){
                password_input.type = "password"
            }
        }else{
            element.src= "./views/css/pics/opened_eye.png"
            if(password_input){
                password_input.type = "text"
            }
        }
    })
}

// Variables
let back_button = document.querySelector("#back_button")
let user_status = document.querySelector("#user_status")
let subject_name = document.querySelector("#subject_id")
let inputs = document.querySelectorAll("input")
let show_password_image_first = document.querySelector("#show_password_image_first")
let show_password_image_second = document.querySelector("#show_password_image_second")

//Event-handlers
if(back_button){
    back_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=login"
    })
}

// Showing the groups based on the chosen user status
if(user_status){
    user_status.addEventListener("change", ()=>{
        let student_groups = document.querySelector("#student_groups")
        let teacher_groups = document.querySelector("#teacher_groups")
        if(user_status.selectedIndex == 0){
            if(student_groups){
                teacher_groups.hidden = true
            }
            if(teacher_groups){
                student_groups.hidden = false
            }
        }else if(user_status.selectedIndex == 1){
            if(student_groups){
                teacher_groups.hidden = false
            }
            if(teacher_groups){
                student_groups.hidden = true
            }
        }
    })
}

// Showing only those groups that belong to the chosen subject
if(subject_name){
    subject_name.addEventListener("change", ()=>{
        if(subject_name.selectedIndex == 2){
            let subject_group_div = document.querySelector("#subject_group_div")
            if(subject_group_div){
                subject_group_div.hidden = true
            }
        }else if(subject_name.selectedIndex == 1 || subject_name.selectedIndex == 0){
            let subject_group_div = document.querySelector("#subject_group_div")
            if(subject_group_div){
                subject_group_div.hidden = false
            }

            let subject_1 = document.querySelector("#subject_1")
            let subject_2 = document.querySelector("#subject_2")
            if(subject_name.selectedIndex == 1){
                if(subject_1){
                    subject_1.hidden = true
                }
                if(subject_2){
                    subject_2.hidden = false
                }
            }else{
                if(subject_1){
                    subject_1.hidden = false
                }
                if(subject_2){
                    subject_2.hidden = true
                }
            }
        }
    })
}


if(inputs){
    for(let input of inputs){
        if(input.type=="text"){
            input.addEventListener("click", ()=>{
                input.value = ""
                input.style["color"] = "black"
            })
        }
    }
}

if(show_password_image_first){
    change_eyes(show_password_image_first)
}
if(show_password_image_second){
    change_eyes(show_password_image_second)
}
