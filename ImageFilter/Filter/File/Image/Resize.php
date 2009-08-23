<?php
class ImageFilter_Filter_File_Image_Resize extends ImageFilter_Filter_File_ImageAbstract
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

		$new = $this->_resizeImage($orig, $this->_options);

		$img_new = imagecreatetruecolor($new['width'], $new['height']);
		imagecopyresized($img_new, $img_orig, 0, 0, 0, 0, $new['width'], $new['height'], $orig['width'], $orig['height']);
		
		$this->_outputImage($img_new, exif_imagetype($value), $value);
		return $value; 
	}

	/**
     * This function does all the maths of resizing
     * in a separate function to ease testing
     *
	 * @param $options the options passed to this class
	 * @param $size an associative array with 2 keys, 'width' and 'height'
	 * @return associative array containing the new width and height 
	 */
	protected function _resizeImage($orig_size, $options)
	{
		Zend_Registry::get('logger')->debug(print_r($options, true));

		//maintain aspect ratio
		if ($options['ratio'] == true)
		{
			$width = $orig_size['width'] * $options['height'] / $orig_size['height'];
	        $height = $orig_size['height'] * $options['width'] / $orig_size['width'];
		
			$width = ($width > $options['width'] ? $options['width'] : $width);
			$height = ($height > $options['height'] ? $options['height'] : $height);
		}

		$size = array('width' => (int) $width, 'height' => (int) $height);
		Zend_Registry::get('logger')->debug(print_r($orig_size, true));
		Zend_Registry::get('logger')->debug(print_r($size, true));
		return $size;
	}
}
