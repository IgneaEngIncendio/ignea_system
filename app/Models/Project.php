<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'ocupacoes'                    => 'array',
        'medidas_selecionadas'         => 'array',
        'sdai_componentes'             => 'array',
        'chuveiro_tipos'               => 'array',
        'chuveiro_vgas'                => 'array',
        'chuveiro_tabela_areas'        => 'array',
        'chuveiro_tabela_areas_colunas'=> 'array',
        'chuveiro_bombas'              => 'array',
        'isolamentos'                  => 'array',
        'me_itens_adicionais'          => 'array',
        'me_tabela_sinalizacao'        => 'array',
        'me_tabela_equipamentos'       => 'array',
        'comprov_itens'                => 'array',
        'tabela_populacao'             => 'array',
        'tabela_ci'                    => 'array',
        'setores_compartimentacao'     => 'array',
        'area_fria'                    => 'boolean',
        'tem_glp'                      => 'boolean',
        'tem_gerador'                  => 'boolean',
        'tem_subestacao'               => 'boolean',
        'edificacao_existente'         => 'boolean',
        'substituicao_projeto'         => 'boolean',
        'edificacao_residencial'       => 'boolean',
        'edificacao_aluguel'           => 'boolean',
        'porta_correr_saida_emergencia'=> 'boolean',
        'sdai_enderecavel'             => 'boolean',
        'sdai_nota3_cscip'             => 'boolean',
        'sdai_tem_damper'              => 'boolean',
        'chuveiro_tem_camara_fria'     => 'boolean',
        'chuveiro_ul_fm'               => 'boolean',
        'pne'                          => 'boolean',
    ];
}
