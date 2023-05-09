<?php

require_once(__DIR__ . '/../database/Database.php');
require_once(__DIR__ . '/../traits/FileUploads.php');

class Auth {

	use FileUploads;

	private $conn;

	public function __construct() {
		$this->conn = new Database();
	}

	public function register(array $data): int
	[
		try {
			$existingUser = $this->userExists($data['email']);

			if ($existingUser) {
				throw new Exception("User Already Exists");
			}

			$data['profile_pic'] = $this->uploadFile($data['profile_pic'], 'uploads/profile_pictures');
			$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

			$conn = $thid->conn->getConnection();
			
			$stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_pic) VALUES (:name, :email, :password, :profile_pic)");

			$stmt->bindParam(":name", $data['name']);

		}
	]

}

?>