<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Validator\Rule\MacAddress
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

namespace Kit\Validator\Rule;

use Kit\Validator\Contracts\RuleContract;
use Kit\Validator\Contracts\AbstractRuleContract;
use Kit\Validator\ValidationErrorBag;

class MacAddress extends AbstractRuleContract implements RuleContract
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
		$this->messageFormat = $rulesErrorMessages['mac_address'];
	}

	/**
	* {@inheritDoc}
	*/
	public function validateRule()
	{
		$check1 = preg_match('/^([a-fA-F0-9]{2}:){5}[a-fA-F0-9]{2}$/', $this->value[0]);
		$check2 = preg_match('/^([a-fA-F0-9]{2}\-){5}[a-fA-F0-9]{2}$/', $this->value[0]);
		$check3 = preg_match('/^[a-fA-F0-9]{12}$/', $this->value[0]);
		$check4 = preg_match('/^([a-fA-F0-9]{4}\.){2}[a-fA-F0-9]{4}$/', $this->value[0]);

		if (!$check1 && !$check2 && !$check3 && !$check4) {
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