<?php
/**
* @author 	Peter Taiwo
* @package 	Kit\Validator\Rule\Even;
*
* MIT License
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*/

namespace Kit\Validator\Rule;

use Kit\Validator\Contracts\RuleContract;
use Kit\Validator\Contracts\AbstractRuleContract;
use Kit\Validator\ValidationErrorBag;

class Even extends AbstractRuleContract implements RuleContract
{

	/**
	* @var 		$label
	* @access 	protected
	*/
	protected 	$label;

	/**
	* @var 		$value
	* @access 	protected
	*/
	protected 	$value;

	/**
	* @var 		$options
	* @access 	protected
	*/
	protected 	$options;

	/**
	* @var 		$errorBag
	* @access 	protected
	*/
	protected 	$errorBag;

	/**
	* @var 		$messageFormat
	* @access 	protected
	*/
	protected 	$messageFormat;

	/**
	* {@inheritDoc}
	*/
	public function __construct(String $label, $value, $options=null, ValidationErrorBag $errorBag, Array $rulesErrorMessages)
	{
		$this->label = $label;
		$this->value = $value;
		$this->options = $options;
		$this->errorBag = $errorBag;
		$this->messageFormat = $rulesErrorMessages['even'];
	}

	/**
	* {@inheritDoc}
	*/
	public function validateRule()
	{
		if(($this->value[0] % 2 == 0) == false) {
			$this->errorBag->setValidationRuleError(
				$this,
				vsprintf(
					$this->messageFormat,
					[$this->label]
				)
			);
		}
	}

}