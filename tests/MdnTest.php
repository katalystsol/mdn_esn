<?php
/**
 * @author  donaldcranford
 * @created 3/9/17 8:32 AM
 */

namespace Katalyst\MdnEsn\Test;

use Katalyst\MdnEsn\Mdn;

class MdnTest extends \PHPUnit_Framework_TestCase
{
	/** @test */
	public function mdn_is_valid_length()
	{
		$number = '999-999-9999';
		$mdn_length = 10;
		$mdn = new Mdn($number, $mdn_length);

		$this->assertTrue($mdn->isValid());
	}

	/** @test */
	public function mdn_is_not_valid_length()
	{
		$number = '999-999-9999';
		$mdn_length = 9;
		$mdn = new Mdn($number, $mdn_length);

		$this->assertFalse($mdn->isValid());
	}

	/** @test */
	public function mdn_strips_non_numeric_characters()
	{
		$number = '999-999-9999';
		$mdn_length = 10;
		$mdn = new Mdn($number, $mdn_length);

		$this->assertEquals('9999999999', $mdn->getFormattedMDN());
	}

	/** @test */
	public function returns_proper_mdn_length()
	{
		$number = '999-999-9999';
		$mdn_length = 10;
		$mdn = new Mdn($number, $mdn_length);

		$this->assertEquals(10, $mdn->getLength());

		$mdn_length2 = 9;
		$mdn2 = new Mdn($number, $mdn_length2);

		$this->assertEquals(9, $mdn2->getLength());
	}

	/** @test */
	public function returns_minimum_mdn_length_when_submitted_length_invalid()
	{
		$number = '999-999-9999';
		$mdn_length = 'test';
		$mdn = new Mdn($number, $mdn_length);

		$this->assertEquals(6, $mdn->getLength());

		$mdn_length2 = 4;
		$mdn2 = new Mdn($number, $mdn_length2);

		$this->assertEquals(6, $mdn2->getLength());
	}

}