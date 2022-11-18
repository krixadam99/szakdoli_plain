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

function ChangeElementToAnother(parent_element, children_selector = "editable_label", element_new_tagname = "SPAN"){
    let children = Array.from(parent_element.children)
    children.forEach((child)=>{
        let all = parent_element.querySelectorAll(children_selector)
        if(Array.from(all).includes(child)){
            let original_text = ""
            original_text = child.innerHTML
    
            let new_element = document.createElement(element_new_tagname)
            if(element_new_tagname === "SPAN"){
                new_element.innerHTML = original_text
                new_element.setAttribute("contentEditable", true)
                new_element.classList.add("editing_span")
            }else{
                new_element.innerHTML = original_text
                new_element.classList.add("editable_label")
            }

            GetComputedStylesOfChild(child, new_element)
            parent_element.replaceChild(new_element,child)
        }
        ChangeElementToAnother(child, children_selector, element_new_tagname)
    })
}

function AddEventsToParagraphLabel(element){
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
        ChangeElementToAnother(edited_label_parent, ".editable_label", "SPAN")
        edited_label_parent.classList.add("in_editing");
        edited_label_parent.style["display"] = "inline"

        edited_label_parent.querySelectorAll("span.editing_span").forEach((editing_span)=>{
            editing_span.addEventListener("click", (event)=>{
                editing_span.style.height = "auto";
                cursor_actual_pos = window.getSelection().anchorOffset
                console.log(cursor_actual_pos, window.getSelection(),  window)
                focused_span = event.target
                if(editing_span.parentElement !== edited_label_parent){
                    //editing_span.style["border-right"] = "0px"
                }
            })

            editing_span.addEventListener("keyup", (event)=>{
                cursor_actual_pos = window.getSelection().anchorOffset
                if(editing_span.innerHTML === ""){
                    editing_span.parentElement.removeChild(editing_span)
                }
            })
        })

        edited_label_parent.querySelectorAll("button").forEach((button)=>{
            button.style["display"] = ""
        })
    })
}

function removeHighlights(){
    all_highlighted = false
    chosen_elements_for_edition = []
    let page_container_elements = page_container.children

    for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
        let labels = page_container_elements[children_counter].querySelectorAll("label")
        for(let label_element of labels){
            chosen_elements_for_edition.push(label_element)
        }
    }

    for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
        let labels = page_container_elements[children_counter].querySelectorAll("label")
        for(let label_element of labels){   
            label_element.click()
        }
    }
}

function AddTextAreaXButton(parent_element, remove_from = "grand_parent"){
    let new_x_button = document.createElement("button")
    new_x_button.innerHTML = "x" 
    new_x_button.classList.add("x_button")
    new_x_button.addEventListener("click",()=>{
        let parent = new_x_button.parentElement
        let next_element = NaN
        let previous_element = NaN

        if(remove_from === "grand_parent"){
            next_element = parent.nextElementSibling
            previous_element = parent.previousElementSibling
        }else if(remove_from === "grand_grand_parent"){
            next_element = parent.parentElement.nextElementSibling
            previous_element = parent.parentElement.previousElementSibling
        }

        if(    next_element 
            && previous_element 
            && Array.from(next_element.classList).includes("editing_span")
            && Array.from(previous_element.classList).includes("editing_span")
        ){
            previous_element.innerHTML += next_element.innerHTML
            next_element.parentElement.removeChild(next_element)

        }

        if(remove_from === "grand_parent"){
            let grand_parent = parent_element.parentElement
            grand_parent.removeChild(new_x_button.parentElement)
        }else if(remove_from === "grand_grand_parent"){
            let grand_grand_parent = parent_element.parentElement.parentElement
            grand_grand_parent.removeChild(parent_element.parentElement)    
        }
    })

    let new_textarea = CreateNewSpan({"border-right":0, "padding-right":"30px"})

    parent_element.appendChild(new_textarea)
    parent_element.appendChild(new_x_button)
}

function SplitTextAreaIfNecessary(element){
    let focused_element_parent = focused_span.parentNode

    let new_span_first = CreateNewSpan([])
    new_span_first.innerHTML = focused_span.innerHTML.substring(0,cursor_actual_pos)

    let new_span_second= CreateNewSpan([])
    new_span_second.innerHTML = focused_span.innerHTML.substring(cursor_actual_pos)


    GetComputedStylesOfChild(focused_span, new_span_first)
    GetComputedStylesOfChild(focused_span, new_span_second)
    
    if(new_span_first.innerHTML !== ""){
        focused_element_parent.insertBefore(new_span_first,focused_span)
    }

    if(new_span_second.innerHTML !== ""){
        focused_element_parent.insertBefore(element,focused_span)
        focused_element_parent.insertBefore(new_span_second,focused_span)
        focused_element_parent.removeChild(focused_span)
    }else{
        if(focused_span.nextElementSibling){
            if(focused_span.nextElementSibling.nextElementSibling){
                focused_element_parent.insertBefore(element,focused_span.nextElementSibling.nextElementSibling)
                focused_element_parent.removeChild(focused_span)
            }else{
                focused_element_parent.appendChild(element)
            }
        }else{
            focused_element_parent.appendChild(element)
            focused_element_parent.removeChild(focused_span)
        }
    }
}

function CreateNewSpan(styles){
    let new_span = document.createElement("span")
    new_span.classList.add("editing_span")
    new_span.setAttribute("contentEditable", true)

    new_span.addEventListener("click", (event)=>{
        focused_span = event.target
        cursor_actual_pos = window.getSelection().anchorOffset
    })

    new_span.addEventListener("keyup", (event)=>{
        cursor_actual_pos = window.getSelection().anchorOffset

        if(new_span.innerHTML === "" && (!new_span.nextElementSibling || new_span.nextElementSibling && new_span.nextElementSibling.tagName !== "BUTTON")){
            new_span.parentElement.removeChild(new_span)        
        }
    })

    for(let key in styles){
        new_span.style[key] = styles[key]
    }

    return new_span
}

function GetComputedStylesOfChild(child, new_element){
    let computed_styles = window.getComputedStyle(child)
    new_element.style["font-family"] = computed_styles.fontFamily
    new_element.style["font-size"] = computed_styles.fontSize
    new_element.style["color"] = computed_styles.color
    new_element.style["text-decoration"] = computed_styles.textDecoration
    new_element.style["font-weight"] = computed_styles.fontWeight
    new_element.style["font-style"] = computed_styles.fontStyle
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

let special_character_button = document.getElementById("special_character_button")
let special_character_cells = document.querySelectorAll(".special_character_cell")
let sup_button = document.getElementById("exp_button")
let sub_button = document.getElementById("bottom_button")
let fraction_button = document.getElementById("fraction_button")
let sub_sup_button = document.getElementById("sub_sup_button")
let focused_span = NaN

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
                removeHighlights();
            }else{
                chosen_elements_for_edition = []
                all_highlighted = true

                for(let children_counter = 0; children_counter < page_container_elements.length; children_counter++){
                    let labels = page_container_elements[children_counter].querySelectorAll("label")
                    for(let label_element of labels){   
                        label_element.click()
                    }
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

        let selected_subtopic = 0
        if(subtopic_select.tagName === "SELECT"){
            selected_subtopic = subtopic_select.options.selectedIndex
        }
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
        Editing(chosen_elements_for_edition, linebreak_before_input.value + "%", "margin-top")
    })
}

if(linebreak_after_input){
    linebreak_after_input.addEventListener("input", ()=>{
        Editing(chosen_elements_for_edition, linebreak_after_input.value + "%", "margin-bottom")
    })
}

if(special_character_button){
    special_character_button.addEventListener("mouseenter", ()=>{
        let special_characters_holder = special_character_button.querySelector(".special_characters")
        special_characters_holder.style["display"] = "block"
    })

    special_character_button.addEventListener("mouseleave", ()=>{
        let special_characters_holder = special_character_button.querySelector(".special_characters")
        special_characters_holder.style["display"] = "none"
    })
}

if(special_character_button){
    special_character_button.addEventListener("mouseenter", ()=>{
        let special_characters_holder = special_character_button.querySelector(".special_characters")
        special_characters_holder.style["display"] = "block"
    })

    special_character_button.addEventListener("mouseleave", ()=>{
        let special_characters_holder = special_character_button.querySelector(".special_characters")
        special_characters_holder.style["display"] = "none"
    })
}

if(special_character_cells){
    special_character_cells.forEach((special_character_cell)=>{
        special_character_cell.addEventListener("click", ()=>{
            if(edited_label_parent && focused_span){
                let character_span = special_character_cell.querySelector("span")
                let html_entity = character_span.getAttribute("entity")

                focused_span.innerHTML = focused_span.innerHTML.substring(0,cursor_actual_pos) + html_entity + focused_span.innerHTML.substring(cursor_actual_pos) 
            }
        })
    })
}

if(sup_button){
    sup_button.addEventListener("click", ()=>{       
        if(focused_span){
            let new_sup = document.createElement("sup")
            AddTextAreaXButton(new_sup)

            SplitTextAreaIfNecessary(new_sup)
        }
    })
}

if(sub_button){
    sub_button.addEventListener("click", ()=>{
        if(focused_span){
            let new_sub = document.createElement("sub")
            AddTextAreaXButton(new_sub)
            
            SplitTextAreaIfNecessary(new_sub)
        }
    })
}

if(fraction_button){
    fraction_button.addEventListener("click", ()=>{
        if(focused_span){
            let fraction_span = document.createElement("span")
            fraction_span.classList.add("fraction")
            let nominator_span = document.createElement("span")
            nominator_span.classList.add("nominator")
            let denominator_span = document.createElement("span")
            denominator_span.classList.add("denominator")
            AddTextAreaXButton(nominator_span, "grand_grand_parent")
            AddTextAreaXButton(denominator_span, "grand_grand_parent")
            fraction_span.appendChild(nominator_span)
            fraction_span.appendChild(denominator_span)

            SplitTextAreaIfNecessary(fraction_span)
        }
    })
}

if(sub_sup_button){
    sub_sup_button.addEventListener("click", ()=>{
        if(focused_span){
            let upper_down_span = document.createElement("span")
            upper_down_span.classList.add("upper_down_span")

            let new_up_index_span = document.createElement("span")
            new_up_index_span.classList.add("up_index")
            AddTextAreaXButton(new_up_index_span, "grand_grand_parent")

            let new_down_index_span = document.createElement("span")
            new_down_index_span.classList.add("down_index", "grand_grand_parent")
            AddTextAreaXButton(new_down_index_span)

            upper_down_span.appendChild(new_up_index_span)
            upper_down_span.appendChild(new_down_index_span)
            SplitTextAreaIfNecessary(upper_down_span)
        }
    })
}


if(save_pdf_button){
    save_pdf_button.addEventListener("click", (event)=>{
        event.preventDefault()

        removeHighlights();


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
        let editing_spans = edited_label_parent.querySelectorAll(".editing_span")

        if(    editing_spans
            && !Array.from(editing_spans).includes(event.target)
            && event.target.closest("#page_container")
            && event.target.closest(".in_editing") !== edited_label_parent
        ){
            editing_spans.forEach((editing_span)=>{
                if(chosen_elements_for_edition.includes(editing_span)){
                    chosen_elements_for_edition.pop(editing_span)
                }
            })

            ChangeElementToAnother(edited_label_parent, ".editing_span", "LABEL")
            edited_label_parent.style["display"] = "block"

            edited_label_parent.querySelectorAll("button").forEach((button)=>{
                button.style["display"] = "none"
            })

            let labels = edited_label_parent.querySelectorAll("label")
            labels.forEach((label)=>{
                AddEventsToParagraphLabel(label)
            })
            edited_label_parent.classList.remove("in_editing")
            
            edited_label_parent = NaN
            focused_span = NaN
        }
    }
})