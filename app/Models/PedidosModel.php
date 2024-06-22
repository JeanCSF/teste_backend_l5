<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidosModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_cliente', 'id_produto', 'status'];

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
        'id_cliente' => 'required|numeric',
        'id_produto' => 'required|numeric',
        'status' => 'required'
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
        $dados =  null;
        $totalRegistros = null;
        if ($q) {
            $dados =  $this
                ->select('pedidos.id, clientes.nome_razao, clientes.cpf_cnpj, produtos.nome AS produto, produtos.preco, pedidos.status')
                ->join('produtos', 'produtos.id = pedidos.id_produto')
                ->join('clientes', 'clientes.id = pedidos.id_cliente')
                ->like('clientes.nome_razao', $q)
                ->orLike('clientes.cpf_cnpj', $q)
                ->orLike('produtos.nome', $q)
                ->orLike('produtos.preco', $q)
                ->orLike('pedidos.status', $q)
                ->paginate($limit);

            $totalRegistros = $this->join('produtos', 'produtos.id = pedidos.id_produto')
                ->join('clientes', 'clientes.id = pedidos.id_cliente')
                ->like('clientes.nome_razao', $q)
                ->orLike('clientes.cpf_cnpj', $q)
                ->orLike('produtos.nome', $q)
                ->orLike('produtos.preco', $q)
                ->orLike('pedidos.status', $q)->countAllResults();
        } else {
            $dados =  $this
                ->select('pedidos.id, clientes.nome_razao, clientes.cpf_cnpj, produtos.nome AS produto, produtos.preco, pedidos.status')
                ->join('produtos', 'produtos.id = pedidos.id_produto')
                ->join('clientes', 'clientes.id = pedidos.id_cliente')
                ->paginate($limit);
                
            $totalRegistros = $this->countAll();
        }

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
