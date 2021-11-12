<?php

use phpDocumentor\Reflection\PseudoTypes\True_;

class UserTest extends \PHPUnit\Framework\TestCase{
    
	protected $user ;

	public function setUp():void
	{
		$this->user = new \App\Models\User;
	}

    public function test_login_system()
	{
		

		$this->user -> setName('Sabbir');
		$this -> assertEquals($this->user->getName(),'Sabbir');

		$this->user->setEmail('abcd@gmail.com',TRUE);
		$this->assertEquals($this->user->getEmail(), 'abcd@gmail.com');

		$this->assertEquals($this->user->setPassword('abcd1234'), TRUE);
		$this->assertEquals($this->user->getPassword(), 'abcd1234');
	
	$this->assertEquals($this->user->login('smith@gmail.com', '123456'), FALSE);
		$this->assertEquals($this->user->login('abcd@gmail.com', 'abcd1234'), TRUE);
	}

    public function test_registration_system()
	{
		

		$this->user -> setName('Sabbir');
		$this -> assertEquals($this->user->getName(),'Sabbir');

		$this->user->setEmail('abcd@gmail.com',TRUE);

		$this->assertEquals($this->user->getEmail(), 'abcd@gmail.com');
		$this->assertEquals($this->user->register(),FALSE);
		$this->assertEquals($this->user->setPassword('abcd1234'), TRUE);

		$this->assertEquals($this->user->getPassword(), 'abcd1234');

		$this->assertEquals($this->user->register(), TRUE);	
	}
	
	
	
}
?>