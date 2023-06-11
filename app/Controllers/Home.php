<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
	use ResponseTrait;
	public function index()
	{
		if (!session()->has('user_id')) return redirect()->to('signin');
		$data['page_title'] = 'Profile';
		$data['user'] = session()->get('user');
		return view('home', $data);
	}
}
