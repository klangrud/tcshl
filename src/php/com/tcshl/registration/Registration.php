<?php
/*
 * Created on Sep 24, 2009
 *
 * This is the Registration object.  The object will attempt to load a registration into memory, otherwise it creates a new registration in memory.
 * Once loaded, that registration can be updated or inserted into the database.
*/
class Registration {
    private $registrationID;
    private $seasonID;
    private $playerID;
    private $fName;
    private $lName;
    private $addressOne;
    private $addressTwo;
    private $city;
    private $state;
    private $postalCode;
    private $eMail;
    private $position;
    private $jerseySize;
    private $jerseyNumberOne;
    private $jerseyNumberTwo;
    private $jerseyNumberThree;
    private $homePhone;
    private $workPhone;
    private $cellPhone;
    private $skillLevel;
    private $wantToSub;
    private $subSunday;
    private $subMonday;
    private $subTuesday;
    private $subWednesday;
    private $subThursday;
    private $subFriday;
    private $subSaturday;
    private $travelingWithWho;
    private $wantToBeATeamRep;
    private $wantToBeARef;
    private $paymentPlan;
    private $notes;
    private $registrationApproved;
    private $drilLeague;
    private $payToday;
    private $usaHockeyMembership;
    // Misc Attributes
    private $formErrors;
    private $formSuccess;
    function __construct($registrationID) {
        $this->registrationID = (int)$registrationID;
        $this->seasonID = (int)get_site_variable_value('SEASON');
        $this->playerID = (int)0;
        $this->fName = (string)'';
        $this->lName = (string)'';
        $this->addressOne = (string)'';
        $this->addressTwo = (string)'';
        $this->city = (string)'';
        $this->state = (string)'';
        $this->postalCode = (string)'';
        $this->eMail = (string)'';
        $this->position = (string)'';
        $this->jerseySize = (string)'';
        $this->jerseyNumberOne = (int)0;
        $this->jerseyNumberTwo = (int)0;
        $this->jerseyNumberThree = (int)0;
        $this->homePhone = (string)'';
        $this->workPhone = (string)'';
        $this->cellPhone = (string)'';
        $this->skillLevel = (int)0;
        $this->wantToSub = (int)0;
        $this->subSunday = (int)0;
        $this->subMonday = (int)0;
        $this->subTuesday = (int)0;
        $this->subWednesday = (int)0;
        $this->subThursday = (int)0;
        $this->subFriday = (int)0;
        $this->subSaturday = (int)0;
        $this->travelingWithWho = (string)'';
        $this->wantToBeATeamRep = (int)0;
        $this->wantToBeARef = (int)0;
        $this->paymentPlan = (int)0;
        $this->notes = (string)'';
        $this->registrationApproved = (int)0;
        $this->drilLeague = (int)0;
        $this->payToday = (int)0;
        $this->usaHockeyMembership = (string)'';
        $this->formErrors = array();
        $this->formSuccess = array();
        if ($this->registrationID != 0) {
            $this->load_registration();
        }
    }
    function load_registration() {
        $query = 'SELECT * FROM ' . REGISTRATION . ' WHERE registrationId=' . $this->registrationID;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            while ($registration = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $this->seasonID = $registration['seasonId'];
                $this->playerID = $registration['playerId'];
                $this->fName = $registration['fName'];
                $this->lName = $registration['lName'];
                $this->addressOne = $registration['addressOne'];
                $this->addressTwo = $registration['addressTwo'];
                $this->city = $registration['city'];
                $this->state = $registration['state'];
                $this->postalCode = $registration['postalCode'];
                $this->eMail = $registration['eMail'];
                $this->position = $registration['position'];
                $this->jerseySize = $registration['jerseySize'];
                $this->jerseyNumberOne = $registration['jerseyNumberOne'];
                $this->jerseyNumberTwo = $registration['jerseyNumberTwo'];
                $this->jerseyNumberThree = $registration['jerseyNumberThree'];
                $this->homePhone = $registration['homePhone'];
                $this->workPhone = $registration['workPhone'];
                $this->cellPhone = $registration['cellPhone'];
                $this->skillLevel = $registration['skillLevel'];
                $this->wantToSub = $registration['wantToSub'];
                $this->subSunday = $registration['subSunday'];
                $this->subMonday = $registration['subMonday'];
                $this->subTuesday = $registration['subTuesday'];
                $this->subWednesday = $registration['subWednesday'];
                $this->subThursday = $registration['subThursday'];
                $this->subFriday = $registration['subFriday'];
                $this->subSaturday = $registration['subSaturday'];
                $this->travelingWithWho = $registration['travelingWithWho'];
                $this->wantToBeATeamRep = $registration['wantToBeATeamRep'];
                $this->wantToBeARef = $registration['wantToBeARef'];
                $this->paymentPlan = $registration['paymentPlan'];
                $this->payToday = $registration['payToday'];
                $this->notes = $registration['notes'];
                $this->registrationApproved = $registration['registrationApproved'];
                $this->drilLeague = $registration['drilLeague'];
                $this->usaHockeyMembership = $registration['usaHockeyMembership'];
            }
        }
    }
    function update_registration() {
        $query = 'UPDATE ' . REGISTRATION;
        $query.= ' SET ';
        $query.= ' seasonId = ' . $this->get_seasonID() . ',';
        $query.= ' playerId = ' . $this->get_playerID() . ',';
        $query.= ' fName = "' . $this->get_fName() . '",';
        $query.= ' lName = "' . $this->get_lName() . '",';
        $query.= ' addressOne = "' . $this->get_addressOne() . '",';
        $query.= ' addressTwo = "' . $this->get_addressTwo() . '",';
        $query.= ' city = "' . $this->get_city() . '",';
        $query.= ' state = "' . $this->get_state() . '",';
        $query.= ' postalCode = "' . $this->get_postalCode() . '",';
        $query.= ' eMail = "' . $this->get_eMail() . '",';
        $query.= ' position = "' . $this->get_position() . '",';
        $query.= ' jerseySize = "' . $this->get_jerseySize() . '",';
        $query.= ' jerseyNumberOne = ' . $this->get_jerseyNumberOne() . ',';
        $query.= ' jerseyNumberTwo = ' . $this->get_jerseyNumberTwo() . ',';
        $query.= ' jerseyNumberThree = ' . $this->get_jerseyNumberThree() . ',';
        $query.= ' homePhone = "' . $this->get_homePhone() . '",';
        $query.= ' workPhone = "' . $this->get_workPhone() . '",';
        $query.= ' cellPhone = "' . $this->get_cellPhone() . '",';
        $query.= ' skillLevel = ' . $this->get_skillLevel() . ',';
        $query.= ' wantToSub = ' . $this->get_wantToSub() . ',';
        $query.= ' subSunday = ' . $this->get_subSunday() . ',';
        $query.= ' subMonday = ' . $this->get_subMonday() . ',';
        $query.= ' subTuesday = ' . $this->get_subTuesday() . ',';
        $query.= ' subWednesday = ' . $this->get_subWednesday() . ',';
        $query.= ' subThursday = ' . $this->get_subThursday() . ',';
        $query.= ' subFriday = ' . $this->get_subFriday() . ',';
        $query.= ' subSaturday = ' . $this->get_subSaturday() . ',';
        $query.= ' travelingWithWho = "' . $this->get_travelingWithWho() . '",';
        $query.= ' wantToBeATeamRep = ' . $this->get_wantToBeATeamRep() . ',';
        $query.= ' wantToBeARef = ' . $this->get_wantToBeARef() . ',';
        $query.= ' paymentPlan = ' . $this->get_paymentPlan() . ',';
        $query.= ' notes = "' . $this->get_notes() . '",';
        $query.= ' registrationApproved = ' . $this->get_registrationApproved() . ',';
        $query.= ' drilLeague = ' . $this->get_drilLeague() . ',';
        $query.= ' payToday = ' . $this->get_payToday() . ',';
        $query.= ' usaHockeyMembership = "' . $this->get_usaHockeyMembership() . '"';
        $query.= ' WHERE registrationId=' . $this->get_registrationID();
        // Update Registration
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->formSuccess[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' updated successfully!';
        } else {
            $this->formErrors[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' NOT updated!  Try again or notify TCSHL.com administrator.';
        }
        // Update Player Associated with Registration
        if ($this->get_playerID() > 0) {
            $query = 'UPDATE ' . PLAYER;
            $query.= ' SET ';
            $query.= ' playerSkillLevel = ' . $this->get_skillLevel();
            $query.= ' WHERE playerID=' . $this->get_playerID();
            $query.= ' AND registrationId=' . $this->get_registrationID();
            mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
            if (validResult()) {
                $this->formSuccess[] = 'Player associated with this registration updated successfully!';
            } else {
                $this->formErrors[] = 'Player associated with this registration NOT updated!  Try again or notify TCSHL.com administrator.';
            }
        }
    }
    function insert_registration() {
        $columns = '`seasonId`,`playerId`,`fName`,`lName`,`addressOne`,`addressTwo`,`city`,`state`,`postalCode`,`eMail`,`position`,`jerseySize`,`jerseyNumberOne`,`jerseyNumberTwo`,`jerseyNumberThree`,`homePhone`,`workPhone`,`cellPhone`,`skillLevel`,`wantToSub`,`subSunday`,`subMonday`,`subTuesday`,`subWednesday`,`subThursday`,`subFriday`,`subSaturday`,`travelingWithWho`,`wantToBeATeamRep`,`wantToBeARef`,`paymentPlan`,`notes`,`registrationApproved`,`drilLeague`,`payToday`,`usaHockeyMembership`';
        $query = 'INSERT INTO ' . REGISTRATION . ' (' . $columns . ') ';
        $query.= 'VALUES(';
        $query.= $this->get_seasonID() . ',';
        $query.= $this->get_playerID() . ',';
        $query.= '"' . $this->get_fName() . '",';
        $query.= '"' . $this->get_lName() . '",';
        $query.= '"' . $this->get_addressOne() . '",';
        $query.= '"' . $this->get_addressTwo() . '",';
        $query.= '"' . $this->get_city() . '",';
        $query.= '"' . $this->get_state() . '",';
        $query.= '"' . $this->get_postalCode() . '",';
        $query.= '"' . $this->get_eMail() . '",';
        $query.= '"' . $this->get_position() . '",';
        $query.= '"' . $this->get_jerseySize() . '",';
        $query.= $this->get_jerseyNumberOne() . ',';
        $query.= $this->get_jerseyNumberTwo() . ',';
        $query.= $this->get_jerseyNumberThree() . ',';
        $query.= '"' . $this->get_homePhone() . '",';
        $query.= '"' . $this->get_workPhone() . '",';
        $query.= '"' . $this->get_cellPhone() . '",';
        $query.= $this->get_skillLevel() . ',';
        $query.= $this->get_wantToSub() . ',';
        $query.= $this->get_subSunday() . ',';
        $query.= $this->get_subMonday() . ',';
        $query.= $this->get_subTuesday() . ',';
        $query.= $this->get_subWednesday() . ',';
        $query.= $this->get_subThursday() . ',';
        $query.= $this->get_subFriday() . ',';
        $query.= $this->get_subSaturday() . ',';
        $query.= '"' . $this->get_travelingWithWho() . '",';
        $query.= $this->get_wantToBeATeamRep() . ',';
        $query.= $this->get_wantToBeARef() . ',';
        $query.= $this->get_paymentPlan() . ',';
        $query.= '"' . $this->get_notes() . '",';
        $query.= $this->get_registrationApproved() . ',';
        $query.= $this->get_drilLeague() . ',';
        $query.= $this->get_payToday() . ',';
        $query.= '"' . $this->get_usaHockeyMembership() . '"';
        $query.= ')';
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->set_registrationID(mysql_insert_id());
            $this->formSuccess[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' created successfully!';
        } else {
            $this->formErrors[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' NOT created!  Try again or notify TCSHL.com administrator.';
        }
    }
    function delete_registration() {
        $query = 'DELETE FROM ' . REGISTRATION . ' WHERE registrationId=' . $this->get_registrationID();
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->formSuccess[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' deleted successfully!';
        } else {
            $this->formErrors[] = 'Registration for ' . $this->get_fName() . ' ' . $this->get_lName() . ' NOT deleted!  Try again or notify TCSHL.com administrator.';
        }
    }
    function formPreLoad($smarty) {
        $smarty->assign('fn', $this->get_fName());
        $smarty->assign('ln', $this->get_lName());
        $smarty->assign('a1', $this->get_addressOne());
        $smarty->assign('a2', $this->get_addressTwo());
        $smarty->assign('cy', $this->get_city());
        $smarty->assign('state', $this->get_state());
        $smarty->assign('pc', $this->get_postalCode());
        $smarty->assign('em', $this->get_eMail());
        $smarty->assign('hp', $this->get_homePhone());
        $smarty->assign('wp', $this->get_workPhone());
        $smarty->assign('cp', $this->get_cellPhone());
        /** - This is no longer required.  Positions is now a radio button select.
         if(substr_count($this->get_position(),'G') > 0)
         $smarty->assign('gl','checked="checked"');
         if(substr_count($this->get_position(),'D') > 0)
         $smarty->assign('df','checked="checked"');
         if(substr_count($this->get_position(),'C') > 0)
         $smarty->assign('cr','checked="checked"');
         if(substr_count($this->get_position(),'W') > 0)
         $smarty->assign('wg','checked="checked"');
         */
        if ($this->get_position() == 'Forward') {
            $smarty->assign('fw', 'CHECKED');
        } else if ($this->get_position() == 'Defense') {
            $smarty->assign('df', 'CHECKED');
        } else if ($this->get_position() == 'Goalie') {
            $smarty->assign('gl', 'CHECKED');
        } else {
            $smarty->assign('fw', 'CHECKED');
        }
        if ($this->get_jerseySize() == 'L') $smarty->assign('jsl', 'CHECKED');
        if ($this->get_jerseySize() == 'XL') $smarty->assign('jsxl', 'CHECKED');
        if ($this->get_jerseySize() == 'XXL') $smarty->assign('jsxxl', 'CHECKED');
        if ($this->get_jerseySize() == 'GOALIE') $smarty->assign('jsgoalie', 'CHECKED');
        $smarty->assign('j1', $this->get_jerseyNumberOne());
        $smarty->assign('j2', $this->get_jerseyNumberTwo());
        $smarty->assign('j3', $this->get_jerseyNumberThree());
        if ($this->get_skillLevel() == 1) $smarty->assign('sl1', 'CHECKED');
        if ($this->get_skillLevel() == 2) $smarty->assign('sl2', 'CHECKED');
        if ($this->get_skillLevel() == 3) $smarty->assign('sl3', 'CHECKED');
        if ($this->get_skillLevel() == 4) $smarty->assign('sl4', 'CHECKED');
        if ($this->get_skillLevel() == 5) $smarty->assign('sl5', 'CHECKED');
        $smarty->assign('tw', $this->get_travelingWithWho());
        $smarty->assign('an', $this->get_notes());
        if ($this->get_wantToSub() == 1) $smarty->assign('ys', 'CHECKED'); // Will sub = yes
        else $smarty->assign('ns', 'CHECKED'); // Will NOT sub
        if ($this->get_subSunday() == 1) $smarty->assign('su', 'checked="checked"');
        if ($this->get_subMonday() == 1) $smarty->assign('sm', 'checked="checked"');
        if ($this->get_subTuesday() == 1) $smarty->assign('st', 'checked="checked"');
        if ($this->get_subWednesday() == 1) $smarty->assign('sw', 'checked="checked"');
        if ($this->get_subThursday() == 1) $smarty->assign('sh', 'checked="checked"');
        if ($this->get_subFriday() == 1) $smarty->assign('sf', 'checked="checked"');
        if ($this->get_subSaturday() == 1) $smarty->assign('ss', 'checked="checked"');
        if ($this->get_wantToBeATeamRep() == 1) $smarty->assign('yr', 'CHECKED'); // Will be a team rep
        else $smarty->assign('nt', 'CHECKED'); // Will NOT be a team rep
        if ($this->get_wantToBeARef() == 1) $smarty->assign('wr', 'CHECKED'); // Will referee
        else $smarty->assign('nr', 'CHECKED'); // Will NOT referee
        if ($this->get_PaymentPlan() == 1) {
            $smarty->assign('p1', 'CHECKED'); // Payment Plan I
            $smarty->assign('p2', ''); // Payment Plan II
            $smarty->assign('p3', ''); // Payment Plan III
            $smarty->assign('p4', ''); // Payment Plan IV
            $smarty->assign('p5', ''); // DRIL Payment Plan
            
        }
        if ($this->get_PaymentPlan() == 2) {
            $smarty->assign('p2', 'CHECKED'); // Payment Plan II
            $smarty->assign('p1', ''); // Payment Plan I
            $smarty->assign('p3', ''); // Payment Plan III
            $smarty->assign('p4', ''); // Payment Plan IV
            $smarty->assign('p5', ''); // DRIL Payment Plan
            
        }
        if ($this->get_PaymentPlan() == 3) {
            $smarty->assign('p3', 'CHECKED'); // Payment Plan III
            $smarty->assign('p1', ''); // Payment Plan I
            $smarty->assign('p2', ''); // Payment Plan II
            $smarty->assign('p4', ''); // Payment Plan IV
            $smarty->assign('p5', ''); // DRIL Payment Plan
            
        }
        if ($this->get_PaymentPlan() == 4) {
            $smarty->assign('p4', 'CHECKED'); // Payment Plan IV
            $smarty->assign('p1', ''); // Payment Plan I
            $smarty->assign('p2', ''); // Payment Plan II
            $smarty->assign('p3', ''); // Payment Plan III
            $smarty->assign('p5', ''); // DRIL Payment Plan
            
        }
        if ($this->get_PaymentPlan() == 5) {
            $smarty->assign('p5', 'CHECKED'); // DRIL Payment Plan
            $smarty->assign('p1', ''); // Payment Plan I
            $smarty->assign('p2', ''); // Payment Plan II
            $smarty->assign('p3', ''); // Payment Plan III
            $smarty->assign('p4', ''); // Payment Plan IV
            
        }
        if ($this->get_drilLeague() == 1) $smarty->assign('dl1', 'CHECKED');
        else if ($this->get_drilLeague() == 2) $smarty->assign('dl2', 'CHECKED');
        else if ($this->get_drilLeague() == 3) $smarty->assign('dl3', 'CHECKED');
        else $smarty->assign('dl1', 'CHECKED');
        if ($this->get_payToday() == 1) $smarty->assign('pt', 'checked="checked"');
        $smarty->assign('uhm', $this->get_usaHockeyMembership());
    }
    /*
     * Handle reposts.. It is a long form to have to fill out again, plus much can be overlooked.
    */
    function formReposts($smarty) {
        if ($_POST) {
            if (isset($_POST['firstname']) && $_POST['firstname']) {
                $smarty->assign('fn', format_uppercase_text($_POST['firstname']));
            }
            if (isset($_POST['lastname']) && $_POST['lastname']) {
                $smarty->assign('ln', format_uppercase_text($_POST['lastname']));
            }
            if (isset($_POST['addressOne']) && $_POST['addressOne']) {
                $smarty->assign('a1', $_POST['addressOne']);
            }
            if (isset($_POST['addressTwo']) && $_POST['addressTwo']) {
                $smarty->assign('a2', $_POST['addressTwo']);
            }
            if (isset($_POST['city']) && $_POST['city']) {
                $smarty->assign('cy', format_uppercase_text($_POST['city']));
            }
            if (isset($_POST['state']) && $_POST['state']) {
                $smarty->assign('state', format_uppercase_text($_POST['state']));
            }
            if (isset($_POST['postalCode']) && $_POST['postalCode']) {
                $smarty->assign('pc', format_uppercase_text($_POST['postalCode']));
            }
            if (isset($_POST['email']) && $_POST['email']) {
                $smarty->assign('em', format_trim(strtolower($_POST['email'])));
            }
            if (isset($_POST['homePhone']) && $_POST['homePhone']) {
                $smarty->assign('hp', $_POST['homePhone']);
            }
            if (isset($_POST['workPhone']) && $_POST['workPhone']) {
                $smarty->assign('wp', $_POST['workPhone']);
            }
            if (isset($_POST['cellPhone']) && $_POST['cellPhone']) {
                $smarty->assign('cp', $_POST['cellPhone']);
            }
            /** - This is no longer required.  Positions is now a radio button select.
             if (isset($_POST['goalie']) && $_POST['goalie'] == "on") {
             $smarty->assign('gl','checked="checked"');
             }
             if (isset($_POST['defense']) && $_POST['defense'] == "on") {
             $smarty->assign('df','checked="checked"');
             }
             if (isset($_POST['center']) && $_POST['center'] == "on") {
             $smarty->assign('cr','checked="checked"');
             }
             if (isset($_POST['wing']) && $_POST['wing'] == "on") {
             $smarty->assign('wg','checked="checked"');
             }
             */
            if (isset($_POST['position']) && $_POST['position'] == "Forward") {
                $smarty->assign('fw', 'CHECKED');
            } else if (isset($_POST['position']) && $_POST['position'] == "Defense") {
                $smarty->assign('df', 'CHECKED');
            } else if (isset($_POST['position']) && $_POST['position'] == "Goalie") {
                $smarty->assign('gl', 'CHECKED');
            } else {
                $smarty->assign('fw', 'CHECKED');
            }
            if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "L") {
                $smarty->assign('jsl', 'CHECKED');
            } else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "XL") {
                $smarty->assign('jsxl', 'CHECKED');
            } else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "XXL") {
                $smarty->assign('jsxxl', 'CHECKED');
            } else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "GOALIE") {
                $smarty->assign('jsgoalie', 'CHECKED');
            } else {
                $smarty->assign('jsxl', 'CHECKED');
            }
            if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne']) || $_POST['jerseyNumChoiceOne'] == 0) {
                $smarty->assign('j1', $_POST['jerseyNumChoiceOne']);
            }
            if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0) {
                $smarty->assign('j2', $_POST['jerseyNumChoiceTwo']);
            }
            if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree']) || $_POST['jerseyNumChoiceThree'] == 0) {
                $smarty->assign('j3', $_POST['jerseyNumChoiceThree']);
            }
            if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "1") {
                $smarty->assign('sl1', 'CHECKED');
            } else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "2") {
                $smarty->assign('sl2', 'CHECKED');
            } else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "3") {
                $smarty->assign('sl3', 'CHECKED');
            } else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "4") {
                $smarty->assign('sl4', 'CHECKED');
            } else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "5") {
                $smarty->assign('sl5', 'CHECKED');
            } else {
                $smarty->assign('sl3', 'CHECKED');
            }
            if (isset($_POST['travelWith']) && $_POST['travelWith']) {
                $smarty->assign('tw', $_POST['travelWith']);
            }
            if (isset($_POST['additionalNotes']) && $_POST['additionalNotes']) {
                $smarty->assign('an', $_POST['additionalNotes']);
            }
            if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
                $smarty->assign('ys', 'CHECKED'); // Will sub = yes
                $smarty->assign('ns', ''); // Will sub = no
                if (isset($_POST['sunSub']) && $_POST['sunSub'] == "on") {
                    $smarty->assign('su', 'checked="checked"');
                }
                if (isset($_POST['monSub']) && $_POST['monSub'] == "on") {
                    $smarty->assign('sm', 'checked="checked"');
                }
                if (isset($_POST['tueSub']) && $_POST['tueSub'] == "on") {
                    $smarty->assign('st', 'checked="checked"');
                }
                if (isset($_POST['wedSub']) && $_POST['wedSub'] == "on") {
                    $smarty->assign('sw', 'checked="checked"');
                }
                if (isset($_POST['thuSub']) && $_POST['thuSub'] == "on") {
                    $smarty->assign('sh', 'checked="checked"');
                }
                if (isset($_POST['friSub']) && $_POST['friSub'] == "on") {
                    $smarty->assign('sf', 'checked="checked"');
                }
                if (isset($_POST['satSub']) && $_POST['satSub'] == "on") {
                    $smarty->assign('ss', 'checked="checked"');
                }
            }
            if (isset($_POST['teamRep']) && $_POST['teamRep'] == "Y") {
                $smarty->assign('yr', 'CHECKED'); // Will be a team rep
                $smarty->assign('nt', ''); // Will not be a team rep
                
            } else {
                $smarty->assign('yr', ''); // Will be a team rep
                $smarty->assign('nt', 'CHECKED'); // Will not be a team rep
                
            }
            if (isset($_POST['referee']) && $_POST['referee'] == "Y") {
                $smarty->assign('wr', 'CHECKED'); // Will referee
                $smarty->assign('nr', ''); // Will not referee
                
            } else {
                $smarty->assign('wr', ''); // Will referee
                $smarty->assign('nr', 'CHECKED'); // Will not referee
                
            }
            if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "2") {
                $smarty->assign('p2', 'CHECKED'); // Payment Plan II
                $smarty->assign('p1', ''); // Payment Plan I
                $smarty->assign('p3', ''); // Payment Plan III
                $smarty->assign('p4', ''); // Payment Plan IV
                
            } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "3") {
                $smarty->assign('p3', 'CHECKED'); // Payment Plan III
                $smarty->assign('p1', ''); // Payment Plan I
                $smarty->assign('p2', ''); // Payment Plan II
                $smarty->assign('p4', ''); // Payment Plan IV
                
            } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "4") {
                $smarty->assign('p4', 'CHECKED'); // Payment Plan IV
                $smarty->assign('p1', ''); // Payment Plan I
                $smarty->assign('p2', ''); // Payment Plan II
                $smarty->assign('p3', ''); // Payment Plan III
                
            } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "5") {
                $smarty->assign('p5', 'CHECKED'); // DRIL Payment Plan
                $smarty->assign('p1', ''); // Payment Plan I
                $smarty->assign('p2', ''); // Payment Plan II
                $smarty->assign('p3', ''); // Payment Plan III
                $smarty->assign('p4', ''); // Payment Plan IV
                
            }
            if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "1") {
                $smarty->assign('dl1', 'CHECKED');
            } else if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "2") {
                $smarty->assign('dl2', 'CHECKED');
            } else if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "3") {
                $smarty->assign('dl3', 'CHECKED');
            } else {
                $smarty->assign('dl1', 'CHECKED');
            }
            if (isset($_POST['payToday']) && $_POST['payToday'] == "on") {
                $smarty->assign('pt', 'checked="checked"');
            }
            if (isset($_POST['usaHockeyMembership']) && $_POST['usaHockeyMembership']) {
                $smarty->assign('uhm', format_trim(strtoupper($_POST['usaHockeyMembership'])));
            }
        }
    }
    /*
     * Validate this information being provided .. just expect the worse sometimes
    */
    function formValidation() {
        #Firstname Validation
        if (isset($_POST['firstname']) && $_POST['firstname']) {
            if (strlen($_POST['firstname']) < 2) {
                $this->formErrors[] = "First name must be at least 2 characters long.";
            }
            if (!valid_text($_POST['firstname'])) {
                $this->formErrors[] = "First name contains invalid characters. Check for quotes.";
            }
        } else {
            $this->formErrors[] = "First name is a required field";
        }
        #Lastname Validation
        if (isset($_POST['lastname']) && $_POST['lastname']) {
            if (strlen($_POST['lastname']) < 2) {
                $this->formErrors[] = "Last name must be at least 2 characters long.";
            }
            if (!valid_text($_POST['lastname'])) {
                $this->formErrors[] = "Last name contains invalid characters. Check for quotes.";
            }
        } else {
            $this->formErrors[] = "Last name is a required field";
        }
        #Address One Validation
        if (isset($_POST['addressOne']) && $_POST['addressOne']) {
            //Do nothing  .. Not doing any AVS checks, so hopefully they give us a good address
            
        } else {
            $this->formErrors[] = "Address Field One is required";
        }
        #City Validation
        if (isset($_POST['city']) && $_POST['city']) {
            //Do nothing  .. Not doing any AVS checks, so hopefully they give us a good city
            
        } else {
            $this->formErrors[] = "City is required";
        }
        #State Validation
        if (isset($_POST['state']) && $_POST['state']) {
            //Do nothing  .. Not doing any AVS checks, so hopefully they give us a good state
            
        } else {
            $this->formErrors[] = "State is required";
        }
        #Postal Code Validation
        if (isset($_POST['postalCode']) && $_POST['postalCode']) {
            //Do nothing  .. Not doing any AVS checks, so hopefully they give us a good zip
            
        } else {
            $this->formErrors[] = "Zipcode is required";
        }
        #Email Validation
        if (isset($_POST['email']) && $_POST['email']) {
            if (validate_email(format_trim($_POST['email']))) {
                //Do nothing .. its a valid email, i guess
                
            } else {
                $this->formErrors[] = "Email is not valid.";
            }
        }
        #Position Validation
        
        /** - This is no longer required because position is a radio button with a default value.
         if ((isset($_POST['goalie']) && $_POST['goalie'] == "on")
         || (isset($_POST['defense']) && $_POST['defense'] == "on")
         || (isset($_POST['center']) && $_POST['center'] == "on")
         || (isset($_POST['wing']) && $_POST['wing'] == "on")) {
         //Do nothing .. At least one position is checked
         } else {
         $this->formErrors[] = "Must provide at least one position you would like to play. (Goalie, Defense, Center, Wing)";
         }
         */
        #Jersey Information Validation
        #Jersey Choice 1 Validation
        //(isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0
        if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne'] > - 1) || $_POST['jerseyNumChoiceOne'] == 0) {
            //if (is_numeric($_POST['jerseyNumChoiceOne']) && is_int(intval($_POST['jerseyNumChoiceOne']))) {
            if (strlen($_POST['jerseyNumChoiceOne']) == strlen(intval($_POST['jerseyNumChoiceOne']))) {
                if (intval($_POST['jerseyNumChoiceOne']) < 0 || intval($_POST['jerseyNumChoiceOne']) > 99) {
                    $this->formErrors[] = "Jersey Number Choice 1 must be between 0 - 99.";
                }
            } else {
                $this->formErrors[] = "Must provide a valid jersey number for Choice 1. (0 - 99)";
            }
        } else {
            $this->formErrors[] = "Must provide a valid jersey number for Choice 1. (0 - 99)";
        }
        #Jersey Choice 2 Validation
        if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo'] > - 1) || $_POST['jerseyNumChoiceTwo'] == 0) {
            if (strlen($_POST['jerseyNumChoiceTwo']) == strlen(intval($_POST['jerseyNumChoiceTwo']))) {
                if (intval($_POST['jerseyNumChoiceTwo']) < 0 || intval($_POST['jerseyNumChoiceTwo']) > 99) {
                    $this->formErrors[] = "Jersey Number Choice 2 must be between 0 - 99.";
                }
            } else {
                $this->formErrors[] = "Must provide a valid jersey number for Choice 2. (0 - 99)";
            }
        } else {
            $this->formErrors[] = "Must provide a valid jersey number for Choice 2. (0 - 99)";
        }
        #Jersey Choice 3 Validation
        if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree'] > - 1) || $_POST['jerseyNumChoiceThree'] == 0) {
            if (strlen($_POST['jerseyNumChoiceThree']) == strlen(intval($_POST['jerseyNumChoiceThree']))) {
                if (intval($_POST['jerseyNumChoiceThree']) < 0 || intval($_POST['jerseyNumChoiceThree']) > 99) {
                    $this->formErrors[] = "Jersey Number Choice 3 must be between 0 - 99.";
                }
            } else {
                $this->formErrors[] = "Must provide a valid jersey number for Choice 3. (0 - 99)";
            }
        } else {
            $this->formErrors[] = "Must provide a valid jersey number for Choice 3. (0 - 99)";
        }
        #Will Sub? Validation
        if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
            if ((isset($_POST['sunSub']) && $_POST['sunSub'] == "on") || (isset($_POST['monSub']) && $_POST['monSub'] == "on") || (isset($_POST['tueSub']) && $_POST['tueSub'] == "on") || (isset($_POST['wedSub']) && $_POST['wedSub'] == "on") || (isset($_POST['thuSub']) && $_POST['thuSub'] == "on") || (isset($_POST['friSub']) && $_POST['friSub'] == "on") || (isset($_POST['satSub']) && $_POST['satSub'] == "on")) {
                //Do nothing, they picked a day that they can sub
                
            } else {
                $this->formErrors[] = "Since you answered yes to: Will you sub?, you must indicate at least one day you are willing to sub.";
            }
        }
        return $this->get_formErrors();
    }
    //formProcessInsert
    function formProcessInsert() {
        $this->formProcess();
        $this->insert_registration();
        return $this->get_formErrors();
    }
    //formProcessUpdate
    function formProcessUpdate() {
        $this->formProcess();
        $this->update_registration();
        return $this->get_formErrors();
    }
    //formProcessUpdate
    function formProcessDelete() {
        $this->delete_registration();
        return $this->get_formErrors();
    }
    /*
     * Process Form Data
    */
    private function formProcess() {
        if (isset($_POST['firstname']) && $_POST['firstname']) {
            $this->set_fname(format_uppercase_text($_POST['firstname']));
        } // Required
        if (isset($_POST['lastname']) && $_POST['lastname']) {
            $this->set_lname(format_uppercase_text($_POST['lastname']));
        } // Required
        if (isset($_POST['addressOne']) && $_POST['addressOne']) {
            $this->set_addressOne(format_text($_POST['addressOne']));
        } // Required
        if (isset($_POST['addressTwo']) && $_POST['addressTwo']) {
            $this->set_addressTwo(format_text($_POST['addressTwo']));
        } else {
            $this->set_addressTwo("");
        }
        if (isset($_POST['city']) && $_POST['city']) {
            $this->set_city(format_uppercase_text($_POST['city']));
        } //Required
        if (isset($_POST['state']) && $_POST['state']) {
            $this->set_state(format_text($_POST['state']));
        } //Required
        if (isset($_POST['postalCode']) && $_POST['postalCode']) {
            $this->set_postalcode(format_text($_POST['postalCode']));
        } //Required
        if (isset($_POST['email']) && $_POST['email']) {
            $this->set_email(format_text(strtolower($_POST['email'])));
        } else {
            $this->set_email("");
        }
        if (isset($_POST['homePhone']) && $_POST['homePhone']) {
            $this->set_homephone(format_text($_POST['homePhone']));
        } else {
            $this->set_homephone("");
        }
        if (isset($_POST['workPhone']) && $_POST['workPhone']) {
            $this->set_workphone(format_text($_POST['workPhone']));
        } else {
            $this->set_workphone("");
        }
        if (isset($_POST['cellPhone']) && $_POST['cellPhone']) {
            $this->set_cellphone(format_text($_POST['cellPhone']));
        } else {
            $this->set_cellphone("");
        }
        /**
         if (isset($_POST['goalie']) && $_POST['goalie'] == "on") {
         $goalie = "Y";
         } else {
         $goalie = "N";
         }
         if (isset($_POST['defense']) && $_POST['defense'] == "on") {
         $defense = "Y";
         } else {
         $defense = "N";
         }
         if (isset($_POST['center']) && $_POST['center'] == "on") {
         $center = "Y";
         } else {
         $center = "N";
         }
         if (isset($_POST['wing']) && $_POST['wing'] == "on") {
         $wing = "Y";
         } else {
         $wing = "N";
         }
         */
        if (isset($_POST['position']) && $_POST['position']) {
            $this->set_position($_POST['position']);
        } //Required
        if (isset($_POST['jerseySize']) && $_POST['jerseySize']) {
            $this->set_jerseysize($_POST['jerseySize']);
        } //Required
        if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne']) || $_POST['jerseyNumChoiceOne'] == 0) {
            $this->set_jerseyNumberOne($_POST['jerseyNumChoiceOne']);
        } //Required
        if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0) {
            $this->set_jerseyNumberTwo($_POST['jerseyNumChoiceTwo']);
        } //Required
        if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree']) || $_POST['jerseyNumChoiceThree'] == 0) {
            $this->set_jerseyNumberThree($_POST['jerseyNumChoiceThree']);
        } //Required
        if (isset($_POST['travelWith']) && $_POST['travelWith']) {
            $this->set_travelingWithWho(format_text($_POST['travelWith']));
        } else {
            $this->set_travelingWithWho("");
        }
        if (isset($_POST['additionalNotes']) && $_POST['additionalNotes']) {
            $this->set_notes(format_text($_POST['additionalNotes']));
        } else {
            $this->set_notes("");
        }
        if (isset($_POST['skillLevel']) && $_POST['skillLevel']) {
            $this->set_skilllevel($_POST['skillLevel']);
        } //Required
        if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
            $this->set_wantToSub(1);
            if (isset($_POST['sunSub']) && $_POST['sunSub'] == "on") {
                $this->set_subSunday(1);
            } else {
                $this->set_subSunday(0);
            }
            if (isset($_POST['monSub']) && $_POST['monSub'] == "on") {
                $this->set_subMonday(1);
            } else {
                $this->set_subMonday(0);
            }
            if (isset($_POST['tueSub']) && $_POST['tueSub'] == "on") {
                $this->set_subTuesday(1);
            } else {
                $this->set_subTuesday(0);
            }
            if (isset($_POST['wedSub']) && $_POST['wedSub'] == "on") {
                $this->set_subWednesday(1);
            } else {
                $this->set_subWednesday(0);
            }
            if (isset($_POST['thuSub']) && $_POST['thuSub'] == "on") {
                $this->set_subThursday(1);
            } else {
                $this->set_subThursday(0);
            }
            if (isset($_POST['friSub']) && $_POST['friSub'] == "on") {
                $this->set_subFriday(1);
            } else {
                $this->set_subFriday(0);
            }
            if (isset($_POST['satSub']) && $_POST['satSub'] == "on") {
                $this->set_subSaturday(1);
            } else {
                $this->set_subSaturday(0);
            }
        } else {
            $this->set_wantToSub(0);
            $this->set_subSunday(0);
            $this->set_subMonday(0);
            $this->set_subTuesday(0);
            $this->set_subWednesday(0);
            $this->set_subThursday(0);
            $this->set_subFriday(0);
            $this->set_subSaturday(0);
        }
        if (isset($_POST['teamRep']) && $_POST['teamRep'] == "Y") {
            $this->set_wantToBeATeamRep(1);
        } else {
            $this->set_wantToBeATeamRep(0);
        }
        if (isset($_POST['referee']) && $_POST['referee'] == "Y") {
            $this->set_wantToBeARef(1);
        } else {
            $this->set_wantToBeARef(0);
        }
        if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "1") {
            $this->set_paymentPlan(1);
        } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "2") {
            $this->set_paymentPlan(2);
        } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "3") {
            $this->set_paymentPlan(3);
        } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "4") {
            $this->set_paymentPlan(4);
        } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "5") {
            $this->set_paymentPlan(1);
        }
        #Setup the positions comma separated value
        
        /** - This is no longer needed.  We set positions directly above.
         $positions = "";
         if($goalie == "Y") {
         if($defense == "Y" || $center == "Y" || $wing == "Y") {
         $positions .= "G, ";
         } else {
         $positions .= "G";
         }
         }
         if($defense == "Y") {
         if($center == "Y" || $wing == "Y") {
         $positions .= "D, ";
         } else {
         $positions .= "D";
         }
         }
         if($center == "Y") {
         if($wing == "Y") {
         $positions .= "C, ";
         } else {
         $positions .= "C";
         }
         }
         if($wing == "Y") {
         $positions .= "W";
         }
         $this->set_position($positions);
         */
        if (isset($_POST['drilLeague']) && $_POST['drilLeague']) {
            $this->set_drilLeague($_POST['drilLeague']);
        } //Required
        if (isset($_POST['payToday']) && $_POST['payToday'] == "on") {
            $this->set_payToday(1);
        } else {
            $this->set_payToday(0);
        }
        if (isset($_POST['usaHockeyMembership']) && $_POST['usaHockeyMembership']) {
            $this->set_usaHockeyMembership(format_trim(strtoupper($_POST['usaHockeyMembership'])));
        } else {
            $this->set_usaHockeyMembership("");
        }
    }
    /*
     * Send Admin Email - For Season Registration
    */
    function emailRegistrationAdmin() {
        require_once ('com/tcshl/mail/Mail.php');
        $ManageRegLink = DOMAIN_NAME . '/manageregistrations.php';
        $emailBody = $this->get_fName() . ' ' . $this->get_lName() . ' has just registered for TCSHL league membership.  Click on the following link to approve registration: ';
        $emailBody.= $ManageRegLink;
        //$sender,$recipients,$subject,$body
        $Mail = new Mail(REG_EMAIL, REG_EMAIL, REG_EMAIL_SUBJECT, $emailBody);
        $Mail->sendMail();
    }
    // Get set registrationID
    public function set_registrationID($registrationID) {
        $this->registrationID = $registrationID;
    }
    public function get_registrationID() {
        return $this->registrationID;
    }
    // Get set seasonID
    public function set_seasonID($seasonID) {
        $this->seasonID = $seasonID;
    }
    public function get_seasonID() {
        return $this->seasonID;
    }
    // Get set playerID
    public function set_playerID($playerID) {
        $this->playerID = $playerID;
    }
    public function get_playerID() {
        return $this->playerID;
    }
    // Get set fName
    public function set_fName($fName) {
        $this->fName = $fName;
    }
    public function get_fName() {
        return $this->fName;
    }
    // Get set lName
    public function set_lName($lName) {
        $this->lName = $lName;
    }
    public function get_lName() {
        return $this->lName;
    }
    // Get set addressOne
    public function set_addressOne($addressOne) {
        $this->addressOne = $addressOne;
    }
    public function get_addressOne() {
        return $this->addressOne;
    }
    // Get set addressTwo
    public function set_addressTwo($addressTwo) {
        $this->addressTwo = $addressTwo;
    }
    public function get_addressTwo() {
        return $this->addressTwo;
    }
    // Get set city
    public function set_city($city) {
        $this->city = $city;
    }
    public function get_city() {
        return $this->city;
    }
    // Get set state
    public function set_state($state) {
        $this->state = $state;
    }
    public function get_state() {
        return $this->state;
    }
    // Get set postalCode
    public function set_postalCode($postalCode) {
        $this->postalCode = $postalCode;
    }
    public function get_postalCode() {
        return $this->postalCode;
    }
    // Get set eMail
    public function set_eMail($eMail) {
        $this->eMail = $eMail;
    }
    public function get_eMail() {
        return $this->eMail;
    }
    // Get set position
    public function set_position($position) {
        $this->position = $position;
    }
    public function get_position() {
        return $this->position;
    }
    // Get set jerseySize
    public function set_jerseySize($jerseySize) {
        $this->jerseySize = $jerseySize;
    }
    public function get_jerseySize() {
        return $this->jerseySize;
    }
    // Get set jerseyNumberOne
    public function set_jerseyNumberOne($jerseyNumberOne) {
        $this->jerseyNumberOne = $jerseyNumberOne;
    }
    public function get_jerseyNumberOne() {
        return $this->jerseyNumberOne;
    }
    // Get set jerseyNumberTwo
    public function set_jerseyNumberTwo($jerseyNumberTwo) {
        $this->jerseyNumberTwo = $jerseyNumberTwo;
    }
    public function get_jerseyNumberTwo() {
        return $this->jerseyNumberTwo;
    }
    // Get set jerseyNumberThree
    public function set_jerseyNumberThree($jerseyNumberThree) {
        $this->jerseyNumberThree = $jerseyNumberThree;
    }
    public function get_jerseyNumberThree() {
        return $this->jerseyNumberThree;
    }
    // Get set homePhone
    public function set_homePhone($homePhone) {
        $this->homePhone = $homePhone;
    }
    public function get_homePhone() {
        return $this->homePhone;
    }
    // Get set workPhone
    public function set_workPhone($workPhone) {
        $this->workPhone = $workPhone;
    }
    public function get_workPhone() {
        return $this->workPhone;
    }
    // Get set cellPhone
    public function set_cellPhone($cellPhone) {
        $this->cellPhone = $cellPhone;
    }
    public function get_cellPhone() {
        return $this->cellPhone;
    }
    // Get set skillLevel
    public function set_skillLevel($skillLevel) {
        $this->skillLevel = $skillLevel;
    }
    public function get_skillLevel() {
        return $this->skillLevel;
    }
    // Get set wantToSub
    public function set_wantToSub($wantToSub) {
        $this->wantToSub = $wantToSub;
    }
    public function get_wantToSub() {
        return $this->wantToSub;
    }
    // Get set subSunday
    public function set_subSunday($subSunday) {
        $this->subSunday = $subSunday;
    }
    public function get_subSunday() {
        return $this->subSunday;
    }
    // Get set subMonday
    public function set_subMonday($subMonday) {
        $this->subMonday = $subMonday;
    }
    public function get_subMonday() {
        return $this->subMonday;
    }
    // Get set subTuesday
    public function set_subTuesday($subTuesday) {
        $this->subTuesday = $subTuesday;
    }
    public function get_subTuesday() {
        return $this->subTuesday;
    }
    // Get set subWednesday
    public function set_subWednesday($subWednesday) {
        $this->subWednesday = $subWednesday;
    }
    public function get_subWednesday() {
        return $this->subWednesday;
    }
    // Get set subThursday
    public function set_subThursday($subThursday) {
        $this->subThursday = $subThursday;
    }
    public function get_subThursday() {
        return $this->subThursday;
    }
    // Get set subFriday
    public function set_subFriday($subFriday) {
        $this->subFriday = $subFriday;
    }
    public function get_subFriday() {
        return $this->subFriday;
    }
    // Get set subSaturday
    public function set_subSaturday($subSaturday) {
        $this->subSaturday = $subSaturday;
    }
    public function get_subSaturday() {
        return $this->subSaturday;
    }
    // Get set travelingWithWho
    public function set_travelingWithWho($travelingWithWho) {
        $this->travelingWithWho = $travelingWithWho;
    }
    public function get_travelingWithWho() {
        return $this->travelingWithWho;
    }
    // Get set wantToBeATeamRep
    public function set_wantToBeATeamRep($wantToBeATeamRep) {
        $this->wantToBeATeamRep = $wantToBeATeamRep;
    }
    public function get_wantToBeATeamRep() {
        return $this->wantToBeATeamRep;
    }
    // Get set wantToBeARef
    public function set_wantToBeARef($wantToBeARef) {
        $this->wantToBeARef = $wantToBeARef;
    }
    public function get_wantToBeARef() {
        return $this->wantToBeARef;
    }
    // Get set paymentPlan
    public function set_paymentPlan($paymentPlan) {
        $this->paymentPlan = $paymentPlan;
    }
    public function get_paymentPlan() {
        return $this->paymentPlan;
    }
    // Get set notes
    public function set_notes($notes) {
        $this->notes = $notes;
    }
    public function get_notes() {
        return $this->notes;
    }
    // Get set registrationApproved
    public function set_registrationApproved($registrationApproved) {
        $this->registrationApproved = $registrationApproved;
    }
    public function get_registrationApproved() {
        return $this->registrationApproved;
    }
    // Get set drilLeague
    public function set_drilLeague($drilLeague) {
        $this->drilLeague = $drilLeague;
    }
    public function get_drilLeague() {
        return $this->drilLeague;
    }
    // Get set payToday
    public function set_payToday($payToday) {
        $this->payToday = $payToday;
    }
    public function get_payToday() {
        return $this->payToday;
    }
    // Get set usaHockeyMembership
    public function set_usaHockeyMembership($usaHockeyMembership) {
        $this->usaHockeyMembership = $usaHockeyMembership;
    }
    public function get_usaHockeyMembership() {
        return $this->usaHockeyMembership;
    }
    // Get $formErrors
    public function get_formErrors() {
        return (array)$this->formErrors;
    }
    // Get $formSuccess
    public function get_formSuccess() {
        return (array)$this->formSuccess;
    }
}
?>