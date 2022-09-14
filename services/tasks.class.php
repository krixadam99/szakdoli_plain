<?php
    /**
     * This is an abstract class, which represents tasks.
     * 
     * A task will contain the task description, the solutions for the subtasks and the definitions related to the tasks. 
    */
    abstract class Tasks {
        protected $task_description;
        protected $task_solution;
        protected $definitions;

        /**
         * 
         * This method returns the task description.
         * 
         * @return array An associative array containing the task parameters.
        */
        public function GetTaskDescription(){ return $this->task_description; }

        /**
         * 
         * This method returns the task solutions.
         * 
         * @return array An associative array containing the tasks' solutions.
        */
        public function GetTaskSolution(){ return $this->task_solution; }

        /**
         * 
         * This method returns the definitions related to the tasks.
         * 
         * @return string A string of the topic related definitions. 
        */
        public function GetDefinitions(){ return $this->definitions; }

        /**
         * 
         * This method assigns a new value to the class's $task_description variable.
         * 
         * @param array $task_description The task description which will be assigned to the class's $task_description member.
         * 
         * @return void
        */
        public function SetTaskDescription($task_description){ $this->task_description = $task_description; }
        
        /**
         * 
         * This method assigns a new value to the class's $task_solutions variable.
         * 
         * @param array $task_solutions The task description which will be assigned to the class's $task_solutions member.
         * 
         * @return void
        */
        public function SetTaskSolution($task_solutions){ $this->task_solution = $task_solutions; }

        /**
         * 
         * This method assigns a new value to the class's $definitions variable.
         * 
         * @param array $definitions The task description which will be assigned to the class's $definitions member.
         * 
         * @return void
        */
        public function SetDefinitions($definitions){ $this->definitions = $definitions; }
    }

?>