<?php
/**
 * ICS.php
 * =======
 * Use this class to create an .ics file.
 *
 * Usage
 * -----
 * Basic usage - generate ics file contents (see below for available properties):
 *   $ics = new ICS($props);
 *   $ics_file_contents = $ics->to_string();
 *
 * Setting properties after instantiation
 *   $ics = new ICS();
 *   $ics->set('summary', 'My awesome event');
 *
 * You can also set multiple properties at the same time by using an array:
 *   $ics->set(array(
 *     'dtstart' => 'now + 30 minutes',
 *     'dtend' => 'now + 1 hour'
 *   ));
 *
 * Available properties
 * --------------------
 * description
 *   String description of the event.
 * dtend
 *   A date/time stamp designating the end of the event. You can use either a
 *   DateTime object or a PHP datetime format string (e.g. "now + 1 hour").
 * dtstart
 *   A date/time stamp designating the start of the event. You can use either a
 *   DateTime object or a PHP datetime format string (e.g. "now + 1 hour").
 * location
 *   String address or description of the location of the event.
 * summary
 *   String short summary of the event - usually used as the title.
 * url
 *   A url to attach to the the event. Make sure to add the protocol (http://
 *   or https://).
 */

namespace App;

class ICS {
  const DT_FORMAT = 'Ymd\THis';
  protected $events = [];
  protected $properties = array();
  private $available_properties = array(
    'description',
    'dtend',
    'dtstart',
    'location',
    'summary',
    'url'
  );
  public function __construct($events) {
    //$this->set($props);
    if(isset($events["description"])){
      $this->set($events);
      $this->events[] = $this->properties;
    }else{
      foreach($events as $event){
        $this->set($event);
        $this->events[] = $this->properties;
  
      }
    }
    
  }
  public function set($key, $val = false) {
    if (is_array($key)) {
      foreach ($key as $k => $v) {
        $this->set($k, $v);
      }
    } else {
      if (in_array($key, $this->available_properties)) {
        $this->properties[$key] = $this->sanitize_val($val, $key);
      }
    }
  }
  public function to_string() {
    $rows = $this->build_props();
    return implode("\r\n", $rows);
  }
  private function build_props() {
    // Build ICS properties - add header
    $ics_props = array(
      'BEGIN:VCALENDAR',
      'VERSION:2.0',
      'PRODID:-//hacksw/handcal//NONSGML v1.0//EN',
      'CALSCALE:GREGORIAN',
      'X-WR-TIMEZONE:Europe/Paris',
      // 'BEGIN:VTIMEZONE',
      // 'TZID:Europe/Paris',
      // 'BEGIN:STANDARD',
      // 'DTSTART:19710101T030000',
      // 'TZOFFSETTO:+0100',
      // 'TZOFFSETFROM:+0200',
      // 'RRULE:FREQ=YEARLY;WKST=MO;INTERVAL=1;BYMONTH=10;BYDAY=-1SU',
      // 'TZNAME:CET',
      // 'END:STANDARD',
      // 'BEGIN:DAYLIGHT',
      // 'DTSTART:19710101T020000',
      // 'TZOFFSETTO:+0200',
      // 'TZOFFSETFROM:+0100',
      // 'RRULE:FREQ=YEARLY;WKST=MO;INTERVAL=1;BYMONTH=3;BYDAY=-1SU',
      // 'TZNAME:CEST',
      // 'END:DAYLIGHT',
      // 'END:VTIMEZONE'
      'BEGIN:VTIMEZONE',
'TZID:Europe/Paris',
'X-LIC-LOCATION:Europe/Paris',
'BEGIN:DAYLIGHT',
'TZOFFSETFROM:+0100',
'TZOFFSETTO:+0200',
'TZNAME:CEST',
'DTSTART:19700329T020000',
'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=-1SU;BYMONTH=3',
'END:DAYLIGHT',
'BEGIN:STANDARD',
'TZOFFSETFROM:+0200',
'TZOFFSETTO:+0100',
'TZNAME:CET',
'DTSTART:19701025T030000',
'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=-1SU;BYMONTH=10',
'END:STANDARD',
'END:VTIMEZONE',
    );
    // Build ICS properties - add header
    foreach($this->events as $event){
      $ics_props[] = 'BEGIN:VEVENT';
      $props = array();
      foreach($event as $k => $v) {
        $props[strtoupper($k . ($k === 'url' ? ';VALUE=URI' : ''))] = $v;
      }
      // Set some default values
      $props['DTSTAMP'] = $this->format_timestamp('now');
      $props['UID'] = uniqid();
      // Append properties
      foreach ($props as $k => $v) {
        if($k == "dtstart" or $k=="dtend"){
          $ics_props[] = "$k;TZID=Europe/Paris:$v";
        }else{
          $ics_props[] = "$k:$v";
        }
        
      }
      // Build ICS properties - add footer
      $ics_props[] = 'END:VEVENT';
    }

    $ics_props[] = 'END:VCALENDAR';
    return $ics_props;
  }
  private function sanitize_val($val, $key = false) {
    switch($key) {
      case 'dtend':
      case 'dtstamp':
      case 'dtstart':
        $val = $this->format_timestamp($val);
        break;
      default:
        $val = $this->escape_string($val);
    }
    return $val;
  }
  private function format_timestamp($timestamp) {
    $dt = new \DateTime($timestamp);
    return $dt->format(self::DT_FORMAT);
  }
  private function escape_string($str) {
    return preg_replace('/([\,;])/','\\\$1', $str);
  }
}