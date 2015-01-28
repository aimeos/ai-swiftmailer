<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


class MW_Mail_Message_SwiftTest extends MW_Unittest_Testcase
{
	private $_object;
	private $_mock;


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

		$this->_mock = $this->getMockBuilder( 'Swift_Message' )
			->setMethods( array(
				'addFrom', 'addTo', 'addCc', 'addBcc',
				'addReplyTo', 'addTextHeader', 'setSender',
				'setSubject', 'setBody', 'addPart'
			) )->getMock();

		$this->_object = new MW_Mail_Message_Swift( $this->_mock, 'UTF-8' );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
	}


	public function testAddFrom()
	{
		$this->_mock->expects( $this->once() )->method( 'addFrom' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addFrom( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddTo()
	{
		$this->_mock->expects( $this->once() )->method( 'addTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addTo( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddCc()
	{
		$this->_mock->expects( $this->once() )->method( 'addCc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addCc( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddBcc()
	{
		$this->_mock->expects( $this->once() )->method( 'addBcc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addBcc( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddReplyTo()
	{
		$this->_mock->expects( $this->once() )->method( 'addReplyTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addReplyTo( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddHeader()
	{
		$result = $this->_object->addHeader( 'test', 'value' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetSender()
	{
		$this->_mock->expects( $this->once() )->method( 'setSender' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->setSender( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetSubject()
	{
		$this->_mock->expects( $this->once() )->method( 'setSubject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setSubject( 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetBody()
	{
		$this->_mock->expects( $this->once() )->method( 'setBody' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setBody( 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetBodyHtml()
	{
		$this->_mock->expects( $this->once() )->method( 'addPart' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setBodyHtml( 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddAttachment()
	{
		$this->markTestIncomplete( 'Swift_Attachment::newInstance() cannot be tested' );
	}


	public function testEmbedAttachment()
	{
		$this->markTestIncomplete( 'Swift_EmbeddedFile::newInstance() cannot be tested' );
	}


	public function testGetObject()
	{
		$this->assertInstanceOf( 'Swift_Message', $this->_object->getObject() );
	}


	public function testClone()
	{
		$result = clone $this->_object;
		$this->assertInstanceOf( 'MW_Mail_Message_Interface', $result );
	}
}
