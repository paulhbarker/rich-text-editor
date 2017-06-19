<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;
use HTMLPurifier_Bootstrap;
use HTMLPurifier_TagTransform_Simple;

class Purifier  {


	/**
	 * Sanitize and format html
	 *
	 * @param $html
	 * @return string
	 */
	public function clean($html)
	{
		require base_path('vendor/ezyang/htmlpurifier/library/') . 'HTMLPurifier.auto.php';
		HTMLPurifier_Bootstrap::registerAutoload();
		$config = HTMLPurifier_Config::createDefault();
		$config->loadArray([
			'Core.Encoding' => 'UTF-8',
			'HTML.Doctype' => 'HTML 4.01 Strict',
			'HTML.Allowed' => 'h1,h2,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[alt|src],figure,figcaption',
			'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,color,background-color,text-align',
			'AutoFormat.AutoParagraph' => true,
			'AutoFormat.Linkify' => true,
			'AutoFormat.RemoveEmpty' => true,
		    'AutoFormat.RemoveSpansWithoutAttributes' => true,
		]);

		$def = $config->getHTMLDefinition(true);
		$def->info_tag_transform['b'] = new HTMLPurifier_TagTransform_Simple('strong');
		$def->info_tag_transform['i'] = new HTMLPurifier_TagTransform_Simple('em');
		
		$purifier = new HTMLPurifier($config);
		return $purifier->purify($html);
	}

}