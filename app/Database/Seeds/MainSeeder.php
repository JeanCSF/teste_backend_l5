<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {

        // Tabela Usuários
        $this->db->table('usuarios')->insert([
            'usuario' => 'admin',
            'senha' => password_hash('admin', PASSWORD_BCRYPT)
        ]);

        // Tabela Clientes
        $clientes = [
            [
                'nome_razao' => 'João Silva',
                'cpf_cnpj' => '12345678901',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Maria Oliveira',
                'cpf_cnpj' => '23456789012',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Empresa ABC Ltda',
                'cpf_cnpj' => '12345678000190',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Carlos Pereira',
                'cpf_cnpj' => '34567890123',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Ana Costa',
                'cpf_cnpj' => '45678901234',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Empresa XYZ S.A.',
                'cpf_cnpj' => '98765432000177',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Fernanda Lima',
                'cpf_cnpj' => '56789012345',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'José Santos',
                'cpf_cnpj' => '67890123456',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Lucas Souza',
                'cpf_cnpj' => '78901234567',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome_razao' => 'Carla Mota',
                'cpf_cnpj' => '89012345678',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('clientes')->insertBatch($clientes);


        // Tabela Produtos
        $produtos = [
            [
                'nome' => 'Caneta Azul',
                'preco' => '1.00',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Caneta Preta',
                'preco' => '2.50',
                'created_at' => date('Y-m-d H:i:s')

            ],
            [
                'nome' => 'Caneta Verde',
                'preco' => '3.00',
                'created_at' => date('Y-m-d H:i:s')

            ],
            [
                'nome' => 'Caneta Vermelha',
                'preco' => '4.50',
                'created_at' => date('Y-m-d H:i:s')

            ],
            [
                'nome' => 'Caneta Roxa',
                'preco' => '5.00',
                'created_at' => date('Y-m-d H:i:s')

            ],
        ];

        $this->db->table('produtos')->insertBatch($produtos);


        // Tabela Pedidos
        $pedidos = [
            [
                'id_cliente' => 1,
                'id_produto' => 1,
                'status' => 'Em Aberto',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cliente' => 2,
                'id_produto' => 2,
                'status' => 'Cancelado',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cliente' => 3,
                'id_produto' => 3,
                'status' => 'Pago',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cliente' => 4,
                'id_produto' => 4,
                'status' => 'Pago',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cliente' => 5,
                'id_produto' => 5,
                'status' => 'Em Aberto',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('pedidos')->insertBatch($pedidos);
    }
}
