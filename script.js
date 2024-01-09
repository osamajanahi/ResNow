const form = document.getElementById('register');
const fname = document.getElementById('Fname');
const lname = document.getElementById('Lname');
const email = document.getElementById('email');
const password = document.getElementById('pass');
const password2 = document.getElementById('pass2');
const accept = document.getElementById('accept');
const gender = document.getElementsByName('gender');
const genderCn = document.getElementById('genderCn');

// Show input error message
function showError(input, message) {
  const formControl = input.parentElement;
  formControl.className = 'form-controler error';
  const small = formControl.querySelector('small');
  small.innerText = message;
}

// Show success outline
function showSuccess(input) {
  const formControl = input.parentElement;
  formControl.className = 'form-controler success';
}

// Check rules is valid
function checkRules(input){
  let error = 0;
  if (input.checked){
    showSuccess(input);
  }
  else{
    showError(input,'Please press to accept');
    ++error;
  }
  return error;
}

// Check gender is valid
function checkGender(input){
  let error = 0;
  if (input[0].checked||input[1].checked){
    genderCn.className = 'form-controler success';
  }
  else{
    genderCn.className = 'form-controler error';
    const small = genderCn.querySelector('small');
    small.innerText = 'Gender is required';
    ++error;
  }
  return error;
}

// Check email is valid
function checkEmail(input) {
  let error = 0;
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (re.test(input.value.trim())) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = myAJAXFunction;
    xhttp.open("GET", "checkun.php?q="+input.value);
    xhttp.send();
  } else {
    showError(input, 'Email is not valid');
    ++error;
  }
  return error;
}

//return availability for email
function myAJAXFunction(){
  if (this.responseText=="taken"){
    showError(email, 'This email is already registered');
  }
  else {
    showSuccess(email);
  }
}

// Check required fields
function checkRequired(inputArr) {
  let error=0;
  inputArr.forEach(function(input) {
    if (input.value.trim() === '') {
      showError(input, `${getFieldName(input)} is required`);
      ++error;
    } else {
      showSuccess(input);
    }
  });
  return error;
}

// Check input length
function checkLength(input, min, max) {
  let error=0;
  if (input.value.length < min) {
    showError(
      input,
      `${getFieldName(input)} must be at least ${min} characters`
    );
    ++error;
  } else if (input.value.length > max) {
    showError(
      input,
      `${getFieldName(input)} must be less than ${max} characters`
    );
    ++error;
  } else {
    showSuccess(input);
  }
  return error;
}

// Check passwords match
function checkPasswordsMatch(input1, input2) {
  let error = 0;
  if (input1.value !== input2.value) {
    showError(input2, 'Passwords do not match');
    ++error;
  }
  return error;
}

// Get fieldname
function getFieldName(input) {
  return input.id.charAt(0).toUpperCase() + input.id.slice(1);
}

// Event listeners
function validateForm() {
  let allErrors = 0;
  allErrors+=checkRequired([fname, lname, email, password, password2]);
  allErrors+=checkLength(fname, 3, 25);
  allErrors+=checkLength(lname, 3, 25);
  allErrors+=checkLength(password, 8, 25);
  allErrors+=checkEmail(email);
  allErrors+=checkGender(gender);
  allErrors+=checkPasswordsMatch(password, password2);
  allErrors+=checkRules(accept);

  //If all requirements are successful, submit the form
  if (allErrors===0)
    return true;
  else
    return false;
}
