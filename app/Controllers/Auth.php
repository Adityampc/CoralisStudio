<?php

namespace App\Controllers;

use App\Entities\User as EntitiesUser;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
	use ResponseTrait;
	public function signIn()
	{
		if (session()->has('user_id')) {
			return redirect()->to('/');
		}
		$data['page_title'] = "Sign In";
		return view('auth/signIn', $data);
	}
	public function signInCheck()
	{
		if (session()->has('user_id')) 			return $this->respond(['message' => "Already signed in", 'redirect' => base_url()]);

		$rules['email'] = [
			"alias" => "email",
			'rules' => 'valid_email|required',
			'errors' => [
				'valid_email' => 'Email Tidak Valid',
				'required' => 'Email Dibutuhkan',
			]
		];
		$rules['password'] = [
			"alias" => "Password",
			'rules' => 'string|required',
			'errors' => [
				'string' => 'Karakter Password Tidak Valid',
				'required' => 'Password Dibutuhkan',
			]
		];
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$err = '';
			foreach ($errors as $key => $error) {
				$err .= $error . '<br>';
			}
			return $this->failValidationErrors($err);
		}
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$userModel = new User();
		$user = $userModel->db->table('users')->where(['email' => $email])->get()->getRowArray();
		if (!$user) return $this->failNotFound("Email or password is incorrect");
		if (!password_verify($password, $user['password'])) return $this->failNotFound("Email or password is incorrect");
		if ($user['status'] == 'inactive') return $this->failNotFound("Account is inactive");
		session()->set(['user_id' => $user['id'], 'user' => $user]);
		return  $this->respond(['message' => "Sign In Successfully", 'redirect' => base_url()]);
	}
	public function signUp()
	{
		if (session()->has('user_id')) {
			return redirect()->to('/');
		}
		$data['page_title'] = "Sign Up";
		return view('auth/signUp', $data);
	}
	public function signUpCreate()
	{
		if (session()->has('user_id')) return $this->respond(['message' => "Already signed in", 'redirect' => base_url()]);
		$rules['name'] = [
			"alias" => "Name",
			'rules' => 'string|required',
			'errors' => [
				'string' => 'Name Invalid',
				'required' => 'Name Required',
			]
		];
		$rules['email'] = [
			"alias" => "Email",
			'rules' => 'required|valid_email|is_unique[users.email]',
			'errors' => [
				'valid_email' => 'Email Invalid',
				'is_unique' => "Email exists in the database",
				'required' => 'Email Required',
			]
		];
		$rules['password'] = [
			"alias" => "Password",
			'rules' => 'required|min_length[6]|max_length[32]|',
			'errors' => [
				'required' => 'Password Required',
				'min_length' => 'Password Minimum Length must be at least 6 characters',
				'max_length' => 'Password Maximum Length must be at least 32 characters',
			]
		];
		$rules['passconf'] = [
			"alias" => "Password Confirmation",
			'rules' => 'required|matches[password]',
			'errors' => [
				'required' => 'Password Confirmation Required',
				'matches' => 'Password Confirmation Not Matched',
			]
		];

		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$err = '';
			foreach ($errors as $key => $error) {
				$err .= $error . '<br>';
			}
			return $this->failValidationErrors($err);
		}
		$picture = $this->request->getFile('picture');
		if (!$picture) return $this->fail("Picture not found");
		else if (!$picture->isValid()) return $this->fail("Picture is not valid");
		$u['picture'] = $picture->getRandomName();
		$picture->move(FCPATH . IMG_PATH, $u['picture'], true);
		$u['email'] = $this->request->getPost('email');
		$u['name'] = $this->request->getPost('name');
		$u['status'] = 'active';
		$u['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
		$user = new EntitiesUser();
		$user->fill($u);
		$userModel = new User();
		$userModel->save($user);
		return $this->respond(['message' => "Sign Up Successfully", 'redirect' => base_url('signin')]);
	}
	public function forgot()
	{
		if (session()->has('user_id')) {
			return redirect()->to('/');
		}
		$data['page_title'] = "Forgot Password";
		return view('auth/forgot', $data);
	}
	public function forgotCheck()
	{
		if (session()->has('user_id')) return $this->respond(['message' => "Already signed in", 'redirect' => base_url()]);
		$hash = sha1(time());
		$rules['email'] = [
			"alias" => "email",
			'rules' => 'valid_email|required',
			'errors' => [
				'valid_email' => 'Email Tidak Valid',
				'required' => 'Email Dibutuhkan',
			]
		];
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$err = '';
			foreach ($errors as $key => $error) {
				$err .= $error . '<br>';
			}
			return $this->failValidationErrors($err);
		}
		$email = $this->request->getPost('email');
		$userModel = new User();
		$u = $userModel->db->table('users')->select('id,email,status')->where(['email' => $email])->get()->getRowArray();
		if (!$u) return $this->failNotFound("Email is incorrect");
		if ($u['status'] == 'inactive') return $this->failNotFound("Account is inactive");
		$u['forgot_hash'] = $hash;
		$user = new EntitiesUser();
		$user->fill($u);
		$userModel->save($user);
		return $this->respond(['message' => "Forgot Password Successfully", 'link' => base_url("reset/$hash")]);
	}

	public function reset($hash)
	{
		if (session()->has('user_id')) {
			return redirect()->to('/');
		}
		$userModel = new User();
		$u = $userModel->db->table('users')->select('id,email,password,status')->where(['forgot_hash' => $hash])->get()->getRowArray();
		if (!$u) return redirect()->to('signin');
		$data['page_title'] = "Reset Password";
		return view('auth/reset', $data);
	}
	public function resetCheck($hash)
	{
		if (session()->has('user_id')) return $this->respond(['message' => "Already signed in", 'redirect' => base_url()]);
		$rules['password'] = [
			"alias" => "Password",
			'rules' => 'required|min_length[6]|max_length[32]|',
			'errors' => [
				'required' => 'Password Required',
				'min_length' => 'Password Minimum Length must be at least 6 characters',
				'max_length' => 'Password Maximum Length must be at least 32 characters',
			]
		];
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$err = '';
			foreach ($errors as $key => $error) {
				$err .= $error . '<br>';
			}
			return $this->failValidationErrors($err);
		}
		$password = $this->request->getPost('password');
		$userModel = new User();
		$u = $userModel->db->table('users')->select('id,email,password,status')->where(['forgot_hash' => $hash])->get()->getRowArray();
		if (!$u) return $this->failNotFound("Session invalid");
		if ($u['status'] == 'inactive') return $this->failNotFound("Account is inactive");
		$u['forgot_hash'] = null;
		$u['password'] = password_hash($password, PASSWORD_DEFAULT);
		$user = new EntitiesUser();
		$user->fill($u);
		$userModel->save($user);
		return $this->respond(['message' => "Reset Password Successfully", 'redirect' => base_url("signin")]);
	}

	public function signOut()
	{
		session()->destroy();
		return redirect()->to('/');
	}
}
