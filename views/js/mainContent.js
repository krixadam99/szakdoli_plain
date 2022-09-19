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
let nav_buttons = document.querySelectorAll("nav")
let nav_button_number = nav_buttons.length
let submenu_navigation_links = document.querySelectorAll("a.submenu_row")
let navigation_links = document.querySelectorAll("a.menu_cell")
let student_rows = document.querySelectorAll("tr")
let group_selector = document.querySelector("#group_selector")
let solution_inputs = document.querySelectorAll(".solution_input")
let body = document.querySelector("body")
let small_cards = document.querySelectorAll(".small_card")
let small_exam_generation_card = document.getElementById("small_exam_generation")
let big_exam_generation_card = document.getElementById("big_exam_generation")
let seminar_tasks_generation_card = document.getElementById("seminar_tasks_generation")
let topic_select = document.querySelector(".topic_select")
let save_pdf_button = document.getElementById("save_pdf_button")
let preview = document.getElementById("preview")
let new_task_generator_button = document.getElementById("new_task_generator_button")

// Event-handlers
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

            nav_button.addEventListener("click",()=>{
                nav_button.querySelector("a").click()
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

if(group_selector){
    group_selector.addEventListener("change", ()=>{ChangeAttributeInURL("group", group_selector.options[group_selector.options.selectedIndex].value)})
}

if(small_exam_generation_card){
    small_exam_generation_card.addEventListener("click", ()=>{ChangeAttributeInURL("exam_type", "small")})
}

if(big_exam_generation_card){
    big_exam_generation_card.addEventListener("click", ()=>{ChangeAttributeInURL("exam_type", "big")})
}

if(seminar_tasks_generation_card){
    seminar_tasks_generation_card.addEventListener("click", ()=>{ChangeAttributeInURL("exam_type", "seminar")})
}

if(topic_select){
    topic_select.addEventListener("change", ()=>{
        let selected_index = topic_select.options.selectedIndex

        console.log(selected_index)
        
        let subtopic_selects = document.querySelectorAll(".subtopic_select")
        console.log(subtopic_selects)
        for(let subtopic_select_counter = 0; subtopic_select_counter < subtopic_selects.length; subtopic_select_counter++) {
            if(subtopic_select_counter === selected_index){
                console.log(subtopic_selects[subtopic_select_counter])
                subtopic_selects[subtopic_select_counter].style["display"] = "inline"
                subtopic_selects[subtopic_select_counter].disabled = ""
            }else{
                subtopic_selects[subtopic_select_counter].style["display"] = "none"
                subtopic_selects[subtopic_select_counter].disabled = "disabled"
            }
        }
    })
}

if(save_pdf_button){
    save_pdf_button.addEventListener("click", (event)=>{
        event.preventDefault()

        let new_window = window.open()
        let preview_content = document.getElementById("preview").innerHTML
        console.log(preview_content)
        self.focus()
        new_window.document.open()
        new_window.document.write('<html><body>' +  preview_content + '</body></html>')
        new_window.document.close()
        new_window.print();
        new_window.close();
    })
}

//let timer = setInterval(function(){window.location = window.location},1000);