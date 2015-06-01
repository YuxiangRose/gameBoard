<?php

	class Player {
		private $name = NULL;
		private $point = NULL;
		

		/**
		*  Constructor
		*  @param resource $name
		*  @param resource $point
		*  @return void
		*/
		public function __construct($name, $point)
		{
			$this->name = $name;
			$this->point = $point;
		}

		/**
		* Getter for $name
		* @return mixed
		*/
		public function getName(){
			return $this->name;
		}

		/**
		* Getter for $point
		* @return mixed
		*/
		public function getPoint(){
			return $this->point;
		}

		/**
		* Setter for $name
		*
		* @param $name nalue to set
		* @return void
		*/
		public function setName($name){
			$this->name = $name;
		}

		/**
		* Setter for $point
		*
		* @param mixed $point value to set
		* @return void
		*/
		public function setPoint($point){
			$this->point = $point;
		} 
	}
?>