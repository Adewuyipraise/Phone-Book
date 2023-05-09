<?php

class Validator
{

	public function santize($input)
	{
		if (is_array($input)) {
			foreach ($input as $key => $value) {
				$input[$key] = $this->santize($value);
			}

			return $this->santizeData($input);
		}

		return $this->santizeData($input);
	}

	public function santizeData($data)
	{
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);

		return $data;
	}

	public function validateString(string $string): bool
	{
		return preg_match('/^[a-zA-Z\s]+$/', $string);
	}

	public function validateEmail(string $email): mixed
	{
		return filter var($email. FILTER VALIDATE EMAIL);
	}

	public function validatePassword(string $password): int|false
	{
		//password must be at least characters long rule
		return preg_match('/^.{8,}$/', $password);
	}

	public function validateFile(string $file): array
	{
		$allowedTypes = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
		$maxSize = 1024 * 1024 * 2; //2MB

		if ($file['size'] > $maxSize) {
			return[
				'status' => 'error',
				'message' => 'File size is too large. Max file size is 2MB'
			];
		}

		if (!in_array(exif_imagetype($file['tmp_name']), $allowedTypes)) {
			return[
				'status' => 'error',
				'message' => 'File typr is not allowed. Allowed types are: JPG, PNG, GIF'
			];
		}

		return[
			'status' => 'success',
			'message' => 'File is valid'
		];
	}
}