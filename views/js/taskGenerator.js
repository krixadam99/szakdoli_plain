import {ChangeAttributeInURL} from "./mainContent.js"

// Functions:
function RemoveElement(array, child){
    let index_of_actual_child = array.indexOf(child)
    if(index_of_actual_child >= 0){
        let new_array = [];
        for(let child_counter = 0; child_counter < array.length; child_counter++){
            if(child_counter !== index_of_actual_child){
                new_array.push(array[child_counter])
            }
        }
        return new_array
    }else{
        return array
    }
}

function ModifyElementStyle(element, style_dictionary){
    if(element){
        for (let key in style_dictionary){
            element.style[key] = style_dictionary[key]
        }
    }
}

function Editing(elements, new_value = "", style_key, children_type = "label"){
    for(let element of elements){
        if(children_type !== ""){
            let children = element.querySelectorAll("label")
            if(children_type === "label"){
                children = element.querySelectorAll("label")
            }
            
            for(let child of children){
                switch(style_key){
                    case "size":{
                        let new_size = `calc(${new_value}px + 0.3vw)`
                        ModifyElementStyle(child, {"font-size": new_size})
                    };break
                    case "color":{
                        ModifyElementStyle(child, {"color": new_value})
                    };break
                    case "family":{
                        ModifyElementStyle(child, {"font-family": new_value})
                    };break
                    case "underlined":{
                        if(child.style["text-decoration"] !== "underline"){
                            ModifyElementStyle(child, {"text-decoration": "underline"})
                        }else{
                            ModifyElementStyle(child, {"text-decoration": ""})
                        }
                    };break
                    case "crossed":{
                        if(child.style["text-decoration"] !== "line-through"){
                            ModifyElementStyle(child, {"text-decoration": "line-through"})
                        }else{
                            ModifyElementStyle(child, {"text-decoration": ""})
                        }
                    };break
                    case "bold":{
                        if(child.style["font-weight"] !== "bold"){
                            ModifyElementStyle(child, {"font-weight": "bold"})
                        }else{     
                            ModifyElementStyle(child, {"font-weight": ""})
                        }
                    };break
                    case "italic":{
                        if(child.style["font-style"] !== "italic"){
                            ModifyElementStyle(child, {"font-style": "italic"})
                        }else{     
                            ModifyElementStyle(child, {"font-style": ""})
                        }
                    };break
                    default:break;
                }
            }
        }else{
            if(style_key === "margin-bottom"){
                ModifyElementStyle(element, {"margin-bottom": new_value + "%"})
            }else if(style_key === "margin-top"){
                ModifyElementStyle(element, {"margin-top": new_value + "%"})
            }
        }
    }
}

// Variables
let small_exam_generation_card = document.getElementById("small_exam_generation")
let big_exam_generation_card = document.getElementById("big_exam_generation")
let seminar_tasks_generation_card = document.getElementById("seminar_tasks_generation")
let topic_select = document.querySelector(".topic_select")
let save_pdf_button = document.getElementById("save_pdf_button")
let preview = document.getElementById("preview")
let new_task_generator_button = document.getElementById("new_task_generator_button")
let page_container = document.getElementById("page_container")
let chosen_children_for_edition = []

let font_size_input = document.getElementById("font_size_input")
let font_color_input = document.getElementById("font_color_input")
let font_family_select = document.getElementById("font_family_select")

let underlined_button = document.getElementById("underlined")
let crossed_button = document.getElementById("crossed")
let bold_button = document.getElementById("bold")
let italic_button = document.getElementById("italic")

let left_alignment = document.getElementById("left_alignment")
let center_alignment = document.getElementById("center_alignment")
let right_alignment = document.getElementById("right_alignment")
let justify_alignment = document.getElementById("justify_alignment")

let linebreak_before_input = document.getElementById("linebreak_before_input")
let linebreak_after_input = document.getElementById("linebreak_after_input")

let all_highlighted = false

// Event-handlers
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
        
        let subtopic_box= document.querySelector(".subtopic_box")
        let subtopic_children= subtopic_box.children;
        for(let subtopic_counter = 0; subtopic_counter < subtopic_children.length; subtopic_counter++) {
            if(subtopic_counter === selected_index){
                subtopic_children[subtopic_counter].style["display"] = "inline"
                subtopic_children[subtopic_counter].disabled = ""
                if(subtopic_children[subtopic_counter].tagName.toLocaleLowerCase() === "input"){
                    subtopic_children[subtopic_counter].readOnly = true
                }
            }else{
                subtopic_children[subtopic_counter].style["display"] = "none"
                subtopic_children[subtopic_counter].disabled = "disabled"
            }
        }
    })
}

if(page_container){
    let page_container_elements = page_container.children
    for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++) {
        let actual_child = page_container_elements[children_counter]
        actual_child.addEventListener("click", ()=>{
            actual_child.style["background-color"] = "rgb(255, 237, 230)"
            for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++) {
                let other_child = page_container_elements[children_counter]
                
                if(other_child !== actual_child && !chosen_children_for_edition.includes(other_child)){
                    other_child.style["background-color"] = "white"
                }
            }

            if(!chosen_children_for_edition.includes(actual_child)){
                chosen_children_for_edition.push(actual_child)
            }else{
                actual_child.style["background-color"] = "white"
                chosen_children_for_edition = RemoveElement(chosen_children_for_edition, actual_child)
            }
        })
    }  

    page_container.addEventListener("dblclick", ()=>{
        if(all_highlighted){
            all_highlighted = false
            chosen_children_for_edition = Array.from(page_container_elements)
        }else{
            chosen_children_for_edition = []
            all_highlighted = true
        }

        for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
            page_container_elements[children_counter].click()
        }
    })
}

if(left_alignment){
    left_alignment.addEventListener("click", ()=>{
        for(let chosen_child_for_edition of chosen_children_for_edition){
            ModifyElementStyle(chosen_child_for_edition, {"text-align": "left"})
        }
    })
}

if(center_alignment){
    center_alignment.addEventListener("click", ()=>{
        for(let chosen_child_for_edition of chosen_children_for_edition){
            ModifyElementStyle(chosen_child_for_edition, {"text-align": "center"})
        }
    })
}

if(right_alignment){
    right_alignment.addEventListener("click", ()=>{
        for(let chosen_child_for_edition of chosen_children_for_edition){
            ModifyElementStyle(chosen_child_for_edition, {"text-align": "right"})
        }
    })
}

if(justify_alignment){
    justify_alignment.addEventListener("click", ()=>{
        for(let chosen_child_for_edition of chosen_children_for_edition){
            ModifyElementStyle(chosen_child_for_edition, {"text-align": "justify"})
        }
    })
}

if(font_size_input){
    font_size_input.addEventListener("input", ()=>{
        Editing(chosen_children_for_edition, font_size_input.value, "size")
    })
}

if(font_color_input){
    font_color_input.addEventListener("input", ()=>{
        Editing(chosen_children_for_edition, font_color_input.value, "color")
    })
}

if(font_family_select){
    font_family_select.addEventListener("change", ()=>{
        let chosen_family = font_family_select.options[font_family_select.options.selectedIndex].value
        console.log(chosen_family)
        Editing(chosen_children_for_edition, chosen_family, "family")
    })
}

if(underlined_button){
    underlined_button.addEventListener("click", ()=>{
        Editing(chosen_children_for_edition, "", "underlined")
    })
}

if(crossed_button){
    crossed_button.addEventListener("click", ()=>{
        Editing(chosen_children_for_edition, "", "crossed")
    })
}

if(bold_button){
    bold_button.addEventListener("click", ()=>{
        Editing(chosen_children_for_edition, "", "bold")
    })
}

if(italic_button){
    italic_button.addEventListener("click", ()=>{
        Editing(chosen_children_for_edition, "", "italic")
    })
}

if(linebreak_before_input){
    linebreak_before_input.addEventListener("input", ()=>{
        Editing(chosen_children_for_edition, linebreak_before_input.value, "margin-bottom", "")
    })
}

if(linebreak_after_input){
    linebreak_after_input.addEventListener("input", ()=>{
        Editing(chosen_children_for_edition, linebreak_after_input.value, "margin-top", "")
    })
}

if(save_pdf_button){
    save_pdf_button.addEventListener("click", (event)=>{
        event.preventDefault()

        all_highlighted = false
        let page_container_elements = page_container.children
        chosen_children_for_edition = Array.from(page_container_elements)
        for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
            page_container_elements[children_counter].click()
        }

        let preview_content = document.getElementById("page_container").cloneNode(true)
        let new_window = window.open("./index.php?site=printPage")
        self.focus()
        new_window.document.querySelector("body").appendChild(preview_content)
        new_window.document.close()
        new_window.print();
        new_window.close();
    })
}