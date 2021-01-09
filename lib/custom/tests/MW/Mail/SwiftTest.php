<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\MW\Mail;


class SwiftTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( class_exists( '\Swift_Message' ) === false ) {
			$this->markTestSkipped( 'Class Swift_Message not found' );
		}

		$transport = new \Swift_Transport_NullTransport( new \Swift_Events_SimpleEventDispatcher() );

		$this->mock = $this->getMockBuilder( 'Swift_Mailer' )->setConstructorArgs( array( $transport ) )->getMock();
		$this->object = new \Aimeos\MW\Mail\Swift( $this->mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testClosure()
	{
		$mock = $this->mock;
		$object = new \Aimeos\MW\Mail\Swift( function() use ( $mock ) { return $mock; } );

		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Swift', $object );
	}


	public function testCreateMessage()
	{
		$result = $this->object->createMessage( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );

		$this->object->send( $this->object->createMessage() );
	}


	public function testClone()
	{
		$result = clone $this->object;
		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Iface', $result );
	}
}
