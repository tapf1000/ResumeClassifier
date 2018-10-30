<?php
class Classify{
	protected $n;
	public function __construct(){
		require_once ("class_neuralnetwork.php");
		 $n= new NeuralNetwork(3, 4, 1);
		$n->setVerbose(false);
		$this->n = $n;
	}
		public function calc($arr){
			$n = $this->n;
			
			$n->addTestData(array (0,0,0,0), array (0/15));
			$n->addTestData(array (0,0,0,1), array ( 1/15));
			$n->addTestData(array (0,0,1,0), array ( 2/15));
			$n->addTestData(array (0,0,1,1), array (3/15));
			$n->addTestData(array (0,1,0,0), array (4/15));
			$n->addTestData(array (0,1,0,1), array (5/15));
			$n->addTestData(array (0,1,1,0), array (6/15));
			$n->addTestData(array (0,1,1,1), array (7/15));
			$n->addTestData(array (1,0,0,0), array (8/15));
			$n->addTestData(array (1,0,0,1), array (9/15));
			$n->addTestData(array (1,0,1,0), array (10/15));
			$n->addTestData(array (1,0,1,1), array (11/15));
			$n->addTestData(array (1,1,0,0), array (12/15));
			$n->addTestData(array (1,1,0,1), array (13/15));
			$n->addTestData(array (1,1,1,0), array (14/15));
			$n->addTestData(array (1,1,1,1), array (15/15));
			$max = 3;
			$i = 0;
			while (!($success = $n->train(10000, 0.001)) && ++$i<$max) {}	
			$output = $n->calculate($arr);
			return $output[0];
		}
}
?>
