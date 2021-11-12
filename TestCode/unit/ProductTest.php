<?php

use phpDocumentor\Reflection\PseudoTypes\True_;

class ProductTest extends \PHPUnit\Framework\TestCase{
    
	protected $product ;

	public function setUp():void
	{
		$this->product = new \App\Models\Product;
	}

    public function test_add_product()
	{
		

		$this->product -> setName('keyboard');
		$this -> assertEquals($this->product->getName(),'keyboard');

		$this->product->setCode('k100',TRUE);
		$this->assertEquals($this->product->getCode(), 'k100');

		$this->product->setQuantity('100');
		$this->assertEquals($this->product->getQuantity(), '100');
		$this->product->setPrice('4000');
		$this->assertEquals($this->product->getPrice(), '4000');
	
	$this->assertEquals($this->product->add_product(), TRUE);
	}


	
	
	
}
?>