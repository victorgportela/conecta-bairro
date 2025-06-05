<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Servico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário de teste
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => Hash::make('password'),
        ]);

        // Criar serviços de exemplo
        $servicos = [
            [
                'nome' => 'Pedreiro',
                'descricao' => 'Serviços de alvenaria, reformas, construção de muros e reparos em geral. Mais de 15 anos de experiência na área.',
                'nome_prestador' => 'José Carlos',
                'telefone' => '(11) 99999-1234',
                'bairro' => 'Vila Madalena',
                'cidade' => 'São Paulo'
            ],
            [
                'nome' => 'Eletricista',
                'descricao' => 'Instalações elétricas residenciais e comerciais, manutenção, troca de disjuntores e reparos urgentes.',
                'nome_prestador' => 'Maria Santos',
                'telefone' => '(11) 98888-5678',
                'bairro' => 'Pinheiros',
                'cidade' => 'São Paulo'
            ],
            [
                'nome' => 'Costureira',
                'descricao' => 'Ajustes em roupas, costura sob medida, reparos e customização. Atendimento a domicílio disponível.',
                'nome_prestador' => 'Ana Oliveira',
                'telefone' => '(11) 97777-9999',
                'bairro' => 'Vila Madalena',
                'cidade' => 'São Paulo'
            ],
            [
                'nome' => 'Encanador',
                'descricao' => 'Reparos hidráulicos, desentupimentos, instalação de torneiras e chuveiros. Atendimento 24h para emergências.',
                'nome_prestador' => 'Roberto Lima',
                'telefone' => '(11) 96666-1111',
                'bairro' => 'Butantã',
                'cidade' => 'São Paulo'
            ],
            [
                'nome' => 'Diarista',
                'descricao' => 'Limpeza residencial semanal ou quinzenal. Serviço completo incluindo organização e pequenas tarefas domésticas.',
                'nome_prestador' => 'Fernanda Costa',
                'telefone' => '(11) 95555-2222',
                'bairro' => 'Vila Madalena',
                'cidade' => 'São Paulo'
            ]
        ];

        foreach ($servicos as $servico) {
            Servico::create($servico);
        }
    }
} 