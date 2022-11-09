<div class="pdf_page_task_choice_container">
    <?php include("./partials/mainTopicSelect.php")?>
    <?php include("./partials/subtopicSelect.php")?>
    <label class="pdf_page_task_choice_label" style="width: 20%; margin: 0% 0% 0% 5%">Hány feladat legyen generálva:</label>
    <input type="number" min="1" max="20" step="1" placeholder="4" style="width:9%; margin:0% 0% 0% 1%" name="task_quantity" value="<?=isset($_SESSION["preview"]["task_quantity"])?$_SESSION["preview"]["task_quantity"]:"4"?>">
</div>