<div class="pdf_page_style_container">
    <label class="pdf_page_styling_label" style="margin: 0%">Betűméret:</label>
    <input type="number" min="1" max="100" step="1" value="<?=isset($_SESSION["preview"][$section_name . "_font_size"])?$_SESSION["preview"][$section_name . "_font_size"]:"12"?>" style="width:10%; margin:0% 9% 0% 1%" name="<?=$section_name??""?>_font_size">

    <label class="pdf_page_styling_label" style="margin: 0% 0% 0% 5%">Betűszín:</label>
    <input type="color" style="width:10%; margin:0% 9% 0% 1%" value="<?=isset($_SESSION["preview"][$section_name . "_font_color"])?$_SESSION["preview"][$section_name . "_font_color"]:"#000000"?>" name="<?=$section_name??""?>_font_color">

    <label class="pdf_page_styling_label" style="margin: 0% 0% 0% 5%">Betűtípus:</label>
    <select style="width:20%; margin:0% 0% 0% 1%" name="<?=$section_name??""?>_font_type">
        <?php 
            $previous_chosen_font_type = "";
            if(isset($_SESSION["preview"][$section_name . "_font_type"])){
                $previous_chosen_font_type = $_SESSION["preview"][$section_name . "_font_type"];
            }
        ?>
        <option <?=$previous_chosen_font_type === "Arial"?"selected":""?>>Arial</option>
        <option <?=$previous_chosen_font_type === "Courier New"?"selected":""?>>Courier New</option>
        <option <?=$previous_chosen_font_type === "Garamond"?"selected":""?>>Garamond</option>    
        <option <?=$previous_chosen_font_type === "Georgia"?"selected":""?>>Georgia</option>
        <option <?=$previous_chosen_font_type === "Helvetica"?"selected":""?>>Helvetica</option>
        <option <?=$previous_chosen_font_type === "Lucida Console"?"selected":""?>>Lucida Console</option>
        <option <?=$previous_chosen_font_type === "Monaco"?"selected":""?>>Monaco</option>
        <option <?=$previous_chosen_font_type === "Papyrus"?"selected":""?>>Papyrus</option>
        <option <?=$previous_chosen_font_type === "Times New Roma"?"selected":""?>>Times New Roman</option>
        <option <?=$previous_chosen_font_type === "Verdana"?"selected":""?>>Verdana</option>
    </select>
</div>
<div class="pdf_page_style_container">
    <label class="pdf_page_styling_label" style="margin: 0%">Sortörés előtte:</label>
    <input type="number" min="0" max="112" step="3" name="<?=$section_name??""?>_line_break_before" style="width:10%; margin:0% 9% 0% 1%" value="<?=isset($_SESSION["preview"][$section_name . "_line_break_before"])?$_SESSION["preview"][$section_name . "_line_break_before"]:"6"?>">

    <label class="pdf_page_styling_label" style="margin: 0% 0% 0% 5%">Sortörés utána:</label>
    <input type="number" min="0" max="112" step="3" name="<?=$section_name??""?>_line_break_after"style="width:10%; margin:0% 9% 0% 1%" value="<?=isset($_SESSION["preview"][$section_name . "_line_break_after"])?$_SESSION["preview"][$section_name . "_line_break_after"]:"6"?>">

    <label class="pdf_page_styling_label" style="margin: 0% 0% 0% 5%">Szöveg igazítása:</label>
    <select style="width:20%; margin:0% 0% 0% 1%" name="<?=$section_name??""?>_text_align">
        <?php 
            $previous_text_alignment = "";
            if(isset($_SESSION["preview"][$section_name . "_text_align"])){
                $previous_text_alignment = $_SESSION["preview"][$section_name . "_text_align"];
            }
        ?>
        <option <?=$previous_text_alignment === "Balra"?"selected":""?>>Balra</option>
        <option <?=$previous_text_alignment === "Középre"?"selected":""?>>Középre</option>
        <option <?=$previous_text_alignment === "Jobbra"?"selected":""?>>Jobbra</option>    
        <option <?=$previous_text_alignment === "Sorkizárt"?"selected":""?>>Sorkizárt</option>
    </select>
</div>

