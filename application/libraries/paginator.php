<?php

class Paginator extends Laravel\\Paginator {
	/**
	 * Create a HTML page link.
	 *
	 * @param  int     $page
	 * @param  string  $text
	 * @param  string  $class
	 * @return string
	 */
	protected function link($page, $text, $class)
	{
		$query = '?page='.$page.$this->appendage($this->appends);

		$str = is_numeric($text) ? number_format($text) : $text;

		return '<li'.HTML::attributes(array('class' => $class)).'>'. HTML::link(URI::current().$query, $str, array(), Request::secure()).'</li>';
	}
}