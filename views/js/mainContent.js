// Functions:
function ChangeAttributeInURL(parameter, new_value){
    let actual_path = window.location.href
    if(actual_path.includes(parameter)){
        let new_path = actual_path.split("?")[0] + "?"
        let parts = actual_path.split("?")[1].split("&")
        let counter = 0
        for(let part of parts){
            if(part.includes(parameter)){
                new_path += parameter + "=" + new_value
                if(counter < parts.length -1){
                    new_path += "&"
                }
            }else{
                new_path += part
                if(counter < parts.length -1){
                    new_path += "&"
                }
            }
            counter += 1
        }
        window.location = new_path
    }else{
        window.location = actual_path + "&" + parameter + "=" + new_value
    }
}

// Variables
let logout_button = document.querySelector("#sign_out_button")
let notifications_button =  document.getElementById("notifications_button")
let group_addition_button =  document.getElementById("group_addition_button")
let nav_buttons = document.querySelectorAll("nav")
let nav_button_number = nav_buttons.length
let submenu_navigation_links = document.querySelectorAll("a.submenu_row")
let navigation_links = document.querySelectorAll("a.menu_cell")
let student_rows = document.querySelectorAll("tr")
let group_selector = document.querySelector("#group_selector")
let solution_inputs = document.querySelectorAll(".solution_input")
let body = document.querySelector("body")
let small_cards = document.querySelectorAll(".small_card")

// Event-handlers
if(logout_button){
    logout_button.addEventListener("click", ()=>{
        window.location = "./index.php"
    })
}

if(notifications_button){
    notifications_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=notifications"
    })
}

if(group_addition_button){
    group_addition_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=groupAddition"
    })
}


if(nav_buttons){
    let width = 100/nav_button_number
    if(nav_button_number === 1){
        let nav_button = nav_buttons[0]
        
        nav_button.style["width"] = `30%`
        nav_button.style["margin"] = `auto 0% auto 70%`

        nav_button.addEventListener("mouseenter",()=>{
            let submenu = nav_button.querySelector(".submenu")
            if(submenu){
                submenu.style["visibility"] = "visible"
                submenu.style["width"] = `30%`;
            }
        })

        nav_button.addEventListener("mouseleave",()=>{
            let submenu = nav_button.querySelector(".submenu")
            if(submenu){
                submenu.style["visibility"] = "hidden"
            }
        })

        nav_button.addEventListener("click",()=>{
            nav_button.querySelector("a").click()
        })
    }else{
        for(let nav_button of nav_buttons){
            if(!Array.from(nav_button.classList).includes("empty_nav")){
                nav_button.style["width"] = `${width}%`
    
                nav_button.addEventListener("mouseenter",()=>{
                    let submenu = nav_button.querySelector(".submenu")
                    if(submenu){
                        submenu.style["visibility"] = "visible"
                        submenu.style["width"] = `${width}%`;
                    }
                })
    
                nav_button.addEventListener("mouseleave",()=>{
                    let submenu = nav_button.querySelector(".submenu")
                    if(submenu){
                        submenu.style["visibility"] = "hidden"
                    }
                })
    
                nav_button.addEventListener("click",()=>{
                    nav_button.querySelector("a").click()
                })
            }
        }
    }
}

if(solution_inputs){
    for(let solution_input of solution_inputs){
        solution_input.addEventListener("click", ()=>{
            if(!solution_input.readOnly){
                solution_input.value= ""
                solution_input.style["color"] = "black"
                solution_input.style["font-weight"] = "bold"
            }
        })
    }
}

if(body){
    for(let small_card of small_cards){
        small_card.addEventListener("mouseenter", ()=>{
            body.style["background-color"] = "#C1C2C7"
            body.style.transition = "1s"
            small_card.style["background-color"] = "white"
        })

        small_card.addEventListener("mouseleave", ()=>{
            body.style["background-color"] = "white"
            body.style.transition = "0.5s"
            small_card.style["background-color"] = "inherit"
        })
    }
}

//let timer = setInterval(function(){window.location = window.location},1000);

export {ChangeAttributeInURL}