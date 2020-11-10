<?php

namespace App\Twig;

use Exception;
use Hracik\CreateImageFromText\CreateImageFromText;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigFunctions extends AbstractExtension
{


    public function getFunctions(): array
    {
        return [
	        new TwigFunction('strpad', [$this, 'strpad']),
        ];
    }

	public function getFilters(): array
	{
		return [
			new TwigFilter('create_image_from_text', [$this, 'createImageFromText']),
		];
	}

	public function strpad(string $string, $pad_length, $pad_string, $type = STR_PAD_RIGHT): string
	{
		return str_pad($string, $pad_length, $pad_string, $type);
	}

	/**
	 * @param $text
	 * @return Markup
	 * @throws Exception
	 */
	public function createImageFromText($text)
	{
		$html = CreateImageFromText::createImageFromText($text, 0, 10, 12, null, CreateImageFromText::RETURN_BASE64_IMG);
		return new Markup($html, 'UTF-8');
	}

}