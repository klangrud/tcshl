<?php
/*
 * Created on Sep 15, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
class SkillLevel {
    private $skillLevel;
    private $humanReadableSkillLevelArray;
    function __construct($skillLevel) {
        $this->skillLevel = (int)$skillLevel;
        $this->humanReadableSkillLevelArray = array(1 => "Beginner", 2 => "Level 1", 3 => "Level 2", 4 => "Level 3", 5 => "Level 4");
    }
    public function get_humanReadableSkillLevel() {
        return $this->humanReadableSkillLevelArray[$this->skillLevel];
    }
}
?>
