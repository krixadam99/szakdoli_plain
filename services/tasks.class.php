<?php

    abstract class Tasks {
        private $task_description;
        private $task_solution;
        private $definitions;

        public function GetTaskDescription(){ return $this->task_description; }
        public function GetTaskSolution(){ return $this->task_solution; }
        public function GetDefinitions(){ return $this->definitions; }

        public function SetTaskDescription($task_description){ $this->task_description = $task_description; }
        public function SetTaskSolution($task_solutions){ $this->task_solution = $task_solutions; }
        public function SetDefinitions($definitions){ $this->definitions = $definitions; }
    }

?>