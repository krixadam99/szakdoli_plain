<?php

    require __DIR__ . "/../../src/lib/formValidator.php";

    use phpDocumentor\Reflection\Types\Boolean;
    use PHPUnit\Framework\TestCase;

    use function PHPUnit\Framework\assertTrue;

    class FormValidatorTest extends TestCase{
        private $form_validator_descendant;

        protected function setUp() : void {
            parent::setUp();
            $this->form_validator_descendant = new class extends FormValidator {
                public function CallValidateInputs($validation_array){ 
                    return $this->ValidateInputs($validation_array); 
                }
            };
        }

        /**
         * This method tests the ValidateInputs() method of the FormValidator class.
         * 
         * @test
         */
        public function ValidateInputsInvalidInputsTest() : void {
            $this->form_validator_descendant->CallValidateInputs([
                "first_variable:first variable" => array("INVALID NAME ATTRIBUTE" => [])
            ]);
           
            $this->form_validator_descendant->CallValidateInputs([
                "second_variable:second variable" => array("" => [
                    "type" => "array"
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "third_variable:third variable" => array("a text of 12 or more" => [
                    "length" => ["<=", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "fourth_variable:fourth variable" => array("Placeholder..." => [
                    "not_placeholder" => ["", "Placeholder..."]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "fifth_variable:fifth variable" => array("element" => [
                    "in_array" => ["", "element..."]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "sixth_variable:sixth variable" => array("element..." => [
                    "unique" => ["", "element..."]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "seventh_variable:seventh variable" => array("is_same" => [
                    "is_same" => "not_is_same"
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "eigth_variable:eight variable" => array("not_is_same" => [
                    "not_is_same" => "not_is_same"
                ])
            ]);


            $incorrect_variables = $this->form_validator_descendant->GetIncorrectParameters();

            $this->assertTrue(isset($incorrect_variables["first_variable"]));
            $this->assertTrue(isset($incorrect_variables["second_variable"]));
            $this->assertTrue(isset($incorrect_variables["third_variable"]));
            $this->assertTrue(isset($incorrect_variables["fourth_variable"]));
            $this->assertTrue(isset($incorrect_variables["fifth_variable"]));
            $this->assertTrue(isset($incorrect_variables["sixth_variable"]));
            $this->assertTrue(isset($incorrect_variables["seventh_variable"]));
            $this->assertTrue(isset($incorrect_variables["eigth_variable"]));
        }

        /**
         * This method tests the ValidateInputs() method of the FormValidator class.
         * 
         * @test
         */
        public function ValidateInputsValidInputsTest() : void {
            $this->form_validator_descendant->CallValidateInputs([
                "first_variable:first variable" => array("" => [
                    "type" => "string"
                ])
            ]);
           

            $this->form_validator_descendant->CallValidateInputs([
                "second_variable:second variable" => array(12 => [
                    "type" => "numeric"
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "third_variable:third variable" => array("a text of 12" => [
                    "length" => ["<=", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "fourth_variable:fourth variable" => array("a text of 12"=> [
                    "length" => ["==", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "fifth_variable:fifth variable" => array("a text of 12" => [
                    "length" => ["=>", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "sixth_variable:sixth variable" => array("a text of 1" => [
                    "length" => ["<", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "seventh_variable:seventh variable" => array("a text of 12 or more" => [
                    "length" => [">", "12"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "eigth_variable:eight variable" => array("Placeholder.." => [
                    "not_placeholder" => ["", "Placeholder..."]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "nineth_variable:nineth variable" => array("element" => [
                    "in_array" => ["", "element...", "element"]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "tenth_variable:tenth variable" => array("element" => [
                    "unique" => ["", "element...", "element.."]
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "eleventh_variable:eleventh variable" => array("is_same" => [
                    "is_same" => "is_same"
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "twelveth_variable:twelveth variable" => array("not_is_same" => [
                    "not_is_same" => "is_same"
                ])
            ]);

            $this->form_validator_descendant->CallValidateInputs([
                "thirteenth_variable:thirteenth variable" => array("1234asd" => [
                    "preg_match" => ["/[0-9]/","/[a-zA-Z]/"]
                ])
            ]);

            $correct_variables = $this->form_validator_descendant->GetCorrectParameters();
            
            $this->assertTrue(isset($correct_variables["first_variable"]));
            $this->assertTrue(isset($correct_variables["second_variable"]));
            $this->assertTrue(isset($correct_variables["fourth_variable"]));
            $this->assertTrue(isset($correct_variables["fifth_variable"]));
            $this->assertTrue(isset($correct_variables["sixth_variable"]));
            $this->assertTrue(isset($correct_variables["seventh_variable"]));
            $this->assertTrue(isset($correct_variables["eigth_variable"]));
            $this->assertTrue(isset($correct_variables["nineth_variable"]));
            $this->assertTrue(isset($correct_variables["tenth_variable"]));
            $this->assertTrue(isset($correct_variables["eleventh_variable"]));
            $this->assertTrue(isset($correct_variables["twelveth_variable"]));
            $this->assertTrue(isset($correct_variables["thirteenth_variable"]));
        }

    }
?>