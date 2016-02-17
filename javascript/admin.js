function toggle_stat_type(stat_row,stat_type) {

	var shotsRow = "shots" + stat_row;
	var gaRow = "ga" + stat_row;


	if (stat_type == 1) {
	  document.getElementById(shotsRow).disabled=true;
	  document.getElementById(gaRow).disabled=true;
	}
	else if (stat_type == 2) {
	  document.getElementById(shotsRow).disabled=false; 
	  document.getElementById(gaRow).disabled=false;
	}
}


function showAlert(msg) {
  var go = confirm("Are you sure " + msg);
  if (go == true) {
    return true;
  }
  else {
    return false;
  }
}

function toggle_rep_submit() {
  value = document.getElementById('teamrep').value;
  
  if(value == "none") {
    document.getElementById('action').disabled=true;
  } else {
    document.getElementById('action').disabled=false;
  }
}