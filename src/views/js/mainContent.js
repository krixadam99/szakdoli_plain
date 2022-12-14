// Functions:
/**
 * This method changes the url by the given parameter - value pair. If the parameter is already in the url, then the new value overrides the older.
 * 
 * @param {string} parameter The new url parameter.
 * @param {string} new_value The new value of the given url parameter
 */
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
let demonstrator_handling_button = document.getElementById("demonstrator_handling_button")
let messages_button =  document.getElementById("messages_button")
let group_addition_button =  document.getElementById("group_addition_button")
let user_setting_button =  document.getElementById("user_setting_button")
let nav_buttons = document.querySelectorAll("nav")
let nav_button_number = nav_buttons.length
let solution_inputs = document.querySelectorAll(".solution_input")
let body = document.querySelector("body")
let small_cards = document.querySelectorAll(".small_card")
let show_buttons = document.querySelectorAll(".show_button")

// Event-handlers

// Header's first line's navigation buttons
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

if(demonstrator_handling_button){
    demonstrator_handling_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=demonstratorHandling"
    })
}

if(messages_button){
    messages_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=messages&messageType=received"
    })
}

if(group_addition_button){
    group_addition_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=groupAddition"
    })
}

if(user_setting_button){
    user_setting_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=personalInformation"
    })
}

// The navigation buttons' events
// Hovering on a navigation menu button with submenu, should make the submenu visible
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

// Hovering on a small card should change the background's color to #96979a
if(body){
    for(let small_card of small_cards){
        small_card.addEventListener("mouseenter", ()=>{
            body.style["background-color"] = "#96979a"
            body.style.transition = "0.2s"
           
            small_cards.forEach((element)=>{
                if(element != small_card){
                    element.classList.remove("light")
                    element.classList.add("dark")
                    
                    element.querySelector(".level_bar").style["background-color"] =  "#96979a"
                    element.querySelectorAll("label").forEach((element)=>{element.style["color"] =  "rgba(78, 75, 75, 0.7)"})

                }
            })

            let main_topic = small_card.getAttribute("main-topic")
            let background_color = "white"
            
            small_card.style["background-color"] = background_color
        })

        small_card.addEventListener("mouseleave", ()=>{
            body.style["background-color"] = "white"
            body.style.transition = "0.2s"

            small_card.style["background-color"] = "inherit"
            
            small_cards.forEach((element)=>{
                if(element != small_card){
                    element.classList.remove("dark")
                    element.classList.add("light")

                    element.querySelector(".level_bar").style["background-color"] =  "white"
                    element.querySelectorAll("label").forEach((element)=>{element.style["color"] =  "black"})
                }
            })
        })
    }
}

// The definition holder element
if(show_buttons){
    let is_shown = []
    let counter = 0
    for(let show_button of show_buttons){
        is_shown[counter] = false
        show_button.addEventListener("click", ()=>{          
            let definition_holder = show_button.closest(".definition_holder")  
            let definitions = definition_holder.querySelectorAll(".definition")
            if(is_shown[counter]){
                definitions.forEach((element, index)=>{
                    if(index !== 0){
                        element.style["display"] = "none"
                    }else{
                        let labels = element.querySelectorAll("label")
                        labels.forEach((label)=>{
                            label.classList.add("elliptical_definition")
                        })
                    }
                })
                is_shown[counter] = false
    
                let bottom_triangle = show_button.querySelector(".bottom_triangle")
                show_button.removeChild(bottom_triangle)
                
                let top_triangle = document.createElement("div")
                top_triangle.classList.add("top_triangle")
                show_button.appendChild(top_triangle)
            }else{
                definitions.forEach((element, index)=>{
                    if(index !== 0){
                        element.style["display"] = "block"
                    }else{
                        let elliptical_definitions = element.querySelectorAll(".elliptical_definition")
                        elliptical_definitions.forEach((elliptical_definition)=>{elliptical_definition.classList.remove("elliptical_definition")})
                    }
                })
                    
                is_shown[counter] = true
                let top_triangle = show_button.querySelector(".top_triangle")
                show_button.removeChild(top_triangle)
                
                let bottom_triangle = document.createElement("div")
                bottom_triangle.classList.add("bottom_triangle")
                show_button.appendChild(bottom_triangle)
            }
        })
        counter++
    }
}

//let timer = setInterval(function(){window.location = window.location},1000);

export {ChangeAttributeInURL}