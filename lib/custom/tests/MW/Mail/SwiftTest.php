<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


class MW_Mail_SwiftTest extends MW_Unittest_Testcase
{
	private $_object;
	private $_stub;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( class_exists( 'Swift_Message' ) === false ) {
			$this->markTestSkipped( 'Class Swift_Message not found' );
		}

		$transport = new Swift_Transport_NullTransport( new Swift_Events_SimpleEventDispatcher() );

		$this->_stub = $this->getMockBuilder( 'Swift_Mailer' )->setConstructorArgs( array( $transport ) )->getMock();
		$this->_object = $this->getMockBuilder( 'MW_Mail_Swift' )->setMethods( array( 'getObject' ) )->getMock();

		$this->_object->expects( $this->any() )->method( 'getObject' )->will( $this->returnValue( $this->_stub ) );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->_object, $this->_stub );
	}


	public function testCreateMessage()
	{
		$result = $this->_object->createMessage( 'ISO-8859-1' );
		$this->assertInstanceOf( 'MW_Mail_Message_Interface', $result );
	}


	public function testSend()
	{
		$this->_stub->expects( $this->once() )->method( 'send' );
		$this->_object->send( $this->_object->createMessage() );
	}


	public function testClone()
	{
		$result = clone $this->_object;
		$this->assertInstanceOf( 'MW_Mail_Interface', $result );
	}
}
