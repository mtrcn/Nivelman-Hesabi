<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PHP Geometry/WKT encoder/decoder
 *
 * Mainly inspired by Openlayers/format/WKT.js
 *
 */
class WKT
{

  private $regExes = array(
    'typeStr'               => '/^\s*(\w+)\s*\(\s*(.*)\s*\)\s*$/',
    'spaces'                => '/\s+/',
    'parenComma'            => '/\)\s*,\s*\(/',
    'doubleParenComma'      => '/\)\s*\)\s*,\s*\(\s*\(/',
    'trimParens'            => '/^\s*\(?(.*?)\)?\s*$/'
  );

  const POINT               = 'point';
  const MULTIPOINT          = 'multipoint';

  /**
   * Read WKT string into geometry objects
   *
   * @param string $WKT A WKT string
   *
   * @return Array
   */
  public function read($WKT)
  {
    $matches = array();
    if (!preg_match($this->regExes['typeStr'], $WKT, $matches))
    {
      return null;
    }
    return $this->parse(strtolower($matches[1]), $matches[2]);
  }

  /**
   * Parse WKT string into geometry objects
   *
   * @param string $WKT A WKT string
   *
   * @return Array
   */
  public function parse($type, $str)
  {
    $matches = array();
    $components = array();

    switch ($type)
    {
      case self::POINT:
        preg_match($this->regExes['spaces'], $str, $matches);
        $coords = explode($matches[0], trim($str));
        return array('X'=>$coords[0], 'Y'=>$coords[1]);

      case self::MULTIPOINT:
        $points = explode(',', trim($str));
        foreach ($points as $point)
        {
        	$point = $this->parse(self::POINT, $point);
        	$components['X'][] = $point['X'];
        	$components['Y'][] = $point['Y'];
        }
        return $components;

      default:
        return null;
    }
  }

}
