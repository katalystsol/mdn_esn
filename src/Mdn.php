<?php
/**
 * @author  donaldcranford
 * @created 3/9/17 8:18 AM
 */

namespace Katalyst\MdnEsn;

/**
 * Class Mdn
 *
 * This class handles Mobile Device Numbers format validation
 *
 * @package Katalyst\MdnEsn
 */
class Mdn
{
	/** @var string The MDN with all non-numeric characters removed */
	protected $formatted_mdn;

	/** @var  string The submitted MDN */
	protected $submitted_mdn;

	/** @var int The length of the mobile device number */
	protected $mdn_length;

	/** @var int The minimum length allowed for MDN */
	protected $minimum_mdn_length = 6;

	/**
	 * @param string $mdn
	 * @param int $mdn_length
	 */
	public function __construct($mdn, $mdn_length = 10)
	{
		$this->submitted_mdn	= $mdn;
		$this->formatted_mdn	= $this->formatMdn();

		$this->setMdnLength($mdn_length);
	}

	public function __toString()
	{
		return $this->formatted_mdn;
	}

	public function getFormattedMDN()
	{
		return $this->formatted_mdn;
	}

	public function getLength()
	{
		return $this->mdn_length;
	}

	/**
	 * Checks if the MDN is the correct length
	 * @return bool		TRUE if correct length
	 */
	public function isValid()
	{
		if (strlen($this->formatted_mdn) == $this->mdn_length)
		{
			return true;
		}

		return false;
	}

	/**
	 * Allows override of minimum mdn length
	 *
	 * @param int $minimum_length
	 */
	public function setMinimumMdnLength($minimum_length)
	{
		if (!empty($minimum_length) && is_int($minimum_length)) {
			$this->minimum_mdn_length = $minimum_length;
		}
	}

	/**
	 * Sets the mdn_length property
	 *
	 * @param int $length
	 */
	protected function setMdnLength($length)
	{
		$length = (int) $length;
		if ($length > $this->minimum_mdn_length) {
			$this->mdn_length = $length;
			return;
		}

		$this->mdn_length = $this->minimum_mdn_length;
	}

	/**
	 * Strips all non-numeric characters from the number
	 *
	 * @return string
	 */
	protected function formatMdn()
	{
		return preg_replace( "/[^0-9]/", "", $this->submitted_mdn);
	}

}