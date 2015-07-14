<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 * @package MW
 * @subpackage Mail
 */


/**
 * SwiftMailer implementation for creating and sending e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class MW_Mail_Swift implements MW_Mail_Interface
{
	private $_closure;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param Closure|Swift_Mailer $object Closure or Swift_Mailer object
	 */
	public function __construct( $object )
	{
		if( $object instanceof Closure ) {
			$this->_closure = $object;
		}

		$this->_closure = function() use ( $object ) { return $object; };
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return MW_Mail_Message_Interface E-mail message object
	 */
	public function createMessage( $charset = 'UTF-8' )
	{
		return new MW_Mail_Message_Swift( \Swift_Message::newInstance(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param MW_Mail_Message_Interface $message E-mail message object
	 */
	public function send( MW_Mail_Message_Interface $message )
	{
		$closure = $this->_closure;
		$closure()->send( $message->getObject() );
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$closure = $this->_closure;
		$this->_closure = function() use ( $closure ) { return clone $closure(); };
	}
}
