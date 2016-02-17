function toggle_email_submit() {
  value = document.getElementById('to').value
  
  if(value == "none") {
    document.getElementById('action').disabled=true
  } else {
    document.getElementById('action').disabled=false
  }
}