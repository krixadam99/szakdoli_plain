let write_message_button = document.getElementById("write_message_button")
let clickable_messages = document.querySelectorAll(".clickable_message")
let expandable_message_containers = document.querySelectorAll(".expandable_message_container")
let message_containers_expanded = document.querySelectorAll(".message_container_expanded")
let reply_button = document.getElementById("reply_button")

if(write_message_button){
    write_message_button.addEventListener("click", ()=>{
        window.location = "./index.php?site=writeMessage"
    })
}

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

if(reply_button){
    reply_button.addEventListener("click", ()=>{
        let reply_div = document.getElementById("reply_div")
        if(reply_div){
            reply_div.style["display"] = ""
        }
        reply_button.style["display"] = "none"
    })
}
