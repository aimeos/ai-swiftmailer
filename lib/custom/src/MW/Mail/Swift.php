<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2020
 * @package MW
 * @subpackage Mail
 */


namespace Aimeos\MW\Mail;


/**
 * SwiftMailer implementation for creating and sending e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class Swift implements \Aimeos\MW\Mail\Iface
{
	private $closure;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Closure|\Swift_Mailer $object Closure or Swift_Mailer object
	 */
	public function __construct( $object )
	{
		if( $object instanceof \Closure ) {
			$this->closure = $object;
		} else {
			$this->closure = function() use ( $object ) { return $object; };
		}
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return \Aimeos\MW\Mail\Message\Iface E-mail message object
	 */
	public function createMessage( string $charset = 'UTF-8' ) : \Aimeos\MW\Mail\Message\Iface
	{
		return new \Aimeos\MW\Mail\Message\Swift( $this, new \Swift_Message(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\MW\Mail\Message\Iface $message E-mail message object
	 * @return \Aimeos\MW\Mail\Iface Mail instance for method chaining
	 */
	public function send( \Aimeos\MW\Mail\Message\Iface $message ) : Iface
	{
		$closure = $this->closure;
		$closure()->send( $message->getObject() );

		return $this;
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$closure = $this->closure;
		$this->closure = function() use ( $closure ) { return clone $closure(); };
	}
}
