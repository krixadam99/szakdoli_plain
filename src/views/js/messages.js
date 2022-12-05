import {ChangeAttributeInURL} from "./mainContent.js"

// Variables
let write_message_button = document.getElementById("write_message_button")
let clickable_messages = document.querySelectorAll(".clickable_message")
let expandable_message_containers = document.querySelectorAll(".expandable_message_container")
let message_containers_expanded = document.querySelectorAll(".message_container_expanded")
let reply_button = document.getElementById("reply_button")
let remove_message_bubbles = document.querySelectorAll(".remove_message_bubble_input");
let check_message_bubbles = document.querySelectorAll(".check_message_bubble_input");
let remove_selected_elements = document.getElementById("remove_selected_elements")
let recover_selected_elements = document.getElementById("recover_selected_elements")

let inbox_button = document.getElementById("inbox_button")
let sent_button = document.getElementById("sent_button")
let deleted_button = document.getElementById("deleted_button")

let pagination_bubbles = document.getElementsByClassName("pagination_bubble")

// Non-navigation submenu
if(inbox_button && sent_button && deleted_button){
    inbox_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=messages&messageType=received"
    })

    sent_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=messages&messageType=sent"
    })

    deleted_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=messages&messageType=deleted"
    })
}


// Events related to writing a message
if(write_message_button){
    write_message_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=writeMessage"
    })
}

if(reply_button){
    reply_button.addEventListener("click", ()=>{
        let reply_div = document.getElementById("reply_div")
        if(reply_div){
            reply_div.style["display"] = ""
        }
        reply_button.style["display"] = "none"
    })
}


// Events related to expanding/closing, or clicking on a message
if(clickable_messages){
    for(let clickable_message of clickable_messages){
        clickable_message.addEventListener("click", ()=>{
            let message_id = clickable_message.id
            window.location = "./index.php?site=messages&messageId=" + message_id 
        })
    }
}

if(expandable_message_containers){
    for(let expandable_message_container of expandable_message_containers){
        expandable_message_container.addEventListener("click", ()=>{
            expandable_message_container.style["display"] = "none"
            let id = expandable_message_container.id
            document.getElementById(id.replace("message","expanded")).style["display"] = ""
        })
    }
}

if(message_containers_expanded){
    for(let message_container_expanded of message_containers_expanded){
        message_container_expanded.addEventListener("click", ()=>{
            message_container_expanded.style["display"] = "none"
            let id = message_container_expanded.id
            document.getElementById(id.replace("expanded","message")).style["display"] = ""
        })
    }
}

// Events related to chossing messages for removing/ recovering process
if(remove_message_bubbles){
    for(let remove_message_bubble of remove_message_bubbles){
        remove_message_bubble.addEventListener("click", ()=>{
            let found_checked = false
            for(let remove_message_bubble of remove_message_bubbles){
                found_checked = remove_message_bubble.checked
                if(remove_message_bubble.checked){
                    break
                }
            }

            let parent_form = remove_message_bubble.closest("form")
            let remove_selected_element_div = parent_form.querySelector("#remove_selected_elements")

            if(found_checked){
                remove_selected_element_div.style["display"] = ""
            }else{
                remove_selected_element_div.style["display"] = "none"
            }
        })
    }
}

if(check_message_bubbles){
    for(let check_message_bubble of check_message_bubbles){
        check_message_bubble.addEventListener("click", ()=>{
            let found_checked = false
            for(let check_message_bubble of check_message_bubbles){
                found_checked = check_message_bubble.checked
                if(check_message_bubble.checked){
                    break
                }
            }

            let parent_form = check_message_bubble.closest("form")
            let recover_selected_element_div = parent_form.querySelector("#recover_selected_elements")

            if(found_checked){
                recover_selected_element_div.style["display"] = ""
            }else{
                recover_selected_element_div.style["display"] = "none"
            }
        })
    }
}

// Events related to removing/ recovering messages
if(remove_selected_elements){
    let remove_image = remove_selected_elements.querySelector("img")
    remove_image.addEventListener("click", ()=>{
        remove_selected_elements.querySelector("input").click()
    })
}

if(recover_selected_elements){
    let recover_image = recover_selected_elements.querySelector("img")
    recover_image.addEventListener("click", ()=>{
        recover_selected_elements.querySelector("input").click()
    })
}


// Pagination element
if(pagination_bubbles){
    Array.from(pagination_bubbles).forEach((pagination_bubble)=>{
        pagination_bubble.addEventListener("click", ()=>{
            let pagination_bubble_id = pagination_bubble.id
            let page_number = pagination_bubble_id.split("page_")[1]
            
            ChangeAttributeInURL("startAt", page_number)
        })
    })
}