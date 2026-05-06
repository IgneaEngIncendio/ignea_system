<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Identificação
            $table->string('codigo_interno');
            $table->string('nome_obra');
            $table->string('mes_ano')->nullable();
            $table->string('cidade_analise_bombeiros')->nullable();

            // Proprietário
            $table->string('nome_proprietario')->nullable();
            $table->string('tipo_documento')->default('CNPJ');
            $table->string('cpf_cnpj')->nullable();
            $table->string('nome_signatario')->nullable();
            $table->string('cpf_signatario')->nullable();
            $table->string('rg_signatario')->nullable();

            // Endereço
            $table->string('endereco')->nullable();
            $table->string('cidade')->default('Cascavel');
            $table->string('estado')->default('PR');
            $table->string('cep')->nullable();

            // Responsável Técnico
            $table->string('rt_nome')->default('Eng. Ana Julia Zunta Carniel');
            $table->string('rt_crea')->default('CREA-PR 168.913/D');
            $table->string('rt_email')->nullable();
            $table->string('rt_telefone')->nullable();

            // Edificação
            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('altura', 8, 2)->nullable();
            $table->integer('num_pavimentos')->nullable();
            $table->boolean('area_fria')->default(false);
            $table->decimal('area_fria_m2', 10, 2)->nullable();

            // Características construtivas
            $table->string('estrutura')->nullable();
            $table->string('divisao_interna')->nullable();
            $table->string('cobertura')->nullable();
            $table->string('forro')->nullable();
            $table->string('pisos')->nullable();
            $table->string('esquadrias')->nullable();

            // Ocupações e medidas (JSON)
            $table->json('ocupacoes')->nullable();            // [{grupo, divisao, area, ci}]
            $table->json('medidas_selecionadas')->nullable(); // ['extintor', 'hidrante', ...]

            // Riscos especiais
            $table->boolean('tem_glp')->default(false);
            $table->boolean('tem_gerador')->default(false);
            $table->boolean('tem_subestacao')->default(false);

            // Brigada
            $table->string('tipo_brigadista')->default('organico');
            $table->integer('populacao_total')->nullable();
            $table->boolean('risco_espaco_confinado')->default(false);
            $table->boolean('risco_trabalho_altura')->default(false);
            $table->boolean('risco_produtos_perigosos')->default(false);

            // Hidrante
            $table->string('hidrante_tipo')->nullable();
            $table->integer('hidrante_dn_esguicho')->nullable();
            $table->integer('hidrante_dn_mangueira')->nullable();
            $table->integer('hidrante_comprimento_interno')->nullable();
            $table->integer('hidrante_comprimento_externo')->nullable();
            $table->integer('hidrante_num_internos')->nullable();
            $table->integer('hidrante_num_externos')->nullable();
            $table->string('hidrante_dimensao_caixaria')->nullable();
            $table->string('hidrante_tipo_mangueira')->nullable();
            $table->decimal('hidrante_vazao_minima', 8, 2)->nullable();
            $table->decimal('hidrante_pressao_minima', 8, 2)->nullable();
            $table->string('sistema_hidrante_pressurizacao')->nullable();
            $table->string('sistema_hidrante_acionamento')->nullable();
            $table->string('hidrante_recalque_tipo')->default('enterrado');
            $table->string('ocupacao_dimensionamento_hidrante')->nullable();

            // Reservatório
            $table->decimal('reservatorio_volume', 8, 2)->nullable();
            $table->string('reservatorio_tipo')->default('superior');
            $table->integer('reservatorio_num')->nullable();
            $table->decimal('reservatorio_volume_unitario', 8, 2)->nullable();
            $table->string('reservatorio_abastecimento')->nullable();

            // Motobomba
            $table->string('bomba_marca')->nullable();
            $table->string('bomba_modelo')->nullable();
            $table->integer('bomba_hz')->default(60);
            $table->integer('bomba_rotor_mm')->nullable();
            $table->decimal('bomba_potencia_cv', 8, 2)->nullable();
            $table->decimal('bomba_vazao_m3h', 8, 2)->nullable();
            $table->decimal('bomba_altura_mca', 8, 2)->nullable();

            // GLP
            $table->string('glp_tipo_central')->default('normal');
            $table->integer('glp_num_cilindros')->nullable();
            $table->string('glp_tipo_cilindro')->nullable();
            $table->decimal('glp_capacidade_kg', 8, 2)->nullable();
            $table->string('glp_hidrante_atende')->nullable();
            $table->string('glp_extintores')->nullable();

            // Gerador
            $table->string('gerador_combustivel')->default('diesel');
            $table->integer('gerador_capacidade_litros')->nullable();

            // Plano de emergência
            $table->boolean('pne')->default(false);
            $table->string('horario_funcionamento')->nullable();
            $table->string('caracteristicas_entorno')->nullable();
            $table->decimal('distancia_bombeiros_km', 8, 2)->nullable();
            $table->string('endereco_bombeiros')->nullable();
            $table->string('hospital_nome')->nullable();
            $table->string('hospital_endereco')->nullable();
            $table->string('via_acesso')->nullable();

            // Termos
            $table->boolean('edificacao_residencial')->default(false);
            $table->boolean('edificacao_aluguel')->default(false);
            $table->boolean('porta_correr_saida_emergencia')->default(false);

            // Edificação existente / substituição
            $table->boolean('edificacao_existente')->default(false);
            $table->string('tipo_existente')->default('tipo_1');
            $table->boolean('substituicao_projeto')->default(false);
            $table->string('subst_num_projeto_anterior')->nullable();
            $table->string('subst_rt_anterior_nome')->nullable();
            $table->string('subst_rt_anterior_crea')->nullable();
            $table->text('subst_motivo')->nullable();

            // Textos livres do memorial
            $table->text('descricao_edificacao')->nullable();
            $table->text('texto_carga_incendio')->nullable();
            $table->text('texto_medidas_seguranca')->nullable();
            $table->text('texto_compartimentacao')->nullable();
            $table->text('texto_alarme_deteccao')->nullable();
            $table->text('texto_liquidos_inflamaveis')->nullable();
            $table->decimal('area_max_compartimentacao', 10, 2)->nullable();

            // SDAI
            $table->boolean('sdai_enderecavel')->default(true);
            $table->string('sdai_classe')->default('A');
            $table->boolean('sdai_nota3_cscip')->default(false);
            $table->boolean('sdai_tem_damper')->default(false);
            $table->string('sdai_local_central')->default('portaria');
            $table->json('sdai_componentes')->nullable();

            // Chuveiros automáticos
            $table->text('chuveiro_normas')->nullable();
            $table->json('chuveiro_tipos')->nullable();
            $table->boolean('chuveiro_tem_camara_fria')->default(false);
            $table->boolean('chuveiro_ul_fm')->default(false);
            $table->decimal('chuveiro_vazao_hidrantes', 8, 2)->nullable();
            $table->json('chuveiro_vgas')->nullable();
            $table->json('chuveiro_tabela_areas')->nullable();
            $table->json('chuveiro_tabela_areas_colunas')->nullable();
            $table->text('chuveiro_rti_descricao_area')->nullable();
            $table->integer('chuveiro_rti_tempo_min')->default(60);
            $table->string('chuveiro_rti_sprinkler_tipo')->nullable();
            $table->decimal('chuveiro_rti_sprinkler_area_cob', 8, 2)->nullable();
            $table->decimal('chuveiro_rti_sprinkler_pressao_min', 8, 2)->nullable();
            $table->integer('chuveiro_rti_sprinkler_num')->nullable();
            $table->decimal('chuveiro_rti_sprinkler_vazao', 10, 2)->nullable();
            $table->decimal('chuveiro_rti_hidrante_vazao_min', 10, 2)->nullable();
            $table->decimal('chuveiro_rti_hidrante_vazao_calc', 10, 2)->nullable();
            $table->decimal('chuveiro_rti_calculada', 8, 2)->nullable();
            $table->json('chuveiro_bombas')->nullable();

            // Isolamento de risco
            $table->json('isolamentos')->nullable();

            // Memorial executivo
            $table->text('me_texto_regularizacoes_civis')->nullable();
            $table->json('me_itens_adicionais')->nullable();
            $table->json('me_tabela_sinalizacao')->nullable();
            $table->json('me_tabela_equipamentos')->nullable();

            // Memorial industrial
            $table->text('memorial_ind_atividade')->nullable();
            $table->text('memorial_ind_materias_primas')->nullable();
            $table->text('memorial_ind_produtos_acabados')->nullable();
            $table->text('memorial_ind_processo')->nullable();
            $table->text('memorial_ind_info_complementares')->nullable();
            $table->text('memorial_ind_liquidos_gases')->nullable();

            // Comprovação de existência
            $table->string('comprov_num_processo')->nullable();
            $table->string('comprov_tipo_existente')->default('tipo_1');
            $table->json('comprov_itens')->nullable();
            $table->text('comprov_texto_complementar')->nullable();

            // Tabelas externas (Excel/Revit)
            $table->json('tabela_populacao')->nullable();
            $table->json('tabela_ci')->nullable();
            $table->json('setores_compartimentacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
