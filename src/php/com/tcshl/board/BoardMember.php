<?php
/*
 * Created on Sep 18, 2009
 *
 * This is the BoardMember object
*/
class BoardMember {
    // Board Member Object Attributes
    private $boardMemberID;
    private $boardMemberFirstName;
    private $boardMemberLastName;
    private $boardMemberEmail;
    private $boardMemberHomePhone;
    private $boardMemberWorkPhone;
    private $boardMemberCellPhone;
    private $boardMemberDuties;
    private $boardMemberImage;
    private $boardMemberImageWidth;
    private $boardMemberImageHeight;
    // Misc Attributes
    private $boardMemberFormErrors;
    private $boardMemberFormSuccess;
    private $imageMaxWidth;
    // Constructor
    public function __construct($boardMemberID) {
        $this->boardMemberID = $boardMemberID;
        $this->boardMemberFormErrors = array();
        $this->boardMemberFormSuccess = array();
        $this->boardMemberImageWidth = 0;
        $this->boardMemberImageHeight = 0;
        $this->imageMaxWidth = 200;
        if ($this->boardMemberID != 0) {
            $this->load_boardMember();
        }
    }
    private function load_boardMember() {
        $query = 'SELECT * FROM ' . BOARDMEMBER . ' WHERE boardMemberID=' . $this->boardMemberID;
        $result = mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if ($result && mysql_num_rows($result) > 0) {
            while ($boardMember = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $this->boardMemberFirstName = $boardMember['boardMemberFirstName'];
                $this->boardMemberLastName = $boardMember['boardMemberLastName'];
                $this->boardMemberEmail = $boardMember['boardMemberEmail'];
                $this->boardMemberHomePhone = $boardMember['boardMemberHomePhone'];
                $this->boardMemberWorkPhone = $boardMember['boardMemberWorkPhone'];
                $this->boardMemberCellPhone = $boardMember['boardMemberCellPhone'];
                $this->boardMemberDuties = $boardMember['boardMemberDuties'];
                $this->boardMemberImage = $boardMember['boardMemberImage'];
                $this->boardMemberImageWidth = $boardMember['boardMemberImageWidth'];
                $this->boardMemberImageHeight = $boardMember['boardMemberImageHeight'];
            }
        }
    }
    private function update_boardMember() {
        $query = 'UPDATE ' . BOARDMEMBER;
        $query.= ' SET ';
        $query.= ' boardMemberFirstName = "' . $this->get_boardMemberFirstName() . '",';
        $query.= ' boardMemberLastName = "' . $this->get_boardMemberLastName() . '",';
        $query.= ' boardMemberEmail = "' . $this->get_boardMemberEmail() . '",';
        $query.= ' boardMemberHomePhone = "' . $this->get_boardMemberHomePhone() . '",';
        $query.= ' boardMemberWorkPhone = "' . $this->get_boardMemberWorkPhone() . '",';
        $query.= ' boardMemberCellPhone = "' . $this->get_boardMemberCellPhone() . '",';
        if ($this->get_boardMemberImageWidth() > 0) {
            $query.= ' boardMemberImage = "' . $this->get_boardMemberImage() . '",';
            $query.= ' boardMemberImageWidth = ' . $this->get_boardMemberImageWidth() . ',';
            $query.= ' boardMemberImageHeight = ' . $this->get_boardMemberImageHeight() . ',';
        }
        $query.= ' boardMemberDuties = "' . $this->get_boardMemberDuties() . '"';
        $query.= ' WHERE boardMemberID=' . $this->get_boardMemberID();
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->boardMemberFormSuccess[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' updated successfully!';
        } else {
            $this->boardMemberFormErrors[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' NOT updated!  Try again or notify TCSHL.com administrator.';
        }
    }
    private function insert_boardMember() {
        $columns = '`boardMemberFirstName`,`boardMemberLastName`,`boardMemberEmail`,`boardMemberHomePhone`,`boardMemberWorkPhone`,`boardMemberCellPhone`,`boardMemberDuties`,`boardMemberImage`,`boardMemberImageWidth`,`boardMemberImageHeight`';
        $query = 'INSERT INTO ' . BOARDMEMBER . ' (' . $columns . ') ';
        $query.= 'VALUES("' . $this->get_boardMemberFirstName() . '",';
        $query.= '"' . $this->get_boardMemberLastName() . '",';
        $query.= '"' . $this->get_boardMemberEmail() . '",';
        $query.= '"' . $this->get_boardMemberHomePhone() . '",';
        $query.= '"' . $this->get_boardMemberWorkPhone() . '",';
        $query.= '"' . $this->get_boardMemberCellPhone() . '",';
        $query.= '"' . $this->get_boardMemberDuties() . '",';
        $query.= '"' . $this->get_boardMemberImage() . '",';
        $query.= $this->get_boardMemberImageWidth() . ',';
        $query.= $this->get_boardMemberImageHeight();
        $query.= ')';
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->boardMemberFormSuccess[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' created successfully!';
        } else {
            $this->boardMemberFormErrors[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' NOT created!  Try again or notify TCSHL.com administrator.';
        }
    }
    private function delete_boardMember() {
        $query = 'DELETE FROM ' . BOARDMEMBER . ' WHERE boardMemberID=' . $this->get_boardMemberID();
        mysql_query($query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
        if (validResult()) {
            $this->boardMemberFormSuccess[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' deleted successfully!';
        } else {
            $this->boardMemberFormErrors[] = 'Board Member ' . $this->get_boardMemberFirstName() . ' ' . $this->get_boardMemberLastName() . ' NOT deleted!  Try again or notify TCSHL.com administrator.';
        }
    }
    // Image formatting - Shrinks the image sizes (NOTE: not the image itself) if it is too big
    private function imageFormat() {
        if ($this->get_boardMemberImageWidth() > $this->imageMaxWidth) {
            $this->set_boardMemberImageHeight(($this->imageMaxWidth * $this->get_boardMemberImageHeight()) / $this->get_boardMemberImageWidth());
            $this->set_boardMemberImageWidth($this->imageMaxWidth);
        }
    }
    // BoardMemberFormReposts
    public function formReposts($smarty) {
        if ($_POST) {
            if ($_POST['boardMemberFirstName']) {
                $smarty->assign('bmfn', format_uppercase_text($_POST['boardMemberFirstName']));
            }
            if ($_POST['boardMemberLastName']) {
                $smarty->assign('bmln', format_uppercase_text($_POST['boardMemberLastName']));
            }
            if ($_POST['boardMemberEmail']) {
                $smarty->assign('bme', format_trim(strtolower($_POST['boardMemberEmail'])));
            }
            if ($_POST['boardMemberHomePhone']) {
                $smarty->assign('bmhp', format_trim($_POST['boardMemberHomePhone']));
            }
            if ($_POST['boardMemberWorkPhone']) {
                $smarty->assign('bmwp', format_trim($_POST['boardMemberWorkPhone']));
            }
            if ($_POST['boardMemberCellPhone']) {
                $smarty->assign('bmcp', format_trim($_POST['boardMemberCellPhone']));
            }
            if ($_POST['boardMemberDuties']) {
                $smarty->assign('bmd', format_trim($_POST['boardMemberDuties']));
            }
        }
    }
    // BoardMemberFormValidation
    public function formValidation() {
        if ($_POST['boardMemberFirstName']) {
            if (strlen($_POST['boardMemberFirstName']) < 2) {
                $this->boardMemberFormErrors[] = "First name must be at least 2 characters long.";
            }
            if (!valid_text($_POST['boardMemberFirstName'])) {
                $this->boardMemberFormErrors[] = "First name contains invalid characters. Check for quotes.";
            }
        } else {
            $this->boardMemberFormErrors[] = "First name is a required field";
        }
        if ($_POST['boardMemberLastName']) {
            if (strlen($_POST['boardMemberLastName']) < 2) {
                $this->boardMemberFormErrors[] = "Last name must be at least 2 characters long.";
            }
            if (!valid_text($_POST['boardMemberLastName'])) {
                $this->boardMemberFormErrors[] = "Last name contains invalid characters. Check for quotes.";
            }
        } else {
            $this->boardMemberFormErrors[] = "Last name is a required field";
        }
        if ($_POST['boardMemberEmail']) {
            if (validate_email(format_trim($_POST['boardMemberEmail']))) {
                //Do nothing
                
            } else {
                $this->boardMemberFormErrors[] = "Email is not valid.";
            }
        }
        if (isset($_FILES['boardMemberImage']['type']) && $_FILES['boardMemberImage']['size'] > 0) {
            if (($_FILES['boardMemberImage']['type'] != 'image/jpeg' && $_FILES['boardMemberImage']['type'] != 'image/gif')) {
                $this->boardMemberFormErrors[] = "Board member image can only be a GIF or JPEG.  Attempted file is '" . $_FILES['boardMemberImage']['type'] . "'.";
            }
        }
        return $this->get_boardMemberFormErrors();
    }
    //formProcessInsert
    function formProcessInsert() {
        $this->formProcess();
        $this->insert_boardMember();
        return $this->get_boardMemberFormErrors();
    }
    //formProcessUpdate
    function formProcessUpdate() {
        $this->formProcess();
        $this->update_boardMember();
        return $this->get_boardMemberFormErrors();
    }
    //formProcessUpdate
    function formProcessDelete() {
        $this->delete_boardMember();
        return $this->get_boardMemberFormErrors();
    }
    //formProcess
    private function formProcess() {
        $this->set_boardMemberFirstName(format_uppercase_text($_POST['boardMemberFirstName']));
        $this->set_boardMemberLastName(format_uppercase_text($_POST['boardMemberLastName']));
        $this->set_boardMemberEmail($_POST['boardMemberEmail']);
        $this->set_boardMemberHomePhone($_POST['boardMemberHomePhone']);
        $this->set_boardMemberWorkPhone(($_POST['boardMemberWorkPhone']));
        $this->set_boardMemberCellPhone($_POST['boardMemberCellPhone']);
        $this->set_boardMemberDuties($_POST['boardMemberDuties']);
        if ($_FILES['boardMemberImage']['size'] > 0 && ($_FILES['boardMemberImage']['type'] == 'image/jpeg' || $_FILES['boardMemberImage']['type'] == 'image/gif')) {
            $this->formImageProcess();
        } else {
            $this->boardMemberImageWidth = 0;
            $this->boardMemberImageHeight = 0;
        }
    }
    // Creates query piece for the image
    private function formImageProcess() {
        $fileName = $_FILES['boardMemberImage']['name'];
        $tmpName = $_FILES['boardMemberImage']['tmp_name'];
        $fileSize = $_FILES['boardMemberImage']['size'];
        $fileType = $_FILES['boardMemberImage']['type'];
        $fp = fopen($tmpName, 'r');
        $content = fread($fp, $fileSize);
        $content = addslashes($content);
        fclose($fp);
        $imageSize = getimagesize($tmpName);
        $imageWidth = $imageSize[0];
        $imageHeight = $imageSize[1];
        $this->set_boardMemberImage($content);
        $this->set_boardMemberImageWidth($imageWidth);
        $this->set_boardMemberImageHeight($imageHeight);
        $this->imageFormat();
        //return ', boardMemberImage="'.$content.'", boardMemberImageWidth="'.$imageWidth.'", boardMemberImageHeight="'.$imageHeight.'"';
        
    }
    // Get boardMemberID
    public function get_boardMemberID() {
        return $this->boardMemberID;
    }
    // Get set boardMemberFirstName
    public function set_boardMemberFirstName($boardMemberFirstName) {
        $this->boardMemberFirstName = $boardMemberFirstName;
    }
    public function get_boardMemberFirstName() {
        return $this->boardMemberFirstName;
    }
    // Get set boardMemberLastName
    public function set_boardMemberLastName($boardMemberLastName) {
        $this->boardMemberLastName = $boardMemberLastName;
    }
    public function get_boardMemberLastName() {
        return $this->boardMemberLastName;
    }
    // Get set boardMemberEmail
    public function set_boardMemberEmail($boardMemberEmail) {
        $this->boardMemberEmail = $boardMemberEmail;
    }
    public function get_boardMemberEmail() {
        return $this->boardMemberEmail;
    }
    // Get set boardMemberHomePhone
    public function set_boardMemberHomePhone($boardMemberHomePhone) {
        $this->boardMemberHomePhone = $boardMemberHomePhone;
    }
    public function get_boardMemberHomePhone() {
        return $this->boardMemberHomePhone;
    }
    // Get set boardMemberWorkPhone
    public function set_boardMemberWorkPhone($boardMemberWorkPhone) {
        $this->boardMemberWorkPhone = $boardMemberWorkPhone;
    }
    public function get_boardMemberWorkPhone() {
        return $this->boardMemberWorkPhone;
    }
    // Get set boardMemberCellPhone
    public function set_boardMemberCellPhone($boardMemberCellPhone) {
        $this->boardMemberCellPhone = $boardMemberCellPhone;
    }
    public function get_boardMemberCellPhone() {
        return $this->boardMemberCellPhone;
    }
    // Get set boardMemberDuties
    public function set_boardMemberDuties($boardMemberDuties) {
        $this->boardMemberDuties = $boardMemberDuties;
    }
    public function get_boardMemberDuties() {
        return $this->boardMemberDuties;
    }
    // Get set $boardMemberImage
    public function set_boardMemberImage($boardMemberImage) {
        $this->boardMemberImage = $boardMemberImage;
    }
    public function get_boardMemberImage() {
        return $this->boardMemberImage;
    }
    // Get set $boardMemberImageWidth
    public function set_boardMemberImageWidth($boardMemberImageWidth) {
        $this->boardMemberImageWidth = $boardMemberImageWidth;
    }
    public function get_boardMemberImageWidth() {
        return $this->boardMemberImageWidth;
    }
    // Get set $boardMemberImageHeight
    public function set_boardMemberImageHeight($boardMemberImageHeight) {
        $this->boardMemberImageHeight = $boardMemberImageHeight;
    }
    public function get_boardMemberImageHeight() {
        return $this->boardMemberImageHeight;
    }
    // Get $imageMaxWidth
    public function get_imageMaxWidth() {
        return $this->imageMaxWidth;
    }
    // Get $boardMemberFormErrors
    public function get_boardMemberFormErrors() {
        return (array)$this->boardMemberFormErrors;
    }
    // Get $boardMemberFormSuccess
    public function get_boardMemberFormSuccess() {
        return (array)$this->boardMemberFormSuccess;
    }
}
?>
