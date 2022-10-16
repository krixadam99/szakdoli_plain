import {ChangeAttributeInURL} from "./mainContent.js"

let student_rows = document.querySelectorAll("#student_handling_form tr.student_row")
let group_selector = document.querySelector("#group_selector")

if(group_selector){
    group_selector.addEventListener("change", ()=>{
        let selected_index = group_selector.options.selectedIndex
        let selected_group = group_selector.options[selected_index].value
        ChangeAttributeInURL("group", selected_group);
    })
}