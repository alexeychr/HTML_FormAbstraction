<?php


class HtmlUtil
{
	static function getTagCap($tag, array $attributes = array())
	{
		return self::getTagHead($tag, $attributes) . '>';
	}

	static function getNode($tag, array $attributes = array())
	{
		return self::getTagHead($tag, $attributes) . ' />';
	}

	static function getContainer($tag, array $attributes = array(), $innerHtml = '')
	{
		return self::getTagCap($tag, $attributes) . $innerHtml . '</' . $tag . '>';
	}

	private static function getTagHead($tag, array $attributes)
	{
		$s = "<$tag";
		$a = array();
		foreach ($attributes as $k => $v) {
			$a[] = $k.'="'.htmlspecialchars($v).'"';
		}
		$a = join(' ', $a);
		if ($a) $s .= ' ' .$a;

		return $s;
	}
}

