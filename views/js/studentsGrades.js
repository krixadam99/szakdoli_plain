// Variables
let grades_form = document.getElementById("grades_form")
let notification_box = document.getElementById("notification_box")
let expectation_rules_form = document.getElementById("expectation_rules_form")
let task_due_date_form = document.getElementById("task_due_date_form")
let grade_levels_form = document.getElementById("grade_levels_form")

let update_grades_button = document.getElementById("update_grades_button")
let update_expectation_rules_button = document.getElementById("update_expectation_rules_button")
let update_task_due_dates_button = document.getElementById("update_task_due_dates_button")
let update_grade_points_button = document.getElementById("update_grade_points_button")

// Event-handlers
if(update_grades_button){
    update_grades_button.addEventListener("click", ()=>{
        if(grades_form){
            grades_form.style["display"] = ""
        }else{
            notification_box.style["display"] = ""
        }
        expectation_rules_form.style["display"] = "none"
        task_due_date_form.style["display"] = "none"
        grade_levels_form.style["display"] = "none"

        update_grades_button.classList.remove("chosen")
        update_expectation_rules_button.classList.remove("chosen")
        update_task_due_dates_button.classList.remove("chosen")
        update_grade_points_button.classList.remove("chosen")

        update_grades_button.classList.add("chosen")
    })
}

if(update_expectation_rules_button){
    update_expectation_rules_button.addEventListener("click", ()=>{
        if(grades_form){
            grades_form.style["display"] = "none"
        }else{
            notification_box.style["display"] = "none"
        }
        expectation_rules_form.style["display"] = ""
        task_due_date_form.style["display"] = "none"
        grade_levels_form.style["display"] = "none"

        update_grades_button.classList.remove("chosen")
        update_expectation_rules_button.classList.remove("chosen")
        update_task_due_dates_button.classList.remove("chosen")
        update_grade_points_button.classList.remove("chosen")

        update_expectation_rules_button.classList.add("chosen")
    })
}

if(update_task_due_dates_button){
    update_task_due_dates_button.addEventListener("click", ()=>{
        if(grades_form){
            grades_form.style["display"] = "none"
        }else{
            notification_box.style["display"] = "none"
        }
        expectation_rules_form.style["display"] = "none"
        task_due_date_form.style["display"] = ""
        grade_levels_form.style["display"] = "none"

        update_grades_button.classList.remove("chosen")
        update_expectation_rules_button.classList.remove("chosen")
        update_task_due_dates_button.classList.remove("chosen")
        update_grade_points_button.classList.remove("chosen")

        update_task_due_dates_button.classList.add("chosen")
    })
}

if(update_grade_points_button){
    update_grade_points_button.addEventListener("click", ()=>{
        if(grades_form){
            grades_form.style["display"] = "none"
        }else{
            notification_box.style["display"] = "none"
        }
        expectation_rules_form.style["display"] = "none"
        task_due_date_form.style["display"] = "none"
        grade_levels_form.style["display"] = ""

        update_grades_button.classList.remove("chosen")
        update_expectation_rules_button.classList.remove("chosen")
        update_task_due_dates_button.classList.remove("chosen")
        update_grade_points_button.classList.remove("chosen")

        update_grade_points_button.classList.add("chosen")
    })
}

