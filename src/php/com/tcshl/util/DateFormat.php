<?php
/*
 * Created on Oct 23, 2009
 *
 * This object can be used to format dates.  Always pass in a unix timestamp.
*/
class DateFormat {
    private $date;
    private $unixTimestamp;
    private $formatType;
    // FORMAT STRINGS
    private $MOBILE_DATE_FORMAT = 'D, M jS';
    private $MOBILE_TIME_FORMAT = 'h:i a';
    private $SITE_DATE_FORMAT = 'D, M jS';
    private $SITE_TIME_FORMAT = 'g:i a';
    public function __construct() {
    }
    public function formatTimestamp($unixTimestamp, $formatType) {
        $this->unixTimestamp = $unixTimestamp;
        $this->formatType = $formatType;
        if ($formatType == 'MOBILE_DATE_FORMAT') $this->format_MobileDate();
        else if ($formatType == 'MOBILE_TIME_FORMAT') $this->format_MobileTime();
        else if ($formatType == 'SITE_DATE_FORMAT') $this->format_SiteDate();
        else if ($formatType == 'SITE_TIME_FORMAT') $this->format_SiteTime();
        return $this->date;
    }
    // MOBILE_DATE_FORMAT
    private function format_MobileDate() {
        $this->date = date($this->MOBILE_DATE_FORMAT, $this->unixTimestamp);
    }
    // MOBILE_TIME_FORMAT
    private function format_MobileTime() {
        $this->date = date($this->MOBILE_TIME_FORMAT, $this->unixTimestamp);
    }
    // SITE_DATE_FORMAT
    private function format_SiteDate() {
        $this->date = date($this->SITE_DATE_FORMAT, $this->unixTimestamp);
    }
    // SITE_TIME_FORMAT
    private function format_SiteTime() {
        $this->date = date($this->SITE_TIME_FORMAT, $this->unixTimestamp);
    }
}
?>
