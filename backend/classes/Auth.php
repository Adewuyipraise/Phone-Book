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
	{
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
			$stmt->bindParam(":email", $data['email']);
			$stmt->bindParam(":password", $data['password']);
			$stmt->bindParam(":profile_pic", $data['profile_pic']);

			$stmt->execute();

			return $conn->lastInsertId();
		} catch (Throwable $th) {
			throw new Exception("Failed to register user: " . $th->getMessage());
		}
	}

	public function userExists(strings $email): bool
	{
		try {
			$conn = $this->conn->getConnection();
			$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
			$stmt->execute(array(":email"=>$email));

			$count = $stmt->rowCount();

			return $count > 0 ? true : false;
		} catch(PDOException $e) {
			throw new Exception("Failed to check if User Exists:" . $e->getMessage());
			
		}
	}

	public function login(strings $email, string $password): bool
	{
		$conn = $this->conn->getConnection();

		$stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
		$stmt->bindParam(":email", $email);
		$stmt->execute();

		$user = $stmt->fecth(PDO::FETCH_ASSOC);

		if (!$user || !password_verify($password, $user['password'])) {
			return false;	//login failed		
		}

		session_start();

		$_SESSION['user_id'] = $user['id'];

		return true;	//login successful
	}


	public function isLoggedIn(): bool
	{
		session_start();
		return isset($_SESSION['user_id']);
	}

	public function logout(): void
	{
		session_start();
		unset($_SESSION['user_id']);
	}
}

?>