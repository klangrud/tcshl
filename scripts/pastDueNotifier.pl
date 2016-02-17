#!/usr/bin/perl -w

use strict;

$|++; 

use DBI;
use DBD::mysql;
use CGI qw/:standard/;
use POSIX;

#DB Connection

#my $dbh = DBI->connect('DBI:mysql:tcshldbuser;host=localhost', 'tcshldbuser', 'Su7thaiG', { RaiseError => 1 }
#my $dbh = DBI->connect('DBI:mysql:tcshldbuser;host=localhost', 'tcshldbuser', 'H0ckey07', { RaiseError => 1 }
my $dbh = DBI->connect('DBI:mysql:tcshldbuser;host=tcshldbuser.db.2408816.hostedresource.com', 'tcshldbuser', 'H0ckey07', { RaiseError => 1 }
                   ) || die "Could not connect to database: $DBI::errstr";

my $sth = undef;

# Set Debug - 1 Will just print the output, anything else will email the output.
my $debug = "0";

# Set email info
my $from = 'TCSHL <tcshl@tcshl.com>';
my $sendmail = '/usr/lib/sendmail';

#Initialize Timestamps (Now, TodayBegin 00:00:00, TodayEnd 23:59:59)
my $currentDateEpoch = time();
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($currentDateEpoch);
my $neatMonth = undef;
if((1+$mon) < 10) {
  $neatMonth = '0'.(1+$mon);
} else {
  $neatMonth = (1+$mon);
} 
my $formattedDate = (1900+$year).'-'.$neatMonth.'-'.getLeadingZero($mday).' '.getLeadingZero($hour).':'.getLeadingZero($min).':'.getLeadingZero($sec);
my $secondsToday = ($hour * 60 * 60) + ($min * 60) + $sec;

my $todayBeginEpoch = $currentDateEpoch - $secondsToday;
my $todayEndEpoch = $todayBeginEpoch + 86399;

#Initialize Reports
# /* Report Sent to Team Rep */
my $teamReport = ""; 
# /* Compilation of 2 Team Reports into a report for the Referees */
my $gameReport = ""; 
# /* Compilation of All Game Reports into a report for scorekeeper */
my $gameDayReport = ""; 

# Get SEASON---------------------------------------------------------------------------------------------------------------
#Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT value FROM variables WHERE variable="SEASON"
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";


my $SEASON = undef;
while (my @row = $sth->fetchrow_array ) {
    $SEASON= $row[0];
}

# Get Todays Games---------------------------------------------------------------------------------------------------------------
#Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT gameGuestTeam, gameHomeTeam, gameReferee1, gameReferee2, gameID
FROM game
WHERE seasonId = $SEASON
AND $todayBeginEpoch <= gameTime
AND gameTime <= $todayEndEpoch 
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";


my @gameGuestArray = undef;
my @gameHomeArray = undef;
my @gameRef1Array = undef;
my @gameRef2Array = undef;
my @gameID = undef;
my $gameNum = 0;
while (my @row2 = $sth->fetchrow_array ) {
    $gameGuestArray[$gameNum] = $row2[0];
    $gameHomeArray[$gameNum] = $row2[1];
    $gameRef1Array[$gameNum] = $row2[2];
    $gameRef2Array[$gameNum] = $row2[3];
    $gameID[$gameNum] = $row2[4];
    $gameNum++;
}

if($gameNum < 1) {
  $dbh->disconnect();
  print "No Games Today\n";
  exit 0;
} else {
  my $isare;
  my $ares = "";
  if($gameNum == 1) {$isare="is"; $ares=""}
  print "There ${isare} ${gameNum} Game${ares} Today\n";
}

# Get PAYMENT DATES--------------------------------------------------------------------------------------------------------
#Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT * FROM paymentdates WHERE seasonID=$SEASON
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

my $paydate1 = undef;
my $paydate2 = undef;
my $paydate3 = undef;
my $paydate4 = undef;
while (my @row3 = $sth->fetchrow_array ) {
    $paydate1= $row3[1];
    $paydate2= $row3[2];
    $paydate3= $row3[3];
    $paydate4= $row3[4];
}

#Wed Sep 17 16:24:33 2008
#2008-09-14 00:00:00


my $todayCheck = formatDate($formattedDate)+0;
my $pay1 = formatDate($paydate1)+0;
my $pay2 = formatDate($paydate2)+0;
my $pay3 = formatDate($paydate3)+0;
my $pay4 = formatDate($paydate4)+0;

my $checkPay1 = "FALSE";
my $checkPay2 = "FALSE";
my $checkPay3 = "FALSE";
my $checkPay4 = "FALSE";

if($pay1 < $todayCheck) {
  $checkPay1 = "TRUE";
}
if($pay2 < $todayCheck) {
  $checkPay2 = "TRUE";
}
if($pay3 < $todayCheck) {
  $checkPay3 = "TRUE";
}
if($pay4 < $todayCheck) {
  $checkPay4 = "TRUE";
}


if($checkPay1 eq "FALSE" && $checkPay2 eq "FALSE" && $checkPay3 eq "FALSE" && $checkPay4 eq "FALSE") {
    print "No payment dates have past.  Report will exit.\n";
    exit 0;
}

# Get ALT PAYMENT DATES - Plan 3------------------------------------------------------------------------------------------------
#Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT * FROM paymentdatesalt WHERE seasonID=$SEASON
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

my $altpaydate1 = undef;
my $altpaydate2 = undef;
my $altpaydate3 = undef;
while (my @row3 = $sth->fetchrow_array ) {
    $altpaydate1= $row3[1];
    $altpaydate2= $row3[2];
    $altpaydate3= $row3[3];
}

#Wed Sep 17 16:24:33 2008
#2008-09-14 00:00:00


my $alttodayCheck = formatDate($formattedDate)+0;
my $altpay1 = formatDate($altpaydate1)+0;
my $altpay2 = formatDate($altpaydate2)+0;
my $altpay3 = formatDate($altpaydate3)+0;

my $altcheckPay1 = "FALSE";
my $altcheckPay2 = "FALSE";
my $altcheckPay3 = "FALSE";

if($altpay1 < $alttodayCheck) {
  $altcheckPay1 = "TRUE";
}
if($altpay2 < $todayCheck) {
  $altcheckPay2 = "TRUE";
}
if($altpay3 < $todayCheck) {
  $altcheckPay3 = "TRUE";
}

# We'll comment out this check since we're already doing the other payments
#if($altcheckPay1 eq "FALSE" && $altcheckPay2 eq "FALSE" && $altcheckPay3 eq "FALSE") {
#    print "No payment dates have past.  Report will exit.\n";
#    exit 0;
#}

# Initialize the info
my $TEAM_INFO = "Team Rep, \
    This is the payment report for your team.  The individuals listed here are late on a league payment \
and will need to make arrangements before they can play in today's scheduled game.  NO PAY, NO PLAY. \
-TCSHL League Payments";
my $GAME_INFO = "Game Referee, \
    This is the payment report for a game you are scheduled to ref.  The individuals listed here are late \
on a league payment and will need to make arrangements before they can play in today's scheduled game.  NO PAY, NO PLAY. \
-TCSHL League Payments";
my $ALL_INFO = "TCSHL Board Members, \
    This is a payment report for all teams scheduled to play today.  The individuals listed on here are late on a \
league payment.  They must make arrangements before they can play in today's scheduled game.  NO PAY, NO PLAY.\
-TCSHL League Payments";


# Generate Reports
for(my $i = 0; $i < $gameNum; $i++) {
  # Create Guest Team Report and email it to Guest team rep.
  $teamReport = generateReport($gameGuestArray[$i]); 
  if($teamReport ne "") {
    emailReport($teamReport, "TEAM", $gameGuestArray[$i], 0);
  }

  # Attach Guest Team Report to Game Report
  $gameReport = $teamReport;

  # Create Home Team Report and email it to Home team rep.
  $teamReport = generateReport($gameHomeArray[$i]); 
  if($teamReport ne "") {
    emailReport($teamReport, "TEAM", $gameHomeArray[$i], 0);
  }

  # Attach Home Team Report to Game Report and Email Game Report to Referees.
  $gameReport .= $teamReport;
  if($gameReport ne "") {
    emailReport($gameReport, "GAME", $gameID[$i], $gameID[$i]);
  }
 
  # Attach Game Report to Game Day Report
  $gameDayReport .= $gameReport;
}

# Email Game Day Report to Scorekeepers (This will be a static list)
if($gameDayReport ne "") {
  emailReport($gameDayReport, "ALL", 0, 0);
}




#Disconnect DB Connection
$sth->finish;
$dbh->disconnect;


## NEED TO REMOVE THIS ##
exit 0;

###############################################################################
###############################################################################
############################### LOCAL FUNCTIONS ###############################
###############################################################################
###############################################################################
sub generateReport {
  my $team = shift;
  my @reportRow = undef;
  my $teamHasLatePayments = "FALSE";
  my $report = "\
-------------------------------------------------------------------------------------- \
  Team Payment Report For \
  ".getTeamName($team)."   \
--------------------------------------------------------------------------------------\n";
   
# Payment Plan 4 Checks
  my $checkColumns4 = "playerFName, playerLName,";

  if($checkPay1 && $checkPay1 eq "TRUE") {
    $checkColumns4 .= "paymentOneDate,";
  }
  if($checkPay2 && $checkPay2 eq "TRUE") {
    $checkColumns4 .= "paymentTwoDate,";
  }
  if($checkPay3 && $checkPay3 eq "TRUE") {
    $checkColumns4 .= "paymentThreeDate,";
  }
  if($checkPay4 && $checkPay4 eq "TRUE") {
    $checkColumns4 .= "paymentFourDate,";
  }
  $checkColumns4 .= "paymentplanfour.registrationID";


 #Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT $checkColumns4 
FROM paymentplanfour
JOIN registration ON paymentplanfour.registrationID=registration.registrationId
JOIN player ON registration.registrationId=player.registrationId
WHERE paymentplanfour.registrationID
IN (SELECT registrationId FROM registration WHERE seasonId=$SEASON) 
AND player.playerID 
IN (SELECT playerID FROM rostersofteamsofseasons WHERE seasonId=$SEASON AND teamID=$team) 
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

my $pastdue = "";
my $pastduePayments = "";
my $playerFName = "";
my $playerLName = "";
my $playerFullName = "";
my $playerNameLength = "";
my $tab = "";
while (my @paymentRow4 = $sth->fetchrow_array) {
  $playerFName = $paymentRow4[0]; 
  $playerLName = $paymentRow4[1];

  $pastdue = "FALSE";
  $pastduePayments = "";
  if($checkPay1 && $checkPay1 eq "TRUE") {
    if(not defined $paymentRow4[2]) {
       $pastduePayments .= "(1)";
       $pastdue = "TRUE";
    } 
  }
  if($checkPay2 && $checkPay2 eq "TRUE") {
    if(not defined $paymentRow4[3]) {
       $pastduePayments .= "(2)";
       $pastdue = "TRUE";
    } 
  }
  if($checkPay3 && $checkPay3 eq "TRUE") {
    if(not defined $paymentRow4[4]) {
       $pastduePayments .= "(3)";
       $pastdue = "TRUE";
    } 
  }
  if($checkPay4 && $checkPay4 eq "TRUE") {
    if(not defined $paymentRow4[5]) {
       $pastduePayments .= "(4)";
       $pastdue = "TRUE";
    } 
  }

  $playerFullName = $playerFName." ".$playerLName;
  $playerNameLength = length($playerFullName);
  if($playerNameLength <= 14) {
	$tab = "\t\t";
  } else {
	$tab = "\t";
  }

  if($pastdue eq "TRUE") {
    $report .= $playerFullName." ".$tab." PAST DUE on the following payments [".$pastduePayments."] \tPayment Plan 4\n";
    $teamHasLatePayments = "TRUE";
  }

} 

# Payment Plan 3 Checks
  my $checkColumns3 = "playerFName, playerLName,";

  if($altcheckPay1 && $altcheckPay1 eq "TRUE") {
    $checkColumns3 .= "paymentOneDate,";
  }
  if($altcheckPay2 && $altcheckPay2 eq "TRUE") {
    $checkColumns3 .= "paymentTwoDate,";
  }
  if($altcheckPay3 && $altcheckPay3 eq "TRUE") {
    $checkColumns3 .= "paymentThreeDate,";
  }
  $checkColumns3 .= "paymentplanthree.registrationID";


 #Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT $checkColumns3 
FROM paymentplanthree
JOIN registration ON paymentplanthree.registrationID=registration.registrationId
JOIN player ON registration.registrationId=player.registrationId
WHERE paymentplanthree.registrationID
IN (SELECT registrationId FROM registration WHERE seasonId=$SEASON) 
AND player.playerID 
IN (SELECT playerID FROM rostersofteamsofseasons WHERE seasonId=$SEASON AND teamID=$team) 
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

$pastdue = "";
$pastduePayments = "";
$playerFName = "";
$playerLName = "";
$playerFullName = "";
$playerNameLength = "";
$tab = "";
while (my @paymentRow3 = $sth->fetchrow_array) {
  $playerFName = $paymentRow3[0]; 
  $playerLName = $paymentRow3[1];

  $pastdue = "FALSE";
  $pastduePayments = "";
  if($altcheckPay1 && $altcheckPay1 eq "TRUE") {
    if(not defined $paymentRow3[2]) {
       $pastduePayments .= "(1)";
       $pastdue = "TRUE";
    } 
  }
  if($altcheckPay2 && $altcheckPay2 eq "TRUE") {
    if(not defined $paymentRow3[3]) {
       $pastduePayments .= "(2)";
       $pastdue = "TRUE";
    } 
  }
  if($altcheckPay3 && $altcheckPay3 eq "TRUE") {
    if(not defined $paymentRow3[4]) {
       $pastduePayments .= "(3)";
       $pastdue = "TRUE";
    } 
  }

  $playerFullName = $playerFName." ".$playerLName;
  $playerNameLength = length($playerFullName);
  if($playerNameLength <= 14) {
	$tab = "\t\t";
  } else {
	$tab = "\t";
  }

  if($pastdue eq "TRUE") {
    $report .= $playerFullName." ".$tab." PAST DUE on the following payments [".$pastduePayments."] \tPayment Plan 3\n";
    $teamHasLatePayments = "TRUE";
  }

}


# Payment Plan 2 Checks
  my $checkColumns2 = "playerFName, playerLName,";

  if($checkPay1 && $checkPay1 eq "TRUE") {
    $checkColumns2 .= "paymentOneDate,";
  }
  if($checkPay3 && $checkPay3 eq "TRUE") {
    $checkColumns2 .= "paymentTwoDate,";
  }
  $checkColumns2 .= "paymentplantwo.registrationID";


 #Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT $checkColumns2 
FROM paymentplantwo
JOIN registration ON paymentplantwo.registrationID=registration.registrationId
JOIN player ON registration.registrationId=player.registrationId
WHERE paymentplantwo.registrationID
IN (SELECT registrationId FROM registration WHERE seasonId=$SEASON) 
AND player.playerID 
IN (SELECT playerID FROM rostersofteamsofseasons WHERE seasonId=$SEASON AND teamID=$team) 
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

$pastdue = "";
$pastduePayments = "";
$playerFName = "";
$playerLName = "";
while (my @paymentRow2 = $sth->fetchrow_array) {
  $playerFName = $paymentRow2[0];
  $playerLName = $paymentRow2[1];

  $pastdue = "FALSE";
  $pastduePayments = "";
  if($checkPay1 && $checkPay1 eq "TRUE") {
    if(not defined $paymentRow2[2]) {
       $pastduePayments .= "(1)";
       $pastdue = "TRUE";
    }
  }
  if($checkPay3 && $checkPay3 eq "TRUE") {
    if(not defined $paymentRow2[3]) {
       $pastduePayments .= "(2)";
       $pastdue = "TRUE";
    }
  }

  $playerFullName = $playerFName." ".$playerLName;
  $playerNameLength = length($playerFullName);
  if($playerNameLength <= 14) {
	$tab = "\t\t";
  } else {
	$tab = "\t";
  }

  if($pastdue eq "TRUE") {
    $report .= $playerFullName." ".$tab." PAST DUE on the following payments [".$pastduePayments."] \tPayment Plan 2\n";
    $teamHasLatePayments = "TRUE";
  }

}


# Payment Plan 1 Checks
  my $checkColumns1 = "playerFName, playerLName,";

  if($checkPay1 && $checkPay1 eq "TRUE") {
    $checkColumns1 .= "paymentOneDate,";
  }
  $checkColumns1 .= "paymentplanone.registrationID";


 #Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT $checkColumns1 
FROM paymentplanone
JOIN registration ON paymentplanone.registrationID=registration.registrationId
JOIN player ON registration.registrationId=player.registrationId
WHERE paymentplanone.registrationID
IN (SELECT registrationId FROM registration WHERE seasonId=$SEASON) 
AND player.playerID 
IN (SELECT playerID FROM rostersofteamsofseasons WHERE seasonId=$SEASON AND teamID=$team) 
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";

$pastdue = "";
$pastduePayments = "";
$playerFName = "";
$playerLName = "";
while (my @paymentRow1 = $sth->fetchrow_array) {
  $playerFName = $paymentRow1[0];
  $playerLName = $paymentRow1[1];

  $pastdue = "FALSE";
  $pastduePayments = "";
  if($checkPay1 && $checkPay1 eq "TRUE") {
    if(not defined $paymentRow1[2]) {
       $pastduePayments .= "(1)";
       $pastdue = "TRUE";
    }
  }

  $playerFullName = $playerFName." ".$playerLName;
  $playerNameLength = length($playerFullName);
  if($playerNameLength <= 14) {
	$tab = "\t\t";
  } else {
	$tab = "\t";
  }

  if($pastdue eq "TRUE") {
    $report .= $playerFullName." ".$tab." PAST DUE on the following payments [".$pastduePayments."] \tPayment Plan 1\n";
    $teamHasLatePayments = "TRUE";
  }

}

if($teamHasLatePayments eq "TRUE") {
  return $report."\n\n";
} else {
  return "";
}
}

# Get Team Name
sub getTeamName {
  my $teamID = shift;

 #Prepare DB Statement
$sth = $dbh->prepare( <<EOSQL
SELECT teamName
FROM teams
WHERE teamID=$teamID
EOSQL
);

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";


if (my @teamRow = $sth->fetchrow_array ) {
  return $teamRow[0];
} else {
  return "Team Name Unknown";
}
}

# Get Leading Zero
sub getLeadingZero {
  my $origNum = shift;
  my $num = "";

if($origNum < 10) {
  $num = '0'.$origNum;
} else {
  $num = $origNum;
}
return $num;
}

# Formats YYYY-MM-DD HH:MM:SS -> YYYYMMDDHHMMSS
sub formatDate {
  my $newDate = shift;

  $newDate = str_replace(' ', '', $newDate);
  $newDate = str_replace('-', '', $newDate);
  $newDate = str_replace('-', '', $newDate);
  $newDate = str_replace(':', '', $newDate);
  $newDate = str_replace(':', '', $newDate);

  return $newDate;
}

#Replace a string without using RegExp.
sub str_replace {
	my $replace_this = shift;
	my $with_this  = shift; 
	my $string   = shift;
	
	my $length = length($string);
	my $target = length($replace_this);
	
	for(my $i=0; $i<$length - $target + 1; $i++) {
		if(substr($string,$i,$target) eq $replace_this) {
			$string = substr($string,0,$i) . $with_this . substr($string,$i+$target);
			return $string; #Comment this if you what a global replace
		}
	}
	return $string;
}

#-> Get Email based off playerID 
sub getEmail {
  my $id = shift;

$sth = $dbh->prepare( <<EOSQL
SELECT eMail
FROM player
JOIN registration ON player.registrationId=registration.registrationId
WHERE player.playerID=$id
EOSQL
);  

#Execute DB Statment
$sth->execute() || die "Problem selecting from DB!";


if (my @emailRow = $sth->fetchrow_array ) {
  return $emailRow[0];
} else {
  return undef;
} 

}

#-> Send Email
sub emailReport {
  my $subject = "";
  my $body = shift;
  my $type = shift;
  my $id = shift;  
  my $gameNumber = shift;
  my $recips = "tcshl\@tcshl.com,";

  if($type eq "TEAM") {
$sth = $dbh->prepare( <<EOSQL
SELECT teamRep
FROM teamsofseasons
WHERE seasonID=$SEASON
AND teamID=$id
EOSQL
);
    #Execute DB Statment
    $sth->execute() || die "Problem selecting from DB!";

    if (my @teamRepRow = $sth->fetchrow_array ) {
      if($teamRepRow[0]) {
          $recips .= getEmail($teamRepRow[0]).",";
      }
    }
  } elsif($type eq "GAME") {
$sth = $dbh->prepare( <<EOSQL
SELECT gameReferee1, gameReferee2 
FROM game
WHERE gameID=$id
EOSQL
);
    #Execute DB Statment
    $sth->execute() || die "Problem selecting from DB!";

    if (my @gameRefRow = $sth->fetchrow_array ) {
      if($gameRefRow[0]) {
          $recips .= getEmail($gameRefRow[0]).",";
      }
      if($gameRefRow[1]) {
          $recips .= getEmail($gameRefRow[1]).",";
      }
    }
  } else {
    $recips .= "board\@tcshl.com,"; 
  }


  $recips .= "tcshl\@tcshl.com";

if($type eq "TEAM") {
  $subject = "TCSHL Automatic Team Payment Report - ".strftime '%a %b %e, %Y',localtime($currentDateEpoch);
  $body = $TEAM_INFO."\n\n".$body;
} elsif($type eq "GAME") {
  $subject = "TCSHL Automatic Payment Report (Game ".$gameNumber.") - ".strftime '%a %b %e, %Y',localtime($currentDateEpoch);
  $body = $GAME_INFO."\n\n".$body;
} else {
  $subject = "TCSHL Automatic Payment Report - ".strftime '%a %b %e, %Y',localtime($currentDateEpoch);
  $body = $ALL_INFO."\n\n".$body;
}




  # Following Line is for Debug Only
  #$recips = "klangrud\@gmail.com";



	# Debug will just print the output and not email it.
	if($debug == "1") {
	  print "To: ".$recips."\n";
	  print $subject."\n";
	  print $body."\n";
	} else { 
	  #print $body."\n";
	  #print "\n-------------------------------------------------------------------------------------------\n";
		
open(SENDMAIL, "|$sendmail -t") or die "Can't fork for sendmail: $!\n";
		 
print SENDMAIL <<"EOF";
From: $from
To: $recips
Subject: $subject
$body
EOF

close(SENDMAIL) or warn "Sendmail didn't close nicely";
	}
	

}
