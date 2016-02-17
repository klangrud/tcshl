
function submit_login_button() {
	var loginForm =	document.forms[0];
	var emailField = loginForm.elements[0];
	var pwField = loginForm.elements[1];
		
	if(emailField.value.length == 0 && pwField.value.length == 0) {
		window.location="login.php";
	}
}

function submit_to_team_page(teamid) {
	var url = "team.php?teamid=" + teamid;
	location.href=url;
}

function toggleObjectForm(ele_in, text_in, open_html, close_html) {
	var ele = document.getElementById(ele_in);
	var text = document.getElementById(text_in);

	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = open_html;
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = close_html;
	}
}