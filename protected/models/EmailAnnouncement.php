<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class EmailAnnouncement extends CFormModel
{
	public $emailTo;
	public $email;
	public $emailFrom;
        public $name;
	public $announcement_id;
	public $subject;
	public $body;
	public $role;
	public $phone;
	public $comments;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email, announcement_id', 'required', 'on' => 'email'),
			array('name, emailFrom, announcement_id', 'required', 'on' => 'spam'),
			// email has to be a valid email address
			array('email, emailTo, emailFrom', 'email'),
                        array('email, role, phone, comments','safe')
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email',
			'role'=>'Role',
			'phone'=>'Telefoonnummer',
			'emailTo'=>'emailTo',
			'emailFrom'=>'emailFrom',
			'name'=>'name',
			'comments'=>'Bericht',
		);
	}
}