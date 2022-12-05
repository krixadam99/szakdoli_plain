<?php
    use phpDocumentor\Reflection\Types\Boolean;
    use PHPUnit\Framework\TestCase;
    require __DIR__ . "/../../src/services/dimatiHelperFunctions.class.php";

    class DimatiHelperFunctionsTest extends TestCase{
        private $dimati_helper;
        
        protected function setUp() : void {
            parent::setUp();

            $this->dimati_helper = new DimatiHelperFunctions();
        }
        
        /**
         * This method tests the GetPartOfSet() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetPartOfSet() : void {
            $test_set = [1,2,3];
            
            $set = $this->dimati_helper->GetPartOfSet([], 2);
            $this->assertEmpty($set);

            $set = $this->dimati_helper->GetPartOfSet($test_set, -1);
            $this->assertEmpty($set);

            $set = $this->dimati_helper->GetPartOfSet($test_set, 2.3);
            $this->assertEmpty($set);

            $set = $this->dimati_helper->GetPartOfSet($test_set, 2);
            $this->assertEquals(2, count($set));

            $set = $this->dimati_helper->GetPartOfSet($test_set, 4);
            $this->assertEquals($test_set, $set);
        }

        /**
         * This method tests the PickNewPairOfIndices() method of the DimatiHelperFunctions class.
         * 
         * 
         * @test
         */
        public function TestPickNewPairOfIndices() : void {
            $this->assertEquals([2,1], $this->dimati_helper->PickNewPairOfIndices([[0,1],[1,0],[0,2],[2,0],[1,2]], 3));
            $this->assertEquals(["",""], $this->dimati_helper->PickNewPairOfIndices([[0,1],[1,0],[0,2],[2,0],[1,2],[2,1]], 3));
        }

        /**
         * This method tests the PickNewElement() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestPickNewElement() : void {
            $this->assertEquals(2, $this->dimati_helper->PickNewElement([0,1], 3));
            $this->assertEquals("", $this->dimati_helper->PickNewElement([0,1,2], 3));
        }

        /**
         * This method tests the CreateDescartesProduct() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreateDescartesProduct() : void {
            $this->assertEquals([[0,0],[0,1],[1,0],[1,1]], $this->dimati_helper->CreateDescartesProduct([0,1], [0,1],5));
            $this->assertEquals(3, count($this->dimati_helper->CreateDescartesProduct([0,1],[0,1], 3)));
            
            $new_descartes_product = $this->dimati_helper->CreateDescartesProduct([0,1],[0,1], 1);
            $this->assertTrue(     in_array([0,1], $new_descartes_product) || in_array([1,0], $new_descartes_product)
                                || in_array([0,0], $new_descartes_product) || in_array([1,1], $new_descartes_product)
            );
        }

        /**
         * This method tests the CreateComplexNumbers() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreateComplexNumbers() : void {
            $original_maximum_number = $this->dimati_helper->GetMaximumNumber();
            $original_minimum_number = $this->dimati_helper->GetMinimumNumber();

            $this->dimati_helper->SetMaximumNumber(1);
            $this->dimati_helper->SetMinimumNumber(0);
            
            $this->assertEquals([[0,0],[0,1],[1,0],[1,1]], $this->dimati_helper->CreateComplexNumbers(4));
            $this->assertEquals([[0,0],[0,1],[1,0],[1,1]], $this->dimati_helper->CreateComplexNumbers(5));
            $this->assertEquals([], $this->dimati_helper->CreateComplexNumbers(-1));
            
            $new_complex_numbers = $this->dimati_helper->CreateComplexNumbers(1);
            $this->assertTrue(     in_array([0,1], $new_complex_numbers) || in_array([1,0], $new_complex_numbers)
                                || in_array([0,0], $new_complex_numbers) || in_array([1,1], $new_complex_numbers)
            );
           
            $this->dimati_helper->SetMaximumNumber($original_maximum_number);
            $this->dimati_helper->SetMinimumNumber($original_minimum_number); 
        }

        /**
         * This method tests the GetUniverse() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetUniverse() : void {            
            $this->assertEquals([], $this->dimati_helper->GetUniverse([]));

            $universe = $this->dimati_helper->GetUniverse(["a","c", 4, -1]);
            $this->assertEquals([], array_diff($universe, ["a","b","c",-1,0,1,2,3,4]));
        }

        /**
         * This method tests the GetRelationTwoArrayForm() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetRelationTwoArrayForm() : void {            
            $this->assertEquals([[],[]], $this->dimati_helper->GetRelationTwoArrayForm([[]]));
            $this->assertEqualsCanonicalizing([[1,2,1],[2,3,3]], $this->dimati_helper->GetRelationTwoArrayForm([[1,2],[2,3],[1,3]]));
        }

        /**
         * This method tests the GetImageBySet() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetImageBySet() : void {            
            $this->assertEquals([2,3], $this->dimati_helper->GetImageBySet([[1,2],[2,3]],[1,2]));
            $this->assertEquals([2], $this->dimati_helper->GetImageBySet([[1,2],[2,3]],[1,3]));
            $this->assertEquals([2,3], $this->dimati_helper->GetImageBySet([[1,2],[2,3]],[1,2,3]));
            $this->assertEquals([], $this->dimati_helper->GetImageBySet([],[1,2,3]));
        }

        /**
         * This method tests the GetDomainBySet() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetDomainBySet() : void {            
            $this->assertEquals([1,2], $this->dimati_helper->GetDomainBySet([[1,2],[2,3]],[2,3]));
            $this->assertEquals([2], $this->dimati_helper->GetDomainBySet([[1,2],[2,3]],[1,3]));
            $this->assertEquals([1,2], $this->dimati_helper->GetDomainBySet([[1,2],[2,3]],[1,2,3]));
            $this->assertEquals([], $this->dimati_helper->GetDomainBySet([],[1,2,3]));
        }

        /**
         * This method tests the GetDomainOfRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetDomainOfRelation() : void {            
            $this->assertEquals([], $this->dimati_helper->GetDomainOfRelation([]));
            $this->assertEquals([1,2], $this->dimati_helper->GetDomainOfRelation([[1,2],[2,3]]));
        }

        /**
         * This method tests the GetImageOfRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetImageOfRelation() : void {            
            $this->assertEquals([], $this->dimati_helper->GetImageOfRelation([]));
            $this->assertEquals([2,3], $this->dimati_helper->GetImageOfRelation([[1,2],[2,3]]));
        }

        /**
         * This method tests the GetRestrictedRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetRestrictedRelation() : void {            
            $this->assertEquals([], $this->dimati_helper->GetRestrictedRelation([],[]));
            $this->assertEquals([[1,2]], $this->dimati_helper->GetRestrictedRelation([[1,2],[2,3]], [1,3]));
            $this->assertEqualsCanonicalizing([[1,2],[2,3]], $this->dimati_helper->GetRestrictedRelation([[1,2],[2,3]], [1,2,3]));
        }

        /**
         * This method tests the GetInverseRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetInverseRelation() : void {            
            $this->assertEquals([], $this->dimati_helper->GetInverseRelation([]));
            $this->assertEqualsCanonicalizing([[2,1],[3,2]], $this->dimati_helper->GetInverseRelation([[1,2],[2,3]]));
        }

        /**
         * This method tests the CreateCompositionOfRelations() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestCreateCompositionOfRelations() : void {            
            $this->assertEquals([], $this->dimati_helper->CreateCompositionOfRelations([[1,2],[2,3]],[]));
            $this->assertEquals([], $this->dimati_helper->CreateCompositionOfRelations([],[[1,2],[2,3]]));
            $this->assertEquals([], $this->dimati_helper->CreateCompositionOfRelations([[4,5],[1,2]],[[1,2],[2,3]]));
            $this->assertEqualsCanonicalizing([[1,3],[2,4]], $this->dimati_helper->CreateCompositionOfRelations([[2,3],[3,4]],[[1,2],[2,3]]));
        }

        /**
         * This method tests the MakeRelationFromArrays() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestMakeRelationFromArrays() : void {            
            $this->assertEquals([[],[]], $this->dimati_helper->MakeRelationFromArrays([],[]));
            $this->assertEquals([[1],[1]], $this->dimati_helper->MakeRelationFromArrays([1,2],[1]));
            $this->assertEquals([[1,2],[1,2]], $this->dimati_helper->MakeRelationFromArrays([1,2],[1,2,3]));
        }

        /**
         * This method tests the GetCharacteristics() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetCharacteristics() : void {
            $this->assertContainsOnly("bool", array_values($this->dimati_helper->GetCharacteristics()));
        } 
        
        /**
         * This method tests the IsReflexiveRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsReflexiveRelation() : void {
            $this->assertTrue(!$this->dimati_helper->IsReflexiveRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsReflexiveRelation([], [[1,2]]));
            $this->assertTrue($this->dimati_helper->IsReflexiveRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsReflexiveRelation([1,2], [[1,1],[2,1]]));
        } 

        /**
         * This method tests the IsIrreflexiveRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsIrreflexiveRelation() : void {
            $this->assertTrue($this->dimati_helper->IsIrreflexiveRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsIrreflexiveRelation([], [[1,2]]));
            $this->assertTrue(!$this->dimati_helper->IsIrreflexiveRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue($this->dimati_helper->IsIrreflexiveRelation([1,2], [[1,2],[2,1]]));
        } 

        /**
         * This method tests the IsSymmetricRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsSymmetricRelation() : void {
            $this->assertTrue($this->dimati_helper->IsSymmetricRelation([1,2], []));
            $this->assertTrue(!$this->dimati_helper->IsSymmetricRelation([1,2], [[1,2]]));
            $this->assertTrue($this->dimati_helper->IsSymmetricRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue($this->dimati_helper->IsSymmetricRelation([1,2], [[1,2],[2,1]]));
        } 

        /**
         * This method tests the IsAntiSymmetricRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsAntiSymmetricRelation() : void {
            $this->assertTrue($this->dimati_helper->IsAntiSymmetricRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsAntiSymmetricRelation([1,2], [[1,2]]));
            $this->assertTrue($this->dimati_helper->IsAntiSymmetricRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsAntiSymmetricRelation([1,2], [[1,2],[2,1]]));
        } 

        /**
         * This method tests the IsAssymmetricRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsAssymmetricRelation() : void {
            $this->assertTrue($this->dimati_helper->IsAssymmetricRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsAssymmetricRelation([1,2], [[1,2]]));
            $this->assertTrue(!$this->dimati_helper->IsAssymmetricRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsAssymmetricRelation([1,2], [[1,2],[2,1]]));
        } 

        /**
         * This method tests the IsTransitiveRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsTransitiveRelation() : void {
            $this->assertTrue($this->dimati_helper->IsTransitiveRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsTransitiveRelation([1,2], [[1,2]]));
            $this->assertTrue($this->dimati_helper->IsTransitiveRelation([1,2,3], [[1,1],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsTransitiveRelation([1,2,3], [[1,2],[2,3]]));
            $this->assertTrue($this->dimati_helper->IsTransitiveRelation([1,2,3], [[1,2],[2,3],[1,3]]));
        } 

        /**
         * This method tests the IsDichotomousRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsDichotomousRelation() : void {
            $this->assertTrue(!$this->dimati_helper->IsDichotomousRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsDichotomousRelation([1,2], [[1,1],[1,2],[2,2]]));
            $this->assertTrue($this->dimati_helper->IsDichotomousRelation([1,2], [[1,2],[2,1]]));
            $this->assertTrue(!$this->dimati_helper->IsDichotomousRelation([1,2,3], [[1,2],[2,1],[1,1],[2,2]]));
        } 

        /**
         * This method tests the IsTrichotomousRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsTrichotomousRelation() : void {
            $this->assertTrue(!$this->dimati_helper->IsTrichotomousRelation([1,2], []));
            $this->assertTrue($this->dimati_helper->IsTrichotomousRelation([1,2], [[1,1],[1,2],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsTrichotomousRelation([1,2], [[1,2],[2,1]]));
            $this->assertTrue($this->dimati_helper->IsTrichotomousRelation([1,2], [[1,2],[1,1]]));
        } 

        /**
         * This method tests the IsEquivalenceRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsEquivalenceRelation() : void {
            $this->assertTrue($this->dimati_helper->IsEquivalenceRelation([], []));
            $this->assertTrue(!$this->dimati_helper->IsEquivalenceRelation([1,2], [[1,2]]));
            $this->assertTrue($this->dimati_helper->IsEquivalenceRelation([1,2], [[1,1],[2,2]]));
        } 

        /**
         * This method tests the IsPartlyOrderedRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsPartlyOrderedRelation() : void {
            $this->assertTrue($this->dimati_helper->IsPartlyOrderedRelation([], []));
            $this->assertTrue($this->dimati_helper->IsPartlyOrderedRelation([1,2], [[1,1],[2,2],[1,2]]));
            $this->assertTrue($this->dimati_helper->IsPartlyOrderedRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsPartlyOrderedRelation([1,2,3], [[1,1],[2,2],[3,3],[1,2],[2,3]]));
        } 

        /**
         * This method tests the IsStrictlyPartlyOrderedRelation() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsStrictlyPartlyOrderedRelation() : void {
            $this->assertTrue($this->dimati_helper->IsStrictlyPartlyOrderedRelation([], []));
            $this->assertTrue(!$this->dimati_helper->IsStrictlyPartlyOrderedRelation([1,2], [[1,1],[2,2],[1,2]]));
            $this->assertTrue(!$this->dimati_helper->IsStrictlyPartlyOrderedRelation([1,2], [[1,1],[2,2]]));
            $this->assertTrue($this->dimati_helper->IsStrictlyPartlyOrderedRelation([1,2], [[1,2]]));
            $this->assertTrue(!$this->dimati_helper->IsStrictlyPartlyOrderedRelation([1,2,3], [[1,1],[2,2],[3,3],[1,2],[2,3]]));
        } 

        /**
         * This method tests the MakeFunction() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestMakeFunction() : void {
            $this->assertEquals([], $this->dimati_helper->MakeFunction([], [], 2));
            
            $function = $this->dimati_helper->MakeFunction([1,2], [3,4], 1);
            $this->assertTrue(in_array([1,3], $function) || in_array([1,4], $function) || in_array([2,3], $function) || in_array([2,4], $function));
            $this->assertEquals(1, count($function));

            $function = $this->dimati_helper->MakeFunction([1,2], [3,4], 2);
            $this->assertTrue(
                        in_array([1,3], $function) && in_array([2,3], $function) || in_array([2,4], $function)
                    ||  in_array([1,4], $function) && in_array([2,3], $function) || in_array([2,4], $function)
            );

            $function = $this->dimati_helper->MakeFunction([1,2], [3,4], 3);
            $this->assertEquals(2, count($function));
        } 

        
        /**
         * This method tests the IsSurjective() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsSurjective() : void {
            $this->assertTrue(!$this->dimati_helper->IsSurjective([[1,2],[2,3]], [1,2,3]));
            $this->assertTrue($this->dimati_helper->IsSurjective([[1,2],[2,3]], [2,3]));
            $this->assertTrue(!$this->dimati_helper->IsFunction([[1,2],[1,3]], []));
            $this->assertTrue($this->dimati_helper->IsFunction([[1,2],[2,3]], []));
        } 

        /**
         * This method tests the IsInjective() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsInjective() : void {
            $this->assertTrue($this->dimati_helper->IsInjective([[1,2],[2,3]]));
            $this->assertTrue(!$this->dimati_helper->IsInjective([[1,2],[2,2]]));
            $this->assertTrue(!$this->dimati_helper->IsInjective([[1,2],[1,3]]));
        } 

        /**
         * This method tests the IsBijective() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsBijective() : void {
            $this->assertTrue($this->dimati_helper->IsBijective([[1,2],[2,3]], [2,3]));
            $this->assertTrue(!$this->dimati_helper->IsBijective([[1,2],[2,3]], [1,2,3]));
            $this->assertTrue(!$this->dimati_helper->IsBijective([[1,2],[2,2]], [2,3]));
            $this->assertTrue(!$this->dimati_helper->IsBijective([[1,2],[1,3]], [2,3]));
        } 

        /**
         * This method tests the GetAllPossibleRelations() method of the DimatiHelperFunctions class.
         * @test
         */
        public function TestGetAllPossibleRelations() : void {
            $this->assertEquals([[]],$this->dimati_helper->GetAllPossibleRelations([]));
            
            /*
            $all_relations = $this->dimati_helper->GetAllPossibleRelations([1,2]);
            $expected = [ [],
                        [[1,1],[1,2],[2,1],[2,2]],
                        [[1,1]],[[1,2]],[[2,1]],[[2,2]],
                        [[1,1],[1,2]],[[1,1],[2,1]],[[1,1],[2,2]],[[1,2],[2,1]],[[1,2],[2,2]],[[2,1],[2,2]],
                        [[1,1],[1,2],[2,1]],[[1,1],[1,2],[2,2]],[[1,1],[2,2],[2,1]],[[1,2],[2,1],[2,2]],
            ];
            foreach($all_relations as $relation_counter => $relation){
                $found = false;
                foreach($expected as $expected_relations){
                    if(count(array_diff($relation, $expected_relations)) === 0){
                        $found = true;
                        break;
                    }
                }
                $this->assertTrue($found);
            }
            */
        } 

        /**
         * This method tests the IsFunction() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestIsFunction() : void {
            $this->assertTrue($this->dimati_helper->IsFunction([[1,2],[2,3]]));
            $this->assertTrue($this->dimati_helper->IsFunction([]));
            $this->assertTrue(!$this->dimati_helper->IsFunction([[1,2],[1,3]]));
        } 

        /**
         * This method tests the GetTrigonometricForm() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetTrigonometricForm() : void {
            $this->assertEquals([5,0.93], $this->dimati_helper->GetTrigonometricForm([3,4]));
            $this->assertEquals([4,1.57], $this->dimati_helper->GetTrigonometricForm([0,4]));
        }      

        /**
         * This method tests the GetBinomialTheorem() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestGetBinomialTheorem() : void {
            $this->assertEqualsCanonicalizing([], $this->dimati_helper->GetBinomialTheorem([2,3],[3,4,-1],true));
            $this->assertEqualsCanonicalizing([[9,8], [12,7], [4,6]], $this->dimati_helper->GetBinomialTheorem([2,3],[3,4,2],true));
            $this->assertEqualsCanonicalizing([[9,0,8], [12,3,4], [4,6,0]], $this->dimati_helper->GetBinomialTheorem([2,3],[3,4,2],false));
        }

        /**
         * This method tests the DetermineCombinationOfList() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineCombinationOfList() : void {
            $this->assertEquals([[]], $this->dimati_helper->DetermineCombinationOfList([]));
            $this->assertEquals([[1,2,3]], $this->dimati_helper->DetermineCombinationOfList([1,2,3],4));
            
            $this->assertEquals([], $this->dimati_helper->DetermineCombinationOfList([], -1));
            $this->assertEquals([], $this->dimati_helper->DetermineCombinationOfList([], 0));

            $this->assertEquals([[1,2],[1,3],[2,3]], $this->dimati_helper->DetermineCombinationOfList([1,2,3],2));
        }

        /**
         * This method tests the DetermineIfSimpleGraphCanBeCreated() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineIfSimpleGraphCanBeCreated() : void {
            $this->assertFalse($this->dimati_helper->DetermineIfSimpleGraphCanBeCreated([0,1,2,3,4,5]));
            $this->assertTrue($this->dimati_helper->DetermineIfSimpleGraphCanBeCreated([1,1,1,1,1,1]));
        }

        /**
         * This method tests the DetermineIfTreeGraphCanBeCreated() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineIfTreeGraphCanBeCreated() : void {
            $this->assertFalse($this->dimati_helper->DetermineIfTreeGraphCanBeCreated([1,2,3,4]));
            $this->assertTrue($this->dimati_helper->DetermineIfTreeGraphCanBeCreated([1,2,2,2,2,1]));
        }

        /**
         * This method tests the DetermineIfPairedGraphCanBeCreated() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineIfPairedGraphCanBeCreated() : void {
            $this->assertFalse($this->dimati_helper->DetermineIfPairedGraphCanBeCreated([[1,1,6,6], [1,1,1,2,3,3,3]]));
            $this->assertTrue($this->dimati_helper->DetermineIfPairedGraphCanBeCreated([[1,2,2],[3,2,0]]));
        }

        /**
         * This method tests the DetermineIfDirectedGraphCanBeCreated() method of the DimatiHelperFunctions class.
         * 
         * @test
         */
        public function TestDetermineIfDirectedGraphCanBeCreated() : void {
            $this->assertFalse($this->dimati_helper->DetermineIfDirectedGraphCanBeCreated([[1,1,1,3,4,4],[5,5,1,1,1,1]]));
            $this->assertTrue($this->dimati_helper->DetermineIfDirectedGraphCanBeCreated([[1,2,1,1,2,0],[0,2,1,1,0,3]]));
        }
    }

?>