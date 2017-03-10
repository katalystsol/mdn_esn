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
	public function submitted_19_character_meid_is_not_valid_format()
	{
		$meid_number = '2684354560102010200';
		$esn = new Esn($meid_number);

		$this->assertFalse($esn->isValidFormat());
	}

	/** @test */
	public function returns_proper_hex_format_when_submitted_in_hex()
	{
		$meid_number = 'A10000009296F2';
		$esn = new Esn($meid_number);

		$this->assertEquals($meid_number, $esn->getHex());
	}

	/** @test */
	public function returns_proper_hex_format_when_submitted_in_18_digit_dec()
	{
		$meid_number = '268435456010201020';
		$hex_format = 'A00000009BA7BC';
		$esn = new Esn($meid_number);

		$this->assertEquals($hex_format, $esn->getHex());
	}

	/** @test */
	public function returns_proper_hex_format_when_submitted_in_11_digit_dec()
	{
		$meid_number = '24110201020';
		$hex_format = 'F19BA7BC';
		$esn = new Esn($meid_number);

		$this->assertEquals($hex_format, $esn->getHex());
	}

	/** @test */
	public function returns_proper_dec_format_when_submitted_in_dec()
	{
		$meid_number = '268435456010201020';
		$esn = new Esn($meid_number);

		$this->assertEquals($meid_number, $esn->getDec());
	}

	/** @test */
	public function returns_proper_dec_format_when_submitted_in_hex()
	{
		$meid_number = 'A00000009BA7BC';
		$hex_format = '268435456010201020';
		$esn = new Esn($meid_number);

		$this->assertEquals($hex_format, $esn->getDec());
	}
}