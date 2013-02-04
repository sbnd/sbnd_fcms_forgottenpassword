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

class ActivePassword extends Access {
	public $template_form = 'cmp-form.tpl';
	public $prefix = '';
	
	public $go_to_top = "/";
	/**
	 * Set run_module = 2 for activate password, see Access class
	 */
	function checkMode(){
		$this->run_mode = 2;
	}
	/**
	 * override Access method, change link to page in frontend instead in backend
	 */
	function genLink($page=''){
		return Builder::init()->build('pages')->getPageTreeByName($page);
	}
	/**
	 * Define module settings fields, which values will override value of class properties
	 * @access public
	 * @return hashmap
	 */
	function settingsData(){
		return array(
			'template_form'  		=> $this->template_form,
			'prefix' 				=> $this->prefix,
			'profile_page'			=> $this->profile_page
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
			'prefix' => array(
				'text' => BASIC_LANGUAGE::init()->get('prefix')
			),
			'profile_page' => array(
				'text' => BASIC_LANGUAGE::init()->get('profile_page'),
				'formtype' => 'select',
				'attributes' => array(
					'data' => Builder::init()->build('pages')->getSelTree('',0, 'name', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
				)
			),
		);
	}
}