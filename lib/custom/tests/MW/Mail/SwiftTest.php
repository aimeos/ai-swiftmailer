<?php

namespace Aimeos\MW\Mail;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2018
 */
class SwiftTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( class_exists( '\Swift_Message' ) === false ) {
			$this->markTestSkipped( 'Class Swift_Message not found' );
		}

		$transport = new \Swift_Transport_NullTransport( new \Swift_Events_SimpleEventDispatcher() );

		$this->mock = $this->getMockBuilder( 'Swift_Mailer' )->setConstructorArgs( array( $transport ) )->getMock();
		$this->object = new \Aimeos\MW\Mail\Swift( $this->mock );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
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
