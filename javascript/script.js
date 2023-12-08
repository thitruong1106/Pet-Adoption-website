function validateForm(theForm) {
  var valid = true; // Assume the form is valid to start with

  // Go through each form input and check if it has a value
  if (!theForm.fname.value.length) {
    valid = false; // Form is not valid
    showError('fname-error'); // Show the error message
    theForm.fname.style.border = "1px solid #ff0000"; // Add a red border around the text box
  } else {
    hideError('fname-error'); // Hide the error message
    theForm.fname.style.border = "1px solid #ccc"; // Set the border back to normal
  }

   if (!theForm.lname.value.length) {
    valid = false; // Form is not valid
    showError('lname-error'); // Show the error message
    theForm.lname.style.border = "1px solid #ff0000"; // Add a red border around the text box
  } else {
    hideError('lname-error'); // Hide the error message
    theForm.lname.style.border = "1px solid #ccc"; // Set the border back to normal
  }

   if (!theForm.emailadd.value.length) {
    valid = false; // Form is not valid
    showError('emailadd-error'); // Show the error message
    theForm.emailadd.style.border = "1px solid #ff0000"; // Add a red border around the text box
  } else {
    hideError('emailadd-error'); // Hide the error message
    theForm.emailadd.style.border = "1px solid #ccc"; // Set the border back to normal
  }

   if (!theForm.mobileno.value.length) {
    valid = false; // Form is not valid
    showError('mobileno-error'); // Show the error message
    theForm.mobileno.style.border = "1px solid #ff0000"; // Add a red border around the text box
  } else {
    hideError('mobileno-error'); // Hide the error message
    theForm.mobileno.style.border = "1px solid #ccc"; // Set the border back to normal
  }

   if (!theForm.password.value.length) {
    valid = false; // Form is not valid
    showError('password-error'); // Show the error message
    theForm.password.style.border = "1px solid #ff0000"; // Add a red border around the text box
  } else {
    hideError('password-error'); // Hide the error message
    theForm.password.style.border = "1px solid #ccc"; // Set the border back to normal
  }



  return valid; // Return the overall validation status
}

function showError(errorId) {
  var errorElement = document.getElementById(errorId);
  errorElement.style.display = "inline-block";
}

function hideError(errorId) {
  var errorElement = document.getElementById(errorId);
  errorElement.style.display = "none";
}
