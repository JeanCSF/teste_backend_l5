<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Api extends Migration
{
    public function up()
    {
        //Tabela Usuários
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false
            ],
            'senha' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('usuarios', true, ['ENGINE' => 'InnoDB']);

        // Tabela Clientes
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome_razao' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'cpf_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => 14,
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('clientes', true, ['ENGINE' => 'InnoDB']);


        // Tabela Produtos
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'preco' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('produtos', true, ['ENGINE' => 'InnoDB']);

        //Tabela Pedidos
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_cliente' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'id_produto' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
                'default' => 'Em Aberto'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_cliente', 'clientes', 'id', 'NO ACTION', 'NO ACTION');
        $this->forge->addForeignKey('id_produto', 'produtos', 'id', 'NO ACTION', 'NO ACTION');
        $this->forge->createTable('pedidos', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('clientes');
        $this->forge->dropTable('produtos');
        $this->forge->dropTable('pedidos');
        $this->forge->dropTable('usuarios');
    }
}
