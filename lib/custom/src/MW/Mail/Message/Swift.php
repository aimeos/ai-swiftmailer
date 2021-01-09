<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 * @package MW
 * @subpackage Mail
 */


namespace Aimeos\MW\Mail\Message;


/**
 * SwiftMailer implementation for creating e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class Swift implements \Aimeos\MW\Mail\Message\Iface
{
	private $mailer;
	private $object;


	/**
	 * Initializes the message instance.
	 *
	 * @param \Aimeos\MW\Mail\Iface $mailer Swift mailer object
	 * @param \Swift_Message $object Swift message object
	 * @param string $charset Default charset of the message
	 */
	public function __construct( \Aimeos\MW\Mail\Iface $mailer, \Swift_Message $object, string $charset )
	{
		$object->setCharset( $charset );

		$this->mailer = $mailer;
		$this->object = $object;
	}


	/**
	 * Adds a source e-mail address of the message.
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user sending the e-mail or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addFrom( string $email, string $name = null ) : Iface
	{
		$this->object->addFrom( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address of the target user mailbox.
	 *
	 * @param string $email Destination address of the target mailbox
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addTo( string $email, string $name = null ) : Iface
	{
		$this->object->addTo( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address for a copy of the message.
	 *
	 * @param string $email Destination address for a copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addCc( string $email, string $name = null ) : Iface
	{
		$this->object->addCc( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address for a hidden copy of the message.
	 *
	 * @param string $email Destination address for a hidden copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addBcc( string $email, string $name = null ) : Iface
	{
		$this->object->addBcc( $email, $name );
		return $this;
	}


	/**
	 * Adds the return e-mail address for the message.
	 *
	 * @param string $email E-mail address which should receive all replies
	 * @param string|null $name Name of the user which should receive all replies or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addReplyTo( string $email, string $name = null ) : Iface
	{
		$this->object->addReplyTo( $email, $name );
		return $this;
	}


	/**
	 * Adds a custom header to the message.
	 *
	 * @param string $name Name of the custom e-mail header
	 * @param string $value Text content of the custom e-mail header
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addHeader( string $name, string $value ) : Iface
	{
		$hs = $this->object->getHeaders();
		$hs->addTextHeader( $name, $value );
		return $this;
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function send() : Iface
	{
		$this->mailer->send( $this );
		return $this;
	}


	/**
	 * Sets the e-mail address and name of the sender of the message (higher precedence than "From").
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user who sent the message or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setSender( string $email, string $name = null ) : Iface
	{
		$this->object->setSender( $email, $name );
		return $this;
	}


	/**
	 * Sets the subject of the message.
	 *
	 * @param string $subject Subject of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setSubject( string $subject ) : Iface
	{
		$this->object->setSubject( $subject );
		return $this;
	}


	/**
	 * Sets the text body of the message.
	 *
	 * @param string $message Text body of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setBody( string $message ) : Iface
	{
		$this->object->addPart( $message, 'text/plain' );
		return $this;
	}


	/**
	 * Sets the HTML body of the message.
	 *
	 * @param string $message HTML body of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setBodyHtml( string $message ) : Iface
	{
		$this->object->setBody( $message, 'text/html' );
		return $this;
	}


	/**
	 * Adds an attachment to the message.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file (or null if inline disposition is used)
	 * @param string $disposition Type of the disposition ("attachment" or "inline")
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addAttachment( string $data, string $mimetype, string $filename, string $disposition = 'attachment' ) : Iface
	{
		$part = new \Swift_Attachment( $data, $filename, $mimetype );
		$part->setDisposition( $disposition );

		$this->object->attach( $part );
		return $this;
	}


	/**
	 * Embeds an attachment into the message and returns its reference.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file
	 * @return string Content ID for referencing the attachment in the HTML body
	 */
	public function embedAttachment( string $data, string $mimetype, string $filename ) : string
	{
		$part = new \Swift_EmbeddedFile( $data, $filename, $mimetype );

		return $this->object->embed( $part );
	}


	/**
	 * Returns the internal Swift mail message object.
	 *
	 * @return \Swift_Message Swift mail message object
	 */
	public function getObject() : \Swift_Message
	{
		return $this->object;
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->object = clone $this->object;
	}
}
