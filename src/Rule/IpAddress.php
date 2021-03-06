<?php
/**
* @author 		Peter Taiwo <peter@phoxphp.com>
* @package 		Kit\Validator\Rule\IpAddress
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

class IpAddress extends AbstractRuleContract implements RuleContract
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
		$this->messageFormat = $rulesErrorMessages['ip_address'];
	}

	/**
	* {@inheritDoc}
	*/
	public function validateRule()
	{
		$validate = filter_var($this->value[0], FILTER_VALIDATE_IP);

		if ($this->options[0] == 'ipv4') {
			$validate = filter_var($this->value[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
		}

		if ($this->options[0] == 'ipv6') {
			$validate = filter_var($this->value[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
		}

		if (!$validate) {
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