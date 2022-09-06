//Variables
let logout_button = document.querySelector("#sign_out_button")
let nav_buttons = document.querySelectorAll("nav")
let nav_button_number = nav_buttons.length
let submenu_navigation_links = document.querySelectorAll("a.submenu_row")
let navigation_links = document.querySelectorAll("a.menu_cell")
let student_rows = document.querySelectorAll("tr")
let group_selector = document.querySelector("#group_selector")
let solution_inputs = document.querySelectorAll(".solution_input")

//Event-handlers
if(logout_button){
    logout_button.addEventListener("click", ()=>{
        window.location = "./index.php"
    })
}

if(nav_buttons){
    let width = 100/nav_button_number
    for(let nav_button of nav_buttons){
        if(nav_button.id != "empty_nav"){
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



