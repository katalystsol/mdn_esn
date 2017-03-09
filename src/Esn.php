<?php
/**
 * @author  donaldcranford
 * @created 3/9/17 9:00 AM
 */

namespace Katalyst\MdnEsn;

/**
 * Class Esn
 *
 * This class handles Electronic Serial Numbers (ESN) or Mobile Equipment Identifier (MEID) for CDMA devices
 *
 * @package Katalyst\MdnEsn
 */
class Esn
{
	/** @var string The format of the submitted ESN */
	protected $submitted_format;

	/** @var string The submitted ESN */
	protected $submitted_esn;

	/** @var array Valid formats. Key is the format length */
	protected $formats = array(
		8 => array('format' => 'ESN8HEX', 'type' => 'HEX'),
		11 => array('format' => 'ESN11DEC', 'type' => 'DEC'),
		14 => array('format' => 'MEIN14HEX', 'type' => 'HEX'),
		18 => array('format' => 'MEIN18DEC', 'type' => 'DEC'),
	);

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

		$valid_lengths = array_keys($this->formats);

		// If invalid length, return empty
		if (!in_array($len, $valid_lengths)) {
			return '';
		}

		$format	= isset($this->formats[$len]['format']) ? $this->formats[$len]['format'] : '';

		// Validate that hex is hex and dec is dec
		if ((in_array($format, $this->hexFormats) && !ctype_xdigit($esn)) ||
			(in_array($format, $this->decFormats) && !ctype_digit($esn))) {
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
		if(in_array($this->submitted_format, $this->allFormats())) {
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
		$formats = array();

		foreach ($this->formats as $key => $value) {
			if ($value['type'] == 'HEX') {
				$formats[] = $value['format'];
			}
		}

		return $formats;
	}

	/**
	 * Returns an array of Dec formats
	 * @return array
	 */
	protected function setDecFormats()
	{
		$formats = array();

		foreach ($this->formats as $key => $value) {
			if ($value['type'] == 'DEC') {
				$formats[] = $value['format'];
			}
		}

		return $formats;
	}

	/**
	 * Returns an array of all formats
	 * @return array
	 */
	protected function allFormats()
	{
		$formats = array();

		foreach ($this->formats as $key => $value) {
			$formats[] = $value['format'];
		}

		return $formats;
	}

}