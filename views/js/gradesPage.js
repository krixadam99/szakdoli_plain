// Variables
let progress_div = document.getElementById("progress_div")
let results_div = document.getElementById("results_div")

let progress_button = document.getElementById("progress_button")
let results_button = document.getElementById("results_button")

// Event-handlers
if(progress_button){
    progress_button.addEventListener("click", ()=>{
        progress_div.style["display"] = ""
        results_div.style["display"] = "none"

        progress_button.classList.remove("chosen")
        results_button.classList.remove("chosen")

        progress_button.classList.add("chosen")
    })
}

if(results_button){
    results_button.addEventListener("click", ()=>{
        progress_div.style["display"] = "none"
        results_div.style["display"] = ""

        progress_button.classList.remove("chosen")
        results_button.classList.remove("chosen")

        results_button.classList.add("chosen")
    })
}