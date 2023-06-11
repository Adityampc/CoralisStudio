<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type'       => 'CHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type'       => 'TEXT',
            ],
            'forgot_hash' => [
                'type'       => 'TEXT',
                'default' => null,
            ],
            'picture' => [
                'type'       => 'TEXT',
                'default' => 'avatar.jpg',
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'inactive',
            ],
            'created_at'  => [
                'type'       => 'INT',
                'constraint' => 11,

            ],
            'updated_at'  => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
