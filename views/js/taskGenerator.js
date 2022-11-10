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

function Editing(elements, new_value = "", style_key){
    for(let element of elements){
        switch(style_key){
            case "text-align":{
                ModifyElementStyle(element.closest(".editable_box"), {"text-align": new_value})
            };break
            case "size":{
                let new_size = `calc(${new_value}px + 0.3vw)`
                ModifyElementStyle(element, {"font-size": new_size})
            };break
            case "color":{
                ModifyElementStyle(element, {"color": new_value})
            };break
            case "family":{
                ModifyElementStyle(element, {"font-family": new_value})
            };break
            case "underlined":{
                if(element.style["text-decoration"] !== "underline"){
                    ModifyElementStyle(element, {"text-decoration": "underline"})
                }else{
                    ModifyElementStyle(element, {"text-decoration": ""})
                }
            };break
            case "crossed":{
                if(element.style["text-decoration"] !== "line-through"){
                    ModifyElementStyle(element, {"text-decoration": "line-through"})
                }else{
                    ModifyElementStyle(element, {"text-decoration": ""})
                }
            };break
            case "bold":{
                if(element.style["font-weight"] !== "bold"){
                    ModifyElementStyle(element, {"font-weight": "bold"})
                }else{     
                    ModifyElementStyle(element, {"font-weight": ""})
                }
            };break
            case "italic":{
                if(element.style["font-style"] !== "italic"){
                    ModifyElementStyle(element, {"font-style": "italic"})
                }else{     
                    ModifyElementStyle(element, {"font-style": ""})
                }
            };break
            case "margin-bottom":{
                ModifyElementStyle(element.closest(".editable_box"), {"margin-bottom": new_value})
            };break
            case "margin-top":{
                ModifyElementStyle(element.closest(".editable_box"), {"margin-top": new_value})
            };break
            default:break;
        }
    }
}

function AddButtonClickEffect(button, timeout = 200){
    let original_box_shadow = button.style.boxShadow
    button.style.boxShadow = "0px 0px 10px 0px rgba(132, 131, 131, 0.5)"
    setTimeout(()=>{
        button.style.boxShadow = original_box_shadow
    },timeout)
}

function ChangeElementToAnother(element, parent_selecter, new_element_tag_name){
    let original_text = ""
    if(element.tagName === "TEXTAREA"){
        original_text = element.value
    }else{
        original_text = element.innerText
    }
    let next_element = element.nextElementSibling
    let parent_element = element.closest(parent_selecter)

    let new_element = document.createElement(new_element_tag_name)
    if(new_element_tag_name === "textarea"){        
        new_element.value = original_text
        new_element.style["border-radius"] = "3px"
        new_element.cols = "100"
        new_element.rows = "5"
    }else{
        new_element.innerHTML = original_text
    }
    parent_element.removeChild(element)
    if(next_element){
        parent_element.insertBefore(next_element, new_element)
    }else{
        parent_element.appendChild(new_element)
    }

    return new_element
}

function AddEventsToParagraphLabel(element, tag_bame){
    element.addEventListener("click", ()=>{
        element.style["background-color"] = "rgb(255, 237, 230)"

        if(!chosen_elements_for_edition.includes(element)){
            chosen_elements_for_edition.push(element)
        }else{
            element.style["background-color"] = "white"
            chosen_elements_for_edition = RemoveElement(chosen_elements_for_edition, element)
        }
    })

    element.addEventListener("dblclick", ()=>{
        edited_label_parent = element.closest(".editable_box")
        editind_box = ChangeElementToAnother(element, ".editable_box", "textarea")

        editind_box.addEventListener("click", (event)=>{
            cursor_actual_pos = event.target.selectionEnd
        })
    })
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
let chosen_elements_for_edition = []
let edited_label_parent = NaN

let add_new_task_button = document.getElementById("add_new_task")
let remove_task_buttons = document.querySelectorAll(".remove_task_buttons")

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

let editind_box = NaN
let cursor_actual_pos = 0

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
    for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
        let labels = page_container_elements[children_counter].querySelectorAll("label")
        for(let label_element of labels){
            AddEventsToParagraphLabel(label_element, "label")
        }
    }  

    page_container.addEventListener("click", (event)=>{
        if(event.ctrlKey){
            if(all_highlighted){
                all_highlighted = false
                chosen_elements_for_edition = []
                for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
                    let labels = page_container_elements[children_counter].querySelectorAll("label")
                    for(let label_element of labels){
                        chosen_elements_for_edition.push(label_element)
                    }
                }
            }else{
                chosen_elements_for_edition = []
                all_highlighted = true
            }
    
            for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
                let labels = page_container_elements[children_counter].querySelectorAll("label")
                for(let label_element of labels){   
                    label_element.click()
                }
            }
        }
    })
}

if(add_new_task_button){
    add_new_task_button.addEventListener("click", (event)=>{
        event.preventDefault()

        let parent_element = add_new_task_button.parentNode
        let topic_select = parent_element.querySelector(".topic_select")
        let subtopic_select = parent_element.querySelector(".subtopic_select")
        let selected_main_topic = topic_select.options.selectedIndex
        let selected_subtopic = subtopic_select.options.selectedIndex
        let chosen_div = document.getElementById("big_exam_task_" + selected_main_topic + "_" + selected_subtopic)

        if(chosen_div != null){
            chosen_div.style["display"] = ""
            chosen_div.querySelectorAll("input").forEach((element)=>{element.disabled = ""})
        }
    })
}

if(remove_task_buttons){
    remove_task_buttons.forEach((remove_task_button)=>{
        remove_task_button.addEventListener("click", (event)=>{
            event.preventDefault()
    
            let parent_element = remove_task_button.parentNode
            parent_element.style["display"] = "none"
            parent_element.querySelectorAll("input").forEach((element)=>{element.disabled = "disabled"})
        })
    })
}

if(left_alignment){
    left_alignment.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "left", "text-align")
        AddButtonClickEffect(left_alignment)
    })
}

if(center_alignment){
    center_alignment.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "center", "text-align")
        AddButtonClickEffect(center_alignment)
    })
}

if(right_alignment){
    right_alignment.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "right", "text-align")
        AddButtonClickEffect(right_alignment)
    })
}

if(justify_alignment){
    justify_alignment.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "justify", "text-align")
        AddButtonClickEffect(justify_alignment)
    })
}

if(font_size_input){
    font_size_input.addEventListener("input", ()=>{
        Editing(chosen_elements_for_edition, font_size_input.value, "size")
    })
}

if(font_color_input){
    font_color_input.addEventListener("input", ()=>{
        Editing(chosen_elements_for_edition, font_color_input.value, "color")
    })
}

if(font_family_select){
    font_family_select.addEventListener("change", ()=>{
        let chosen_family = font_family_select.options[font_family_select.options.selectedIndex].value
        console.log(chosen_family)
        Editing(chosen_elements_for_edition, chosen_family, "family")
    })
}

if(underlined_button){
    underlined_button.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "", "underlined")
        AddButtonClickEffect(underlined_button)
    })
}

if(crossed_button){
    crossed_button.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "", "crossed")
        AddButtonClickEffect(crossed_button)
    })
}

if(bold_button){
    bold_button.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "", "bold")
        AddButtonClickEffect(bold_button)
    })
}

if(italic_button){
    italic_button.addEventListener("click", ()=>{
        Editing(chosen_elements_for_edition, "", "italic")
        AddButtonClickEffect(italic_button)
    })
}

if(linebreak_before_input){
    linebreak_before_input.addEventListener("input", ()=>{
        Editing(chosen_elements_for_edition, linebreak_before_input.value + "%", "margin-bottom")
    })
}

if(linebreak_after_input){
    linebreak_after_input.addEventListener("input", ()=>{
        Editing(chosen_elements_for_edition, linebreak_after_input.value + "%", "margin-top")
    })
}

if(save_pdf_button){
    save_pdf_button.addEventListener("click", (event)=>{
        event.preventDefault()

        all_highlighted = false
        let page_container_elements = page_container.children
        chosen_elements_for_edition = Array.from(page_container_elements)
        for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
            let labels = page_container_elements[children_counter].querySelectorAll("label")
            for(let label_element of labels){   
                label_element.click()
            }
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

window.addEventListener("click", (event)=>{
    if(edited_label_parent){
        let textarea = edited_label_parent.querySelector("textarea")
        if(textarea && event.target !== textarea && event.target !== document.getElementById("lt_button")){
            let label = ChangeElementToAnother(edited_label_parent.querySelector("textarea"), ".editable_box", "label")
            AddEventsToParagraphLabel(label)
        }
    }
})

if(document.getElementById("lt_button")){
    document.getElementById("lt_button").addEventListener("click", ()=>{
        let textarea = edited_label_parent.querySelector("textarea")
        textarea.value = textarea.value.substring(0,cursor_actual_pos) + "<span style=\"content: \"\\2282\";\">&lt</span>" + textarea.value.substring(cursor_actual_pos) 
    })
}