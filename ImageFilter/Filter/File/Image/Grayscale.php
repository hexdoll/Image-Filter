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

		$img_new = $this->_grayscaleImage($img_orig);

		$this->_outputImage($img_new, exif_imagetype($value), $value);
		return $value; 
	}

	/**
	 * Code from example at http://php.about.com/od/gdlibrary/ss/grayscale_gd.htm
	 * Is there a more efficient way to do this?
	 */
	protected function _grayscaleImage($image)
	{
		$size = array('width' => imagesx($image), 'height' => imagesy($image));

		for ($c=0; $c<256; $c++)
		{
			$palette[$c] = imagecolorallocate($image,$c,$c,$c);
		}

		//Reads the original colors pixel by pixel
		for ($y = 0; $y < $size['height']; $y++)
		{
			for ($x = 0; $x < $size['width']; $x++)
			{
				$rgb = imagecolorat($image, $x, $y);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				//This is where we actually use yiq to modify our rbg values, and then convert them to our grayscale palette
				$gs = $this->_yiq($r, $g, $b);
				imagesetpixel($image, $x, $y, $palette[$gs]);
			}
		}
		return $image;
	}

	protected function _yiq($r, $g, $b)
	{
		return (($r*0.299)+($g*0.587)+($b*0.114));
	}
}
