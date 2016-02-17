
function displayEmailLink() {
	var eary= new Array(99,108,97,115,115,105,102,105,101,100,115,64,117,110,107,46,101,100,117)
	var pe=''
	for (i=0; i < eary.length; i++) {
		pe+=String.fromCharCode(eary[i])
	}
	
	document.write('<a href="mailto:'+pe+'">'+pe+'</a>')
}

function update_registration_payment_options() {
	var form = document.forms['registrationform'];

	for (index=0; index < form.drilLeague.length; index++) {
		if (form.drilLeague[index].checked) {
			var league = form.drilLeague[index].value;
			break;
		}
	}
	
	if (league == 1 || league == 3) {
		  form.paymentPlan[1].disabled=false;
		  form.paymentPlan[2].disabled=false;
		  form.paymentPlan[3].disabled=false;
		  form.paymentPlan[4].disabled=false;
		  if(form.paymentPlan[0].checked) {
			  form.paymentPlan[1].checked=true;
		  }
		  form.paymentPlan[0].disabled=true;
	} else if (league == 2) {
		  form.paymentPlan[0].disabled=false;
		  form.paymentPlan[1].disabled=true;
		  form.paymentPlan[2].disabled=true;
		  form.paymentPlan[3].disabled=true;
		  form.paymentPlan[4].disabled=true;
		  form.paymentPlan[0].checked=true;
	}
}
