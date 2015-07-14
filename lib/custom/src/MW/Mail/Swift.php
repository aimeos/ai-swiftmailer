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
	private $_object;


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
	 * Returns the mailer object.
	 *
	 * @return Swift_Mailer Swift_Mailer object
	 */
	public function getObject()
	{
		if( !isset( $this->_object ) ) {
			$this->_object = \Mail::getSwiftMailer();
		}

		return $this->_object;
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param MW_Mail_Message_Interface $message E-mail message object
	 */
	public function send( MW_Mail_Message_Interface $message )
	{
		$this->getObject()->send( $message->getObject() );
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->_object = ( isset( $this->_object ) ? clone $this->_object : null );
	}
}
