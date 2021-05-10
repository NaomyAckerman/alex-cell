<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\{UserModel, KonterModel};
use CodeIgniter\Router\Exceptions\RedirectException;

class UserController extends BaseController
{
    protected $user, $euser, $konter;
    public function __construct()
    {
        $this->user = new UserModel();
        $this->euser = new User();
        $this->konter = new KonterModel();
    }
    public function index()
    {
        return \view('pages/user/index', ['title' => 'Karyawan']);
    }
    public function user()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('user');
        $data = [
            'status' => 'success',
            'data' => \view('pages/user/user', [
                'users' => $this->user->where('auth_groups.name !=', 'owner')
                    ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                    ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                    ->groupBy('users.id')->findAll()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function create()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('user');
        $data = [
            'status' => 'success',
            'data' => \view('pages/user/tambah_user', [
                'konter' => $this->konter->findAll(),
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function store()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('user');
        $pass = $this->request->getVar('password_hash');
        $konter = $this->request->getVar('konter_id');
        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $alamat = $this->request->getVar('alamat');
        $no_telp = $this->request->getVar('no_telp');
        $jenkel = $this->request->getVar('jenkel');
        $this->euser->konter_id = $konter;
        $this->euser->email = $email;
        $this->euser->username = $username;
        $this->euser->alamat = $alamat;
        $this->euser->no_telp = $no_telp;
        $this->euser->jenkel = $jenkel;
        ($pass) ? $this->euser->setPassword($pass) : false;
        $this->euser->activate();
        $result = $this->user->withGroup($this->request->getVar('role'))->save($this->euser);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'Bad Request',
                    'errors' => $this->user->errors(),
                    'token' => csrf_hash(),
                ]);
        }
        $data = [
            'status' => 'success',
            'data' => 'Berhasil menyimpan karyawan baru <strong>' . $this->request->getVar('username') . '</strong>',
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function block($id)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('user');
        $nama = $this->request->getVar('user');
        $status = $this->request->getVar('status');
        $data = ['status' => 'success'];
        if ($status == 'block') {
            $this->user->update($id, ['status' => null]);
            $data['data'] = "Berhasil unblock karyawan <strong>$nama</strong>";
        } else {
            $this->user->update($id, ['status' => 'block']);
            $data['data'] = "Berhasil block karyawan <strong>$nama</strong>";
        }
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function delete($id)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('user');
        $nama = $this->request->getVar('user');
        $this->user->delete($id, true);
        $data = [
            'status' => 'success',
            'data' => "Berhasil hapus karyawan <strong>$nama</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function profile()
    {
        return \view('pages/user/profile', [
            'title' => 'Profile',
            'user' => \user()->username
        ]);
    }
    public function info_profile()
    {
        if (!$this->request->isAJAX()) throw new RedirectException('profile');
        $data = [
            'status' => 'success',
            'data' => \view('pages/user/info_profile', [
                'profile' => $this->user->where('user_id', \user()->id)
                    ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                    ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id')
                    ->join('konter', 'konter.id = users.konter_id')
                    ->groupBy('users.id')->first()
            ]),
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
    public function update_profile($id)
    {
        if (!$this->request->isAJAX()) throw new RedirectException('profile');
        $file = $this->request->getFile('avatar');
        $pass = $this->request->getVar('password');

        $avatar = (!$file->isValid()) ? \user()->avatar : $file->getRandomName();
        $this->euser->fill($this->request->getVar());
        ($pass) ? $this->euser->setPassword($pass) : $this->euser->password_hash = \user()->password_hash;
        $this->euser->avatar = $avatar;
        $this->euser->id = $id;
        $result = $this->user->save($this->euser);
        if (!$result) {
            return $this->response->setStatusCode(400)
                ->setJSON(
                    [
                        'status' => 'Bad Request',
                        'errors' => $this->user->errors(),
                        'token' => csrf_hash(),
                    ]
                );
        }
        if ($file->isValid() && !$file->hasMoved()) {
            if (\user()->avatar) \unlink('assets/images/users/' . \user()->avatar);
            $file->move('assets/images/users', $avatar);
        }
        $data = [
            'status' => 'success',
            'data' => "Berhasil Edit <strong>Profile</strong>",
        ];
        return $this->response->setStatusCode(200)
            ->setJSON($data);
    }
}
