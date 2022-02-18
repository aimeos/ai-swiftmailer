<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2022
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail;


/**
 * SwiftMailer implementation for creating and sending e-mails.
 *
 * @package Base
 * @subpackage Mail
 */
class Swift implements \Aimeos\Base\Mail\Iface
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
	 * @return \Aimeos\Base\Mail\Message\Iface E-mail message object
	 */
	public function create( string $charset = 'UTF-8' ) : \Aimeos\Base\Mail\Message\Iface
	{
		return new \Aimeos\Base\Mail\Message\Swift( $this, new \Swift_Message(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\Base\Mail\Message\Iface $message E-mail message object
	 * @return \Aimeos\Base\Mail\Iface Mail instance for method chaining
	 */
	public function send( \Aimeos\Base\Mail\Message\Iface $message ) : Iface
	{
		$closure = $this->closure;
		$closure()->send( $message->object() );

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
