<?php
// *************************MONTH PULL DOWN MENU*************************
function select_month($getName = "") {
    global $MONTH_SELECTED;
    $monthSelected = '';
    if (isset($_POST['month'])) {
        $monthSelected = $_POST['month'];
    } else if (isset($MONTH_SELECTED)) {
        $monthSelected = $MONTH_SELECTED;
    }
    $month = "";
    if ($getName == "1") {
        $month.= "<select name=\"month\">";
    }
    $month.= "<option value=\"01\">January</option>";
    $month.= "<option value=\"02\">February</option>";
    $month.= "<option value=\"03\">March</option>";
    $month.= "<option value=\"04\">April</option>";
    $month.= "<option value=\"05\">May</option>";
    $month.= "<option value=\"06\">June</option>";
    $month.= "<option value=\"07\">July</option>";
    $month.= "<option value=\"08\">August</option>";
    $month.= "<option value=\"09\">September</option>";
    $month.= "<option value=\"10\">October</option>";
    $month.= "<option value=\"11\">November</option>";
    $month.= "<option value=\"12\">December</option>";
    $month.= "</select>";
    if (strlen($monthSelected) > 0) {
        $month = str_replace('value="' . $monthSelected . '"', 'value="' . $monthSelected . '" selected="selected"', $month);
    }
    return $month;
}
// *************************DAY PULL DOWN MENU*************************
function select_day($getName = "") {
    global $DAY_SELECTED;
    $daySelected = '';
    if (isset($_POST['day'])) {
        $daySelected = $_POST['day'];
    } else if (isset($DAY_SELECTED)) {
        $daySelected = $DAY_SELECTED;
    }
    $day = "";
    if ($getName == "1") {
        $day.= "<select name=\"day\">";
    }
    $day.= "<option value=\"01\">1</option>";
    $day.= "<option value=\"02\">2</option>";
    $day.= "<option value=\"03\">3</option>";
    $day.= "<option value=\"04\">4</option>";
    $day.= "<option value=\"05\">5</option>";
    $day.= "<option value=\"06\">6</option>";
    $day.= "<option value=\"07\">7</option>";
    $day.= "<option value=\"08\">8</option>";
    $day.= "<option value=\"09\">9</option>";
    $day.= "<option value=\"10\">10</option>";
    $day.= "<option value=\"11\">11</option>";
    $day.= "<option value=\"12\">12</option>";
    $day.= "<option value=\"13\">13</option>";
    $day.= "<option value=\"14\">14</option>";
    $day.= "<option value=\"15\">15</option>";
    $day.= "<option value=\"16\">16</option>";
    $day.= "<option value=\"17\">17</option>";
    $day.= "<option value=\"18\">18</option>";
    $day.= "<option value=\"19\">19</option>";
    $day.= "<option value=\"20\">20</option>";
    $day.= "<option value=\"21\">21</option>";
    $day.= "<option value=\"22\">22</option>";
    $day.= "<option value=\"23\">23</option>";
    $day.= "<option value=\"24\">24</option>";
    $day.= "<option value=\"25\">25</option>";
    $day.= "<option value=\"26\">26</option>";
    $day.= "<option value=\"27\">27</option>";
    $day.= "<option value=\"28\">28</option>";
    $day.= "<option value=\"29\">29</option>";
    $day.= "<option value=\"30\">30</option>";
    $day.= "<option value=\"31\">31</option>";
    $day.= "</select>";
    if (strlen($daySelected) > 0) {
        $day = str_replace('value="' . $daySelected . '"', 'value="' . $daySelected . '" selected="selected"', $day);
    }
    return $day;
}
// *************************YEAR PULL DOWN MENU*************************
function select_year($getName = "") {
    global $YEAR_SELECTED;
    $yearSelected = '';
    if (isset($_POST['year'])) {
        $yearSelected = $_POST['year'];
    } else if (isset($YEAR_SELECTED)) {
        $yearSelected = $YEAR_SELECTED;
    }
    $this_year = date("Y");
    $year = "";
    if ($getName == "1") {
        $year.= "<select name=\"year\">";
    }
    for ($i = ($this_year);$i <= ($this_year + 5);$i++) {
        $year.= "<option value=\"$i\">$i</option>";
    }
    $year.= "</select>";
    if (strlen($yearSelected) > 0) {
        $year = str_replace('value="' . $yearSelected . '"', 'value="' . $yearSelected . '" selected="selected"', $year);
    }
    return $year;
}
// *************************HOUR PULL DOWN MENU*************************
function select_hour($getName = "") {
    global $HOUR_SELECTED;
    if (isset($_POST['hour'])) {
        $magicHour = $_POST['hour'];
    } else if (isset($HOUR_SELECTED)) {
        $magicHour = $HOUR_SELECTED;
    } else {
        $magicHour = "7";
    }
    $hour = "";
    if ($getName == "1") {
        $hour.= "<select name=\"hour\">";
    }
    for ($i = 1;$i <= 12;$i++) {
        if ($i < 10) {
            $optionValue = '0' . $i;
        } else {
            $optionValue = $i;
        }
        if ($i == $magicHour) {
            $hour.= "<option value=\"$optionValue\" selected=\"selected\">$i</option>";
        } else {
            $hour.= "<option value=\"$optionValue\">$i</option>";
        }
    }
    $hour.= "</select>";
    return $hour;
}
// *************************MINUTE PULL DOWN MENU*************************
function select_minute($getName = "") {
    global $MINUTE_SELECTED;
    $minuteSelected = '';
    if (isset($_POST['minute'])) {
        $minuteSelected = $_POST['minute'];
    } else if (isset($MINUTE_SELECTED)) {
        $minuteSelected = $MINUTE_SELECTED;
    }
    $minute = "";
    if ($getName == "1") {
        $minute.= "<select name=\"minute\">";
    }
    for ($i = 0;$i < 60;$i = $i + 15) {
        if ($i < 10) {
            $optionValue = '0' . $i;
        } else {
            $optionValue = $i;
        }
        $minute.= "<option value=\"$optionValue\">$optionValue</option>";
    }
    $minute.= "</select>";
    if (strlen($minuteSelected) > 0) {
        $minute = str_replace('value="' . $minuteSelected . '"', 'value="' . $minuteSelected . '" selected="selected"', $minute);
    }
    return $minute;
}
// *************************AM / PM PULL DOWN MENU*************************
function select_ampm($getName = "") {
    global $AMPM_SELECTED;
    if (isset($_POST['ampm'])) {
        $ampmSelected = $_POST['ampm'];
    } else if (isset($AMPM_SELECTED)) {
        $ampmSelected = $AMPM_SELECTED;
    } else {
        $ampmSelected = "PM";
    }
    $ampm = "";
    if ($getName == "1") {
        $ampm.= "<select name=\"ampm\">";
    }
    $ampm.= "<option value=\"AM\">AM</option>";
    $ampm.= "<option value=\"PM\">PM</option>";
    $ampm.= "</select>";
    $ampm = str_replace('value="' . $ampmSelected . '"', 'value="' . $ampmSelected . '" selected="selected"', $ampm);
    return $ampm;
}
// *************************STATE PULL DOWN MENU*************************
function select_state() {
    $state = "";
    $state.= "<select name=\"state\">";
    $state.= "<option></option>";
    $state.= "<option value=\"AL\">Alabama</option>";
    $state.= "<option value=\"AK\">Alaska</option>";
    $state.= "<option value=\"AZ\">Arizona</option>";
    $state.= "<option value=\"AR\">Arkansas</option>";
    $state.= "<option value=\"CA\">California</option>";
    $state.= "<option value=\"CO\">Colorado</option>";
    $state.= "<option value=\"CT\">Connecticut</option>";
    $state.= "<option value=\"DE\">Delaware</option>";
    $state.= "<option value=\"DC\">District of Columbia</option>";
    $state.= "<option value=\"FL\">Florida</option>";
    $state.= "<option value=\"GA\">Georgia</option>";
    $state.= "<option value=\"HI\">Hawaii</option>";
    $state.= "<option value=\"ID\">Idaho</option>";
    $state.= "<option value=\"IL\">Illinois</option>";
    $state.= "<option value=\"IN\">Indiana</option>";
    $state.= "<option value=\"IA\">Iowa</option>";
    $state.= "<option value=\"KS\">Kansas</option>";
    $state.= "<option value=\"KY\">Kentucky</option>";
    $state.= "<option value=\"LA\">Louisiana</option>";
    $state.= "<option value=\"ME\">Maine</option>";
    $state.= "<option value=\"MD\">Maryland</option>";
    $state.= "<option value=\"MA\">Massachusetts</option>";
    $state.= "<option value=\"MI\">Michigan</option>";
    $state.= "<option value=\"MN\">Minnesota</option>";
    $state.= "<option value=\"MS\">Mississippi</option>";
    $state.= "<option value=\"MO\">Missouri</option>";
    $state.= "<option value=\"MT\">Montana</option>";
    $state.= "<option value=\"NE\">Nebraska</option>";
    $state.= "<option value=\"NV\">Nevada</option>";
    $state.= "<option value=\"NH\">New Hampshire</option>";
    $state.= "<option value=\"NJ\">New Jersey</option>";
    $state.= "<option value=\"NM\">New Mexico</option>";
    $state.= "<option value=\"NY\">New York</option>";
    $state.= "<option value=\"NC\">North Carolina</option>";
    $state.= "<option value=\"ND\">North Dakota</option>";
    $state.= "<option value=\"OH\">Ohio</option>";
    $state.= "<option value=\"OK\">Oklahoma</option>";
    $state.= "<option value=\"OR\">Oregon</option>";
    $state.= "<option value=\"PA\">Pennsylvania</option>";
    $state.= "<option value=\"RI\">Rhode Island</option>";
    $state.= "<option value=\"SC\">South Carolina</option>";
    $state.= "<option value=\"SD\">South Dakota</option>";
    $state.= "<option value=\"TN\">Tennessee</option>";
    $state.= "<option value=\"TX\">Texas</option>";
    $state.= "<option value=\"UT\">Utah</option>";
    $state.= "<option value=\"VT\">Vermont</option>";
    $state.= "<option value=\"VA\">Virginia</option>";
    $state.= "<option value=\"WA\">Washington</option>";
    $state.= "<option value=\"WV\">West Virginia</option>";
    $state.= "<option value=\"WI\">Wisconsin</option>";
    $state.= "<option value=\"WY\">Wyoming</option>";
    $state.= "</select>";
    return $state;
}
// *************************GENDER PULL DOWN MENU*************************
function select_gender() {
    $gender_select = "<select name=\"gender\">";
    $gender_select.= "<option>Select Gender</option>";
    $gender_select.= "<option value=\"M\">Male</option>";
    $gender_select.= "<option value=\"F\">Female</option>";
    $gender_select.= "</select>";
    return $gender_select;
}
// *************************SEASON MENU*************************
function select_season() {
    global $Link;
    global $SEASON;
    $select = 'SELECT * FROM ' . SEASONS . ' ORDER BY seasonName';
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $season_select = '<select name="season" id="season">';
    if ($result && mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            if ($row['seasonId'] == $SEASON) {
                $season_select.= '<option value="' . $row['seasonId'] . '" selected="selected">' . $row['seasonName'] . '</option>';
            } else {
                $season_select.= '<option value="' . $row['seasonId'] . '">' . $row['seasonName'] . '</option>';
            }
        }
    } else {
        $season_select.= '<option></option>';
    }
    $season_select.= '</select>';
    return $season_select;
}
// *************************SKILL MENU*************************
function select_skill_level($skill_selected = 3) {
    global $Link;
    #global $SEASON;
    $select = 'SELECT * FROM ' . SKILLLEVELS . ' ORDER BY skillLevelID';
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $skill_select = '<select name="skilllevel" id="skilllevel">';
    if ($result && mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            if ($row['skillLevelID'] == $skill_selected) {
                $skill_select.= '<option value="' . $row['skillLevelID'] . '" selected="selected">' . $row['skillLevelName'] . '</option>';
            } else {
                $skill_select.= '<option value="' . $row['skillLevelID'] . '">' . $row['skillLevelName'] . '</option>';
            }
        }
    } else {
        $skill_select.= '<option></option>';
    }
    $skill_select.= '</select>';
    return $skill_select;
}
// *************************PRIORITY MENU*************************
function select_priority($priority = "") {
    if (isset($priority) && $priority > 0) {
        // Do nothing
        
    } else {
        $priority = 5;
    }
    $priority_select = '<select name="priority" id="priority">';
    for ($i = 1;$i < 6;$i++) {
        if ($i == $priority) {
            $priority_select.= '<option value="' . $i . '" selected="selected">' . $i . '</option>';
        } else {
            $priority_select.= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    $priority_select.= '</select>';
    return $priority_select;
}
// *************************COLOR MENU*************************
function select_color($selectMenuName = "", $colorSelected = "") {
    if (!isset($colorSelected)) {
        $colorSelected = "000000";
    }
    $colorArray = array(array('AQUA', '00FFFF'), array('BLACK', '000000'), array('BLUE', '0000FF'), array('FUCHSIA', 'FF00FF'), array('GRAY', '808080'), array('GREEN', '009900'), array('LIME', '00FF00'), array('LT BLUE', '99CCFF'), array('MAROON', '800000'), array('NAVY', '000080'), array('OLIVE', '808000'), array('ORANGE', 'FF6600'), array('PURPLE', '663399'), array('RED', 'FF0000'), array('SILVER', 'C0C0C0'), array('TEAL', '008080'), array('WHITE', 'FFFFFF'), array('YELLOW', 'FFFF00'));
    $color_select = '<select name="' . $selectMenuName . '" id="' . $selectMenuName . '">';
    for ($color = 0;$color < count($colorArray);$color++) {
        if ($colorArray[$color][1] == $colorSelected) {
            $color_select.= '<option value="' . $colorArray[$color][1] . '" selected="selected">' . $colorArray[$color][0] . '</option>';
        } else {
            $color_select.= '<option value="' . $colorArray[$color][1] . '">' . $colorArray[$color][0] . '</option>';
        }
    }
    $color_select.= '</select>';
    return $color_select;
}
?>
