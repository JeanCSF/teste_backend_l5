<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome', 'preco'];

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
        'nome' => 'required|min_length[3]|max_length[255]',
        'preco' => 'required|numeric'
    ];
    protected $validationMessages   = [];
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
        $dados =  $q ? $this->select('*')->like('nome', $q)->orLike('preco', $q)->paginate($limit) : $this->select('*')->paginate($limit);
        $totalRegistros = $q ? $this->like('nome', $q)->orLike('preco', $q)->countAllResults() : $this->countAll();

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
