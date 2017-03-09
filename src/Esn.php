<?php
/**
 * @author  donaldcranford
 * @created 3/9/17 9:00 AM
 */

namespace Katalyst\MdnEsn;

/**
 * Class Esn
 *
 * This class handles Electronic Serial Numbers for CDMA devices
 *
 * @package Katalyst\MdnEsn
 */
class Esn
{
	/** @var string The format of the submitted ESN */
	protected $submitted_format;

	/** @var string The submitted ESN */
	protected $submitted_esn;

	/** @var string The DEC format of the ESN */
	protected $dec_format;

	/** @var string The HEX format of the ESN */
	protected $hex_format;

	/** @var  array HEX formats */
	protected $hexFormats;

	/** @var  array DEC formats */
	protected $decFormats;

	/**
	 * Esn constructor.
	 *
	 * @param $esn
	 */
	public function __construct($esn)
	{
		$this->submitted_esn	= $esn;
		$this->hexFormats		= $this->setHexFormats();
		$this->decFormats		= $this->setDecFormats();
		$this->submitted_format	= $this->determineSubmittedFormat();
		$this->dec_format		= $this->calcDecFormat();
		$this->hex_format		= $this->calcHexFormat();
	}

	public function __toString()
	{
		return $this->getDec();
	}

	/**
	 * Determine the format of the Submitted ESN
	 *
	 * @return string
	 */
	protected function determineSubmittedFormat()
	{
		$esn	= $this->submitted_esn;
		$len	= strlen($esn);

		$valid_lengths = array('8', '11', '14', '18');

		// If invalid length, return empty
		if (!in_array($len, $valid_lengths)) {
			return '';
		}

		$formats = array(
			'8'		=> 'ESN8HEX',
			'11'	=> 'ESN11DEC',
			'14'	=> 'MEIN14HEX',
			'18'	=> 'MEIN18DEC',
		);

		$hexformats = $this->hexFormats;
		$decformats	= $this->decFormats;

		$format	= isset($formats[$len]) ? $formats[$len] : '';

		// Validate that hex is hex and dec is dec
		if ((in_array($format, $hexformats) && !ctype_xdigit($esn)) ||
			(in_array($format, $decformats) && !ctype_digit($esn))) {
			return '';
		}

		return $format;
	}

	/**
	 * Returns ESN in Hex format
	 * @return string
	 */
	public function getHex()
	{
		return $this->hex_format;
	}

	/**
	 * Returns ESN in Dec format
	 * @return string
	 */
	public function getDec()
	{
		return $this->dec_format;
	}

	/**
	 * Returns the format of the ESN as submitted
	 * @return string
	 */
	public function getSubmittedFormat()
	{
		return $this->submitted_format;
	}

	/**
	 * Returns if the submitted ESN was a valid format
	 * @return bool
	 */
	public function isValidFormat()
	{
		$formats = array(
			'ESN8HEX',
			'ESN11DEC',
			'MEIN14HEX',
			'MEIN18DEC',
		);

		if(in_array($this->submitted_format, $formats)) {
			return true;
		}

		return false;
	}

	/**
	 * Calculate and return the Hex format for the submitted ESN
	 * NOT CURRENTLY IMPLEMENTED
	 *
	 * @return string
	 * @TODO Complete this method
	 */
	protected function calcHexFormat()
	{
		$hex = (in_array($this->submitted_format, $this->hexFormats)) ? $this->submitted_esn : '';

		if(in_array($this->submitted_format, $this->decFormats)) {
			/*
						$full_len	= strlen($esn);
						$a_len		= ($full_len == 11) ? 2 : 8;
						$b_len		= 6;
						$a			= hexdec(substr($esn,0,$a_len));
						$b			= hexdec(substr($esn,$a_len,$b_len));
						$dec		= $a.$b;
			*/
		}

		return $hex;
	}

	/**
	 * Calculate and return the DEC / decimal format of the ESN
	 *
	 * @return string
	 */
	protected function calcDecFormat()
	{
		$esn = $this->submitted_esn;

		// If it is already in DEC format, leave it as is
		$dec = (in_array($this->submitted_format, $this->decFormats)) ? $esn : '';

		if(in_array($this->submitted_format, $this->hexFormats)) {
			$full_len	= strlen($esn);
			$a_len		= ($full_len == 11) ? 2 : 8;
			$b_len		= 6;
			$a			= str_pad(hexdec(substr($esn,0,$a_len)),10,'0',STR_PAD_LEFT);
			$b			= str_pad((string)hexdec(substr($esn,$a_len,$b_len)),8,'0',STR_PAD_LEFT);
			$dec		= $a.$b;
		}

		return $dec;
	}

	/**
	 * Return an array of Hex formats
	 * @return array
	 */
	protected function setHexFormats()
	{
		return array('ESN8HEX', 'MEIN14HEX');
	}

	/**
	 * Returns an array of Dec formats
	 * @return array
	 */
	protected function setDecFormats()
	{
		return array('ESN11DEC', 'MEIN18DEC');
	}

}