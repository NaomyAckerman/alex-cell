<?php

namespace App\Models;

use CodeIgniter\Model;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Entities\User;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = User::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'konter_id', 'email', 'alamat', 'no_telp', 'jenkel', 'username', 'avatar', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'konter_id' => [
            'label'  => 'Konter',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memilih {field}.'
            ]
        ],
        'email' => [
            'label'  => 'Email',
            'rules'  => 'required|valid_email|is_unique[users.email,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.',
                'valid_email' => '{field} tidak valid.',
                'is_unique' => '{field} sudah tersedia.'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required|alpha_numeric_punct|min_length[3]|is_unique[users.username,id,{id}]',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.',
                'min_length' => '{field} kurang dari 3.',
                'is_unique' => '{field} sudah tersedia.'
            ]
        ],
        'password_hash' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.'
            ]
        ],
        'alamat' => [
            'label'  => 'Alamat',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.'
            ]
        ],
        'no_telp' => [
            'label'  => 'No Telp',
            'rules'  => 'required|numeric|exact_length[11,13,12]',
            'errors' => [
                'required' => 'Anda harus memasukkan {field}.',
                'numeric' => '{field} harus berupa angka.',
                'exact_length' => 'Jumlah {field} tidak valid.'
            ]
        ]
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterInsert = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     * @var int
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     *
     * @param string      $email
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logResetAttempt(string $email, string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_reset_attempts')->insert([
            'email' => $email,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Logs an activation attempt for posterity sake.
     *
     * @param string|null $token
     * @param string|null $ipAddress
     * @param string|null $userAgent
     */
    public function logActivationAttempt(string $token = null, string $ipAddress = null, string $userAgent = null)
    {
        $this->db->table('auth_activation_attempts')->insert([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Sets the group to assign any users created.
     *
     * @param string $groupName
     *
     * @return $this
     */
    public function withGroup(string $groupName)
    {
        $group = $this->db->table('auth_groups')->where('name', $groupName)->get()->getFirstRow();

        $this->assignGroup = $group->id;

        return $this;
    }

    /**
     * Clears the group to assign to newly created users.
     *
     * @return $this
     */
    public function clearGroup()
    {
        $this->assignGroup = null;

        return $this;
    }

    /**
     * If a default role is assigned in Config\Auth, will
     * add this user to that group. Will do nothing
     * if the group cannot be found.
     *
     * @param $data
     *
     * @return mixed
     */
    protected function addToGroup($data)
    {
        if (is_numeric($this->assignGroup)) {
            $groupModel = model(GroupModel::class);
            $groupModel->addUserToGroup($data['id'], $this->assignGroup);
        }

        return $data;
    }
    public function in_group($role)
    {
        return $this->where('auth_groups.name', $role)
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->findAll();
    }
}
