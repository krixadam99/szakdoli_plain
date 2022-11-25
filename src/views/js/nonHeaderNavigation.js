let non_header_navigation_row_buttons = document.querySelectorAll(".non_header_navigation_row_button")
let non_header_navigation_divs = document.querySelectorAll(".non_header_navigation_div")

if(non_header_navigation_row_buttons){
    for(let counter = 0; counter < non_header_navigation_row_buttons.length; ++counter){
        let non_header_navigation_row_button = non_header_navigation_row_buttons[counter]
        non_header_navigation_row_button.addEventListener("click", ()=>{
            // Styling
            for(let button of non_header_navigation_row_buttons){
                button.classList.remove("chosen")
            }
            non_header_navigation_row_button.classList.add("chosen")

            for(let div of non_header_navigation_divs){
                div.style["display"] = "none"
            }
            non_header_navigation_divs[counter].style["display"] = ""
        })
    }
}