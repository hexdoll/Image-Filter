<?php
/**
 * Convert the image to grayscale
 */
class ImageFilter_Filter_File_Image_Grayscale extends ImageFilter_Filter_File_ImageAbstract
{
	protected $_options;

	public function __construct($options = array())
	{
		$this->_options = $options;
	}

	public function filter($value)
	{
		$img_orig = $this->_createImage($value);
		$orig = array('width' => imagesx($img_orig), 'height' => imagesy($img_orig));

		$img_new = imagecreatetruecolor($orig['width'], $orig['height']);
		imagecopymergegray($img_new, $img_orig, 0, 0, 0, 0, $orig['width'], $orig['height'], 0);
		
		$this->_outputImage($img_new, exif_imagetype($value), $value);
		return $value; 
	}
}
