<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['usuario', 'senha'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'usuario' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.usuario]',
        'senha' => 'required|min_length[3]|max_length[255]'
    ];
    protected $validationMessages   = [
        'usuario' => [
            'required' => 'O campo nome de usuário deve ser informado',
            'is_unique' => 'Este nome de usuário ja existe'
        ],
        'senha' => [
            'required' => 'O campo senha deve ser informado'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function criar(object $post)
    {
        $post->senha = password_hash($post->senha, PASSWORD_BCRYPT);
        return $this->save($post);
    }

    public function autenticar(object $post)
    {
        $usuario = $post->usuario;
        $senha = $post->senha;

        $usuarioExiste = $this->where('usuario', $usuario)->first();
        if ($usuarioExiste) {
            if (password_verify($senha, $usuarioExiste['senha'])) {
                return $usuarioExiste;
            }
        }

        return false;
    }
}
