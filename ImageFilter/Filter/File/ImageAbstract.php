<?php
abstract class ImageFilter_Filter_File_ImageAbstract implements Zend_Filter_Interface
{
	public function filter($value) {}

	/**
	 * Create image from file using appropriate GD function
	 */
	protected function _createImage($filename)
	{
		$image = null;

		switch (exif_imagetype($filename))
		{
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif($filename);
			break;
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg($filename);
			break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng($filename);
			break;
			case IMAGETYPE_WBMP:
				$image = imagecreatefromwbmp($filename);
			break;
			default:
				throw new Zend_Filter_Exception('Image type not supported');
		}
		return $image;
	}

	/**
	 * Write the image back to a file of specified type
	 */
	protected function _outputImage($image, $type, $filename)
	{
		$output = null;

		switch ($type)
		{
			case IMAGETYPE_GIF:
				$output = imagegif($image, $filename);
			break;
			case IMAGETYPE_JPEG:
				$output = imagejpeg($image, $filename);
			break;
			case IMAGETYPE_PNG:
				$output = imagepng($image, $filename);
			break;
			case IMAGETYPE_WBMP:
				$output = imagewbmp($image, $filename);
			break;
		}
		
		return $output;
	}
}
