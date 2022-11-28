<?php

    require __DIR__ . "/../../src/lib/FormValidator.php";

    use phpDocumentor\Reflection\Types\Boolean;
    use PHPUnit\Framework\TestCase;

    use function PHPUnit\Framework\assertTrue;

    class FormValidatorTest extends TestCase{
        private $form_validator_child;
        
        protected function setUp() : void {
            parent::setUp();
            $this->form_validator_child = new class extends FormValidator {
            };
        }
        
        /**
         * This method tests the ValidateInputs() method of the FormValidator class.
         * 
         * @test
         */
        public function TestValidateInputs() : void { 
            
            /*$this->form_validator_child->ValidateInputs([
                "key:key_attr" => array(2 => [
                    "type" => "string"
                ])
            ]);
            $this->assertTrue(isset($this->form_validator_child->incorrect_parameters["key"]));*/
        }
    }

?>