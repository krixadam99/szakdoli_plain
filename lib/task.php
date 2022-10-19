<?php
    /**
     * This is an abstract class, which represents a task.
     * 
     * A task will contain the task description, the solutions for the subtasks and the definitions related to the tasks. 
     * 
     * @property $alma
    */
    abstract class Task {
        protected $task_descriptions;
        protected $task_solutions;
        protected $solution_texts;
        protected $definitions;
        protected $topic;

        /**
         * 
         * This method returns the task description.
         * 
         * @return array An associative array containing the task parameters.
        */
        public function GetTaskDescriptions(){ return $this->task_descriptions; }

        /**
         * 
         * This method returns the task solutions.
         * 
         * @return array An associative array containing the tasks' solutions.
        */
        public function GetTaskSolutions(){ return $this->task_solutions; }

        /**
         * 
         * This method returns the definitions related to the tasks.
         * 
         * @return array An arra of strings of the topic related definitions. 
        */
        public function GetDefinitions(){ return $this->definitions; }

        /**
         * 
         * This method returns the solution texts related to the tasks.
         * 
         * @return array An array of strings of the topic related solution texts. 
        */
        public function GetSolutionTexts(){ return $this->solution_texts; }

        /**
         * 
         * This method returns the topic of the tasks.
         * 
         * @return string Returns the topic's string. 
        */
        public function GetTopic(){ return $this->topic; }

        /**
         * 
         * This method assigns a new value to the class's $task_description variable.
         * 
         * @param array $task_description The task description which will be assigned to the class's $task_description member.
         * 
         * @return void
        */
        public function SetTaskDescriptions($task_descriptions){ $this->task_descriptions = $task_descriptions; }
        
        /**
         * 
         * This method assigns a new value to the class's $task_solutions variable.
         * 
         * @param array $task_solutions The task description which will be assigned to the class's $task_solutions member.
         * 
         * @return void
        */
        public function SetTaskSolutions($task_solutions){ $this->task_solutions = $task_solutions; }

        /**
         * 
         * This method assigns a new value to the class's $definitions variable.
         * 
         * @param array $definitions The task description which will be assigned to the class's $definitions member.
         * 
         * @return void
        */
        public function SetDefinitions($definitions){ $this->definitions = $definitions; }

        /**
         * 
         * This method assigns a new value to the class's $topic variable.
         * 
         * @param string $topic The topic of the tasks which will be assigned to the class's $topic member.
         * 
         * @return void
        */
        public function SetTopic($topic){ $this->definitions = $topic; }

        /**
         * 
         * This method assigns a new value to the class's $solution_texts variable.
         * 
         * @param array $solution_texts The solution texts of the tasks which will be assigned to the class's $solution_texts member.
         * 
         * @return void
        */
        public function SetSolutionTexts($solution_texts){ $this->solution_texts = $solution_texts; }
    }

?>