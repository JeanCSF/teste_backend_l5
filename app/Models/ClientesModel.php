<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome_razao', 'cpf_cnpj'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nome_razao' => 'required|min_length[3]|max_length[255]',
        'cpf_cnpj' => 'required|min_length[11]|max_length[14]|is_unique[clientes.cpf_cnpj]'
    ];
    protected $validationMessages   = [
        'nome_razao' => [
            'required' => 'O campo nome ou razão social deve ser informado',
            'min_length' => 'O campo nome ou razão social deve ter pelo menos 3 caracteres',
            'max_length' => 'O campo nome ou razão social deve ter no maúximo 255 caracteres'
        ],
        'cpf_cnpj' => [
            'required' => 'O campo CPF/CNPJ deve ser informado',
            'min_length' => 'O campo CPF/CNPJ deve ter pelo menos 11 caracteres',
            'max_length' => 'O campo CPF/CNPJ deve ter no maúximo 14 caracteres',
            'is_unique' => 'Este CPF/CNPJ já foi cadastrado'
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


    public function getAll($limit, $page, $q = null)
    {
        $dados =  $q ? $this->select('*')->like('nome_razao', $q)->orLike('cpf_cnpj', $q)->paginate($limit) : $this->select('*')->paginate($limit);
        $totalRegistros = $q ? $this->like('nome_razao', $q)->orLike('cpf_cnpj', $q)->countAllResults() : $this->countAll();

        $response = [
            'cabecalho' => [
                'status' => 200,
                'mensagem' => 'Dados retornados com sucesso'
            ],
            'retorno' =>  $dados,
            'paginacao' => [
                'pagina' => $page,
                'total_registros' => $totalRegistros,
                'total_paginas' => ceil($totalRegistros / $limit),
                'ultima_pagina' => $page * $limit < $totalRegistros ? false : true
            ]
        ];

        return $response;
    }
}
