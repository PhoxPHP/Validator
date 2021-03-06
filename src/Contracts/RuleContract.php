<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Validator\Contracts\RuleContract
* @license 		MIT License
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Validator\Contracts;

use Kit\Validator\ValidationErrorBag;

interface RuleContract
{
	
	/**
	* Rule construct
	*
	* @param 	$label <String>
	* @param 	$value <Mixed>
	* @param 	$options <Mixed> | null
	* @param 	$validationErrorBag <Kit\Validator\ValidationErrorBag>
	* @param 	$rulesErrorMessages <Array>
	* @access 	public
	* @return 	<void>
	*/
	public function __construct(String $label, $value, $options=null, ValidationErrorBag $validationErrorBag, Array $rulesErrorMessages);

	/**
	* Validate rule.
	*
	* @access 	public
	* @return 	<void>
	*/
	public function validateRule();

}