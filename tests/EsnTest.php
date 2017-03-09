<?php
/**
 * @author  donaldcranford
 * @created 3/9/17 9:11 AM
 */

namespace Katalyst\MdnEsn\Test;

use Katalyst\MdnEsn\Esn;

class EsnTest extends \PHPUnit_Framework_TestCase
{
	/** @test */
	public function submitted_11_digit_esn_is_valid_format()
	{
		$esn_number = '23981037459';
		$esn = new Esn($esn_number);

		$this->assertTrue($esn->isValidFormat());
	}

	/** @test */
	public function submitted_10_digit_esn_is_not_valid_format()
	{
		$esn_number = '2398103745';
		$esn = new Esn($esn_number);

		$this->assertFalse($esn->isValidFormat());
	}

	/** @test */
	public function submitted_14_character_meid_is_valid_format()
	{
		$meid_number = 'A10000009296F2';
		$esn = new Esn($meid_number);

		$this->assertTrue($esn->isValidFormat());
	}

	/** @test */
	public function submitted_15_character_meid_is_not_valid_format()
	{
		$meid_number = 'A10000009296F2X';
		$esn = new Esn($meid_number);

		$this->assertFalse($esn->isValidFormat());
	}

	/** @test */
	public function submitted_18_character_meid_is_valid_format()
	{
		$meid_number = '268435456010201020';
		$esn = new Esn($meid_number);

		$this->assertTrue($esn->isValidFormat());
	}

	/** @test */
	public function submitted_19_character_meid_is_valid_format()
	{
		$meid_number = '2684354560102010200';
		$esn = new Esn($meid_number);

		$this->assertFalse($esn->isValidFormat());
	}

	public function returns_proper_hex_format()
	{

	}

	public function returns_proper_dec_format()
	{

	}
}