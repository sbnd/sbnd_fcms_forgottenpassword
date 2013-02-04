<?php
/**
* SBND F&CMS - Framework & CMS for PHP developers
*
* Copyright (C) 1999 - 2013, SBND Technologies Ltd, Sofia, info@sbnd.net, http://sbnd.net
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @author SBND Techologies Ltd <info@sbnd.net>
* @package cms.cmp.forgottenpassword
* @version 1.2
*/
BASIC::init()->imported('Access.cmp', 'cms/controlers/back');

class ForgottenPassword extends Access {
	
	public $template_form = 'cmp-form.tpl';
	public $prefix = '';
	public $forgot_mail_template = 'cms-forgot-pass.tpl';
	
	public $go_to_after_send = '';
	public $go_to_top = "/";
	/**
	 * Set run_module = 1 for forgotten password, see Access class
	 */
	function checkMode(){
		$this->run_mode = 1;
	}
	/**
	 * Send mail and redirect to active page
	 */
	function ActionSave(){
		$res = parent::ActionSave();
		if($this->getMessage('pass') == 1 ){
			$this->unsetMessage('pass');
		}
		if(!$this->messages){
			BASIC_URL::init()->redirect(Builder::init()->build('pages')->getPageTreeByName($this->go_to_after_send));
		}
		else{
			return false;
		}
	}
	/**
	 * override Access method, used in email
	 */
	function genLink($page=''){
		return Builder::init()->build('pages')->getPageTreeByName($this->go_to_after_send);
	}
	/**
	 * override Access method, used in email
	 */
	function genActiveCodeLink($active_code=''){
		
		return Builder::init()->build('pages')->getPageTreeByName($this->go_to_after_send).'code/'.$active_code;
		
	}
	/**
	 * Define module settings fields, which values will override value of class properties
	 * @access public
	 * @return hashmap
	 */
	function settingsData(){
		return array(
			'template_form'  		=> $this->template_form,
			'forgot_mail_template'  => $this->forgot_mail_template,
			'prefix' 				=> $this->prefix,
			'go_to_after_send' 		=> $this->go_to_after_send
		);
	}
	/**
	 * Module settings fields description 
	 * @access public
	 * @return value
	 */
	function settingsUI(){	
		return array(
			'template_form' => array(
				'text' => BASIC_LANGUAGE::init()->get('template_form')
			),
			'forgot_mail_template' => array(
				'text' => BASIC_LANGUAGE::init()->get('forgot_mail_template')
			),
			'prefix' => array(
				'text' => BASIC_LANGUAGE::init()->get('prefix')
			),
			'go_to_after_send' => array(
				'text' => BASIC_LANGUAGE::init()->get('go_to_after_send'),
				'formtype' => 'select',
				'attributes' => array(
					'data' => Builder::init()->build('pages')->getSelTree('',0, 'name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
				)
			)
		);
	}
}