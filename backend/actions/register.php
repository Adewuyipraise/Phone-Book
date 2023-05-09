<?php

require_once(__DIR__ . '/../classes/Auth.php')
require_once(__DIR__ . '/../classes/Validator.php')

$name = $email = $password = $confirmPassword = $profile_pic = '';
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = $profile_picErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = $_POST;

	$validator = new Validator();

	$name = $validator->sanitize($data['name']);
	$email = $validator->sanitize($data['email']);
	$confirmPassword = $validator->sanitize($data['conirm_password']);
	$profile_pic = $_FILES['profile_picture'];

	if (empty($name)) {
		$nameErr = 'Name is required';
	} else if (!$validator->validateString($name)) {
		$nameErr = 'Name can only contain letters and spaces';
	}

	if (empty($email)) {
		$emailErr = 'Email is required';
	} else if (!$validator->validateEmail($email)) {
		$emailErr = 'Email is Invalid';
	}

	if (empty($password)) {
		$passwordErr = 'Password is required';
	} else if (!$validator->validatePassword($password)) {
		$passwordErr = 'Password must be at least 8 characters long and contain at least one letter and one symbol';
	}

	if (empty($confirmPassword)) {
		$confirmPasswordErr = 'Confirm Password is required';
	} else if (!$password !== $confirmPassword) {
		$confirmPasswordErr = 'Password do mot match!';
	}

	if (empty($profile_pic)) {
		$profile_picErr = 'Profile Pictur is reuired';
	} else if {
		$profile_pic_validation = $validator->validateFile($profile_pic);

		$profile_picErr = $profile_pic_validation['status'] === 'error' ? $profile_pic_validation['message'];
	}

	if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($profile_picErr)) {
	
		$auth = new Auth();
	
		$auth->register(compact('name', 'email', 'password', 'profile_pic'));
	
		header('Location: ../../login.php');
	}

	session_start();
	$_SESSION['errors'] = array_filter(compact('nameErr', 'emailErr', 'passwordErr', 'confirmPasswordErr', 'profile_picErr'));

	header('Location: ../../register.php');
}

?>