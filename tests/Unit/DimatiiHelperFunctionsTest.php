<?php

    require __DIR__ . "/../../src/services/dimatiiHelperFunctions.class.php";

    use phpDocumentor\Reflection\Types\Boolean;
    use PHPUnit\Framework\TestCase;

    use function PHPUnit\Framework\assertTrue;

    class DimatiiHelperFunctionsTest extends TestCase{
        private $dimatii_helper;
        
        protected function setUp() : void {
            parent::setUp();
            $this->dimatii_helper = new DimatiiHelperFunctions();
        }
        
        /**
         * This method tests the CreateDistinctNumbers() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreateDistinctNumbers() : void {    
            $distinct_numbers = $this->dimatii_helper->CreateDistinctNumbers(5,0,10);
            $numbers = [];
            foreach($distinct_numbers as $distinct_number){
                $this->assertTrue($distinct_number <= 10 && $distinct_number >= 0 && !in_array($distinct_number,$numbers));
                array_push($numbers,$distinct_number);
            }

            $distinct_numbers = $this->dimatii_helper->CreateDistinctNumbers(5,0,10);
            $numbers = [];
            foreach($distinct_numbers as $distinct_number){
                $this->assertTrue($distinct_number <= 10 && $distinct_number >= 0 && !in_array($distinct_number,$numbers));
                array_push($numbers,$distinct_number);
            }

            $distinct_numbers = $this->dimatii_helper->CreateDistinctNumbers(6,0,5);
            $this->assertEqualsCanonicalizing([0,1,2,3,4,5],$distinct_numbers);
        }

        /**
         * This method tests the CreateTripletsOfNumbersWithoutZero() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreateTripletsOfNumbersWithoutZero() : void {    
            $triplets = $this->dimatii_helper->CreateTripletsOfNumbersWithoutZero(4,-1,1);
            foreach($triplets as $triplet){
                $this->assertTrue(in_array($triplet,[[-1,-1,1],[-1,1,1],[1,-1,1],[1,1,1]]));
            }

            $triplets = $this->dimatii_helper->CreateTripletsOfNumbersWithoutZero(100,-1,1);
            foreach($triplets as $triplet){
                $this->assertTrue(in_array($triplet,[[-1,-1,1],[-1,1,1],[1,-1,1],[1,1,1]]));
            }

            $this->assertEquals([],$this->dimatii_helper->CreateTripletsOfNumbersWithoutZero(-1,-1,1));
            $this->assertEquals([[1,1,1]],$this->dimatii_helper->CreateTripletsOfNumbersWithoutZero(1,1,1));
        }

        /**
         * This method tests the CreatePolynomialExpression() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreatePolynomialExpression() : void {    
            [$coefficients, $roots] = $this->dimatii_helper->CreatePolynomialExpression(4,-1,1);
            foreach($roots as $root){
                $this->assertTrue($root >= -1 && $root <= 1);
            }
            $this->assertEquals(5,count($coefficients));

            [$coefficients, $roots] = $this->dimatii_helper->CreatePolynomialExpression(4,1,1);
            $this->assertEquals(4,count($roots));
            $this->assertEquals(5,count($coefficients));
        }

        
        /**
         * This method tests the CreatePlacesWithRoots() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreatePlacesWithRoots() : void {    
            $places = $this->dimatii_helper->CreatePlacesWithRoots(3,3,[1,2,3],-1,1);
            foreach($places as $place){
                $this->assertTrue(in_array($place,[1,2,3]));
            }

            $places = $this->dimatii_helper->CreatePlacesWithRoots(3,2,[1,2,3],5,7);
            foreach($places as $place){
                $this->assertTrue(in_array($place,[1,2,3]) || in_array($place,[5,6,7]));
            }

            $places = $this->dimatii_helper->CreatePlacesWithRoots(3,0,[1,2,3],5,7);
            foreach($places as $place){
                $this->assertTrue(in_array($place,[5,6,7]));
            }
        }

        /**
         * This method tests the DetermineQuotientAndResidue() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineQuotientAndResidue() : void {    
            $this->assertEqualsCanonicalizing([[-4,2]], $this->dimatii_helper->DetermineQuotientAndResidue([[-10,3]]));
            $this->assertEqualsCanonicalizing([[4,2]], $this->dimatii_helper->DetermineQuotientAndResidue([[-10,-3]]));
            $this->assertEqualsCanonicalizing([[-3,1]], $this->dimatii_helper->DetermineQuotientAndResidue([[10,-3]]));
            $this->assertEqualsCanonicalizing([[3,1]], $this->dimatii_helper->DetermineQuotientAndResidue([[10,3]]));
            $this->assertEqualsCanonicalizing([[10,0]], $this->dimatii_helper->DetermineQuotientAndResidue([[10,0]]));
        }

        /**
         * This method tests the DeterminePrimeFactorization() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDeterminePrimeFactorization() : void {    
            $this->assertEqualsCanonicalizing([[]], $this->dimatii_helper->DeterminePrimeFactorization([0]));

            $this->assertEqualsCanonicalizing([[[5,1]]], $this->dimatii_helper->DeterminePrimeFactorization([5]));
            $this->assertEqualsCanonicalizing([[[2,2],[3,1]]], $this->dimatii_helper->DeterminePrimeFactorization([12]));
            $this->assertEqualsCanonicalizing([[[3,2]]], $this->dimatii_helper->DeterminePrimeFactorization([-9]));
        }

        /**
         * This method tests the DetermineNumberOfDivisors() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineNumberOfDivisors() : void {    
            $this->assertEqualsCanonicalizing([3], $this->dimatii_helper->DetermineNumberOfDivisors([-4]));
            $this->assertEqualsCanonicalizing([2], $this->dimatii_helper->DetermineNumberOfDivisors([5]));
            $this->assertEqualsCanonicalizing([6], $this->dimatii_helper->DetermineNumberOfDivisors([12]));
        }

        /**
         * This method tests the DetermineCompleteResidueSystem() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineCompleteResidueSystem() : void {    
            $this->assertEqualsCanonicalizing([0,1,2,3], $this->dimatii_helper->DetermineCompleteResidueSystem(4));
            $this->assertEqualsCanonicalizing([], $this->dimatii_helper->DetermineCompleteResidueSystem(0));
        }

        /**
         * This method tests the DetermineReducedResidueSystem() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineReducedResidueSystem() : void {    
            $this->assertEqualsCanonicalizing([1,3], $this->dimatii_helper->DetermineReducedResidueSystem(4));
            $this->assertEqualsCanonicalizing([], $this->dimatii_helper->DetermineReducedResidueSystem(0));
        }

        /**
         * This method tests the DetermineEulerPhiValue() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineEulerPhiValue() : void {    
            $this->assertEqualsCanonicalizing(2, $this->dimatii_helper->DetermineEulerPhiValue(4)["solution"]);
            $this->assertEqualsCanonicalizing(0, $this->dimatii_helper->DetermineEulerPhiValue(0)["solution"]);
            $this->assertEqualsCanonicalizing(4, $this->dimatii_helper->DetermineEulerPhiValue(10)["solution"]);
        }

        /**
         * This method tests the DetermineGCDWithEuclidean() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineGCDWithEuclidean() : void {    
            $eucliden_algorithm = $this->dimatii_helper->DetermineGCDWithEuclidean([9,12]);
            $this->assertEquals(3, $eucliden_algorithm["solution"]);
            $this->assertEquals(2, count($eucliden_algorithm["steps"]));

            $eucliden_algorithm = $this->dimatii_helper->DetermineGCDWithEuclidean([-9,12]);
            $this->assertEquals(3, $eucliden_algorithm["solution"]);
            $this->assertEquals(2, count($eucliden_algorithm["steps"]));

            
            $eucliden_algorithm = $this->dimatii_helper->DetermineGCDWithEuclidean([-9,-12]);
            $this->assertEquals(3, $eucliden_algorithm["solution"]);
            $this->assertEquals(2, count($eucliden_algorithm["steps"]));

            $eucliden_algorithm = $this->dimatii_helper->DetermineGCDWithEuclidean([18,109]);
            $this->assertEquals(1, $eucliden_algorithm["solution"]);
            $this->assertEquals(2, count($eucliden_algorithm["steps"]));
        }

        /**
         * This method tests the DetermineLinearCongruenceSolutionSmart() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineLinearCongruenceSolutionSmart() : void {    
            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([1,3,4]);
            $this->assertEquals([1,3,4], $linear_congruence["solution"]);
            $this->assertEquals(0, count($linear_congruence["steps"]));

            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([-1,3,4]);
            $this->assertEquals([1,1,4], $linear_congruence["solution"]);
            $this->assertEquals(2, count($linear_congruence["steps"]));

            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([4,3,4]);
            $this->assertEquals("NINCSEN", $linear_congruence["solution"]);
            $this->assertEquals(0, count($linear_congruence["steps"]));

            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([0,3,4]);
            $this->assertEquals("NINCSEN", $linear_congruence["solution"]);
            $this->assertEquals(0, count($linear_congruence["steps"]));

            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([0,0,4]);
            $this->assertEquals([0,0,4], $linear_congruence["solution"]);
            $this->assertEquals(0, count($linear_congruence["steps"]));

            $linear_congruence = $this->dimatii_helper->DetermineLinearCongruenceSolutionSmart([4,0,4]);
            $this->assertEquals([1,0,1], $linear_congruence["solution"]);
            $this->assertEquals(1, count($linear_congruence["steps"]));
        }

        /**
         * This method tests the DetermineDiophantineEquationSolution() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineDiophantineEquationSolution() : void {    
            $linear_congruence = $this->dimatii_helper->DetermineDiophantineEquationSolution([1,3,4]); 
            
            // 1x + 3y = 4 -> x \equiv 1 (mod 3) -> x = 3k + 1
            // y = (4 - x)/3 -> y = (4 - 3k - 1)/3 -> y = 1 - k
            $this->assertEquals([1,1,3], $linear_congruence["solution"][0]);
            $this->assertEquals([1,-1], $linear_congruence["solution"][1]);

            $linear_congruence = $this->dimatii_helper->DetermineDiophantineEquationSolution([6,3,4]); 
            $this->assertEquals(array("NINCSEN"), $linear_congruence["solution"][0]);
        }

        /**
         * This method tests the DetermineLinearCongruenceSystemSolution() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineLinearCongruenceSystemSolution() : void {    
            $crt = $this->dimatii_helper->DetermineLinearCongruenceSystemSolution([[1,3,4]]); 
            $this->assertEquals([1,3,4], $crt["solution"]);

            $crt = $this->dimatii_helper->DetermineLinearCongruenceSystemSolution([[1,3,4], [1,3,5]]); //4k + 3, 5l + 3
            $this->assertEquals([1,3,20], $crt["solution"]);
        }

        /**
         * This method tests the DetermineHornerSchemes() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineHornerSchemes() : void {    
            $horner_scheme = $this->dimatii_helper->DetermineHornerSchemes([1,3,4], [1,2]); 
            $this->assertEquals([[1,4,8],[1,5,14]], $horner_scheme);
        }

        /**
         * This method tests the DividePolynomialExpressions() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDividePolynomialExpressions() : void {    
            $division = $this->dimatii_helper->DividePolynomialExpressions([3,3,3], [1,2]); 
            $this->assertEquals([[[3,1],[-3,0]],[[9,0]]], $division["solution"]);

            $division = $this->dimatii_helper->DividePolynomialExpressions([3,3,3], [2]); 
            $this->assertEquals([[[1.5,2],[1.5,1],[1.5,0]],[]], $division["solution"]);

            $division = $this->dimatii_helper->DividePolynomialExpressions([3,3,3], [1,0,0]); 
            $this->assertEquals([[[3,0]],[[3,1],[3,0]]], $division["solution"]);
        }

        /**
         * This method tests the MultiplyPolynomialExpressions() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestMultiplyPolynomialExpressions() : void {    
            $multiplication = $this->dimatii_helper->MultiplyPolynomialExpressions([3,3], [1,0,3], 6); //(3x+3)*(x^2+ 0x +3)=3x^3+9x+3x^2+9            
            $this->assertEquals([[3,3],[3,2],[9,1],[9,0]], $multiplication["before_modulo"]);
            $this->assertEquals([[3,3],[3,2],[3,1],[3,0]], $multiplication["product"]);

            $multiplication = $this->dimatii_helper->MultiplyPolynomialExpressions([3,3], [0], 6);          
            $this->assertEquals([[0,1],[0,0]], $multiplication["before_modulo"]);
            $this->assertEquals([[0,1],[0,0]], $multiplication["product"]);
        }

        /**
         * This method tests the DetermineLagrangeInterpolation() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineLagrangeInterpolation() : void {    
            $lagrange = $this->dimatii_helper->DetermineLagrangeInterpolation([[1,2],[2,3]]); 
            $this->assertEquals([[1,1],[1,0]], $lagrange["polynomial_expression"]);

            $lagrange = $this->dimatii_helper->DetermineLagrangeInterpolation([[2,1],[0,-3],[-2,1]]); 
            $this->assertEquals([[1,2],[0,1],[-3,0]], $lagrange["polynomial_expression"]);
        }

        /**
         * This method tests the DetermineNewtonInterpolation() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineNewtonInterpolation() : void {    
            $lagrange = $this->dimatii_helper->DetermineNewtonInterpolation([[1,2],[2,3]]); 
            $this->assertEquals([[1,1],[1,0]], $lagrange["polynomial_expression"]);

            $lagrange = $this->dimatii_helper->DetermineNewtonInterpolation([[2,1],[0,-3],[-2,1]]); 
            $this->assertEquals([[1,2],[0,1],[-3,0]], $lagrange["polynomial_expression"]);
        }

        /**
         * This method tests the DetermineGCDWithIteration() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineGCDWithIteration() : void {    
            $this->assertEquals(3,$this->dimatii_helper->DetermineGCDWithIteration([9,12]));
            $this->assertEquals(3,$this->dimatii_helper->DetermineGCDWithIteration([-9,12]));
            $this->assertEquals(0,$this->dimatii_helper->DetermineGCDWithIteration([9,0]));
        }

        /**
         * This method tests the IsPrime() method of the DimatiiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsPrime() : void {    
            $this->assertTrue(!$this->dimatii_helper->IsPrime(1));
            $this->assertTrue($this->dimatii_helper->IsPrime(2));
            $this->assertTrue($this->dimatii_helper->IsPrime(3));
            $this->assertTrue(!$this->dimatii_helper->IsPrime(4));
            $this->assertTrue($this->dimatii_helper->IsPrime(5));
        }

    }

?>