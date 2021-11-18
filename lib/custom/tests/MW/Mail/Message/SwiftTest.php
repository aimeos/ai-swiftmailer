<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\MW\Mail\Message;


class SwiftTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mailer;
	private $mock;


	protected function setUp() : void
	{
		if( class_exists( 'Swift_Message' ) === false ) {
			$this->markTestSkipped( 'Class Swift_Message not found' );
		}

		$this->mailer = $this->getMockBuilder( '\Aimeos\MW\Mail\Swift' )
			->disableOriginalConstructor()
			->setMethods( ['send'] )
			->getMock();

		$this->mock = $this->getMockBuilder( 'Swift_Message' )
			->setMethods( [
				'addFrom', 'addTo', 'addCc', 'addBcc',
				'addReplyTo', 'addTextHeader', 'setSender',
				'setSubject', 'setBody', 'addPart'
			] )->getMock();

		$this->object = new \Aimeos\MW\Mail\Message\Swift( $this->mailer, $this->mock, 'UTF-8' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mailer );
	}


	public function testFrom()
	{
		$this->mock->expects( $this->once() )->method( 'addFrom' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->from( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testTo()
	{
		$this->mock->expects( $this->once() )->method( 'addTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->to( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testCc()
	{
		$this->mock->expects( $this->once() )->method( 'addCc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->cc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testBcc()
	{
		$this->mock->expects( $this->once() )->method( 'addBcc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->bcc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testReplyTo()
	{
		$this->mock->expects( $this->once() )->method( 'addReplyTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->replyTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testHeader()
	{
		$result = $this->object->header( 'test', 'value' );
		$this->assertSame( $this->object, $result );
	}


	public function testSend()
	{
		$this->mailer->expects( $this->once() )->method( 'send' );
		$this->assertSame( $this->object, $this->object->send() );
	}


	public function testSender()
	{
		$this->mock->expects( $this->once() )->method( 'setSender' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->sender( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSubject()
	{
		$this->mock->expects( $this->once() )->method( 'setSubject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->subject( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testText()
	{
		$this->mock->expects( $this->once() )->method( 'addPart' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->text( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testHtml()
	{
		$this->mock->expects( $this->once() )->method( 'setBody' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->html( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAttach()
	{
		$this->markTestIncomplete( 'Swift_Attachment::newInstance() cannot be tested' );
	}


	public function testEmbed()
	{
		$this->markTestIncomplete( 'Swift_EmbeddedFile::newInstance() cannot be tested' );
	}


	public function testObject()
	{
		$this->assertInstanceOf( 'Swift_Message', $this->object->object() );
	}


	public function testClone()
	{
		$result = clone $this->object;
		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Message\\Iface', $result );
	}
}
