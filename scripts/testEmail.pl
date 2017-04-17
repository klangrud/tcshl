#!/usr/bin/perl -w

use strict;

$|++; 

use DBI;
use DBD::mysql;
use CGI qw/:standard/;
use POSIX;


# Set Debug - 1 Will just print the output, anything else will email the output.
my $debug = "0";

# Set email info
my $from = 'TCSHL <tcshl@tcshl.com>';
my $smtp = 'relay-hosting.secureserver.net';

emailReport();

## NEED TO REMOVE THIS ##
exit 0;



#-> Send Email
sub emailReport {
  use Mail::Mailer qw(sendmail);

  my $subject = "Test Subject";
  my $body = "Test Body";
  my $recips = "development\@example.com";



	# Debug will just print the output and not email it.
	if($debug == "1") {
	  print "To: ".$recips."\n";
	  print $subject."\n";
	  print $body."\n";
	} else { 
	  print $body."\n";
	  print "\n-------------------------------------------------------------------------------------------\n";
		my $mail = Mail::Mailer->new('sendmail') or die "Couldn't create a mail object!\n";
		my $mail_headers =  {
		    'Content-Type' => 'text/plain',
		    To => $recips,
		    From => $from,
		    Subject => $subject,
		};
		$mail->open( $mail_headers );
		$mail->print($subject);
		$mail->close();
	}
}
