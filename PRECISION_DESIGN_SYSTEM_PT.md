# Guia do Precision Design System (PDS)
**Versão: 1.0 | Projeto: Atines | Tema: Midnight Slate & Digital Blue**

Este documento serve como o guia oficial técnico e conceitual do **Precision Design System (PDS)**. Seu objetivo é garantir que todos os desenvolvimentos futuros, módulos e expansões da plataforma mantenham uma estética rigorosa, profissional e de alta fidelidade.

---

## 1. Filosofia de Design
O PDS é construído sobre três pilares:
*   **Precisão**: Cada elemento é alinhado a um sistema de grade (grid) estrito de 8pt.
*   **Clareza**: Tipografia de alto contraste e cores semânticas para minimizar a carga cognitiva.
*   **Profundidade**: Uso de sombras ambientais em camadas em vez de bordas simples para criar uma sensação premium de "elevação".

---

## 2. Fundamentos

### 2.1 Espaçamento Atômico (Grade de 8pt)
Todos os paddings, margens e espaçamentos devem seguir a **Escala de 8pt**. Isso cria uma harmonia matemática em toda a interface.

| Token | Pixels | Variável CSS | Uso |
| :--- | :--- | :--- | :--- |
| `space-4` | 4px | `--space-4` | Micro-ajustes, espaçamento de ícones |
| `space-8` | 8px | `--space-8` | Unidade base, padding pequeno |
| `space-16` | 16px | `--space-16` | Padding de conteúdo padrão |
| `space-24` | 24px | `--space-24` | Padding de cards, vãos de seção |
| `space-32` | 32px | `--space-32` | Margens de página |

### 2.2 Paleta de Cores
O sistema utiliza um núcleo **Slate/Zinc Neutro** com um tom de **Saturação Azul de 2%** para manter a interface com uma aparência moderna e "fria".

#### Neutros (Slate-Zinc)
*   **Fundo (Primário)**: `#fafafa` (Slate-50)
*   **Fundo (Elevado/Cards)**: `#ffffff` (Branco Puro)
*   **Texto (Primário/Títulos)**: `#18181b` (Zinc-900)
*   **Texto (Secundário/Corpo)**: `#3f3f46` (Zinc-700)
*   **Bordas (Sutis)**: `#e4e4e7` (Zinc-200)

#### Acentos e Semântica
*   **Ação Primária**: `#3b82f6` (Blue-500)
*   **Hover Primário**: `#2563eb` (Blue-600)
*   **Sucesso**: `#10b981` (Emerald-500)
*   **Aviso**: `#f59e0b` (Amber-500)
*   **Erro**: `#ef4444` (Red-500)

### 2.3 Tipografia (Escala Major Third)
Utilizamos uma **Escala Tipográfica de 1.250** para garantir que os cabeçalhos sejam distintos e profissionais.
*   **Família de Fontes**: `Outfit` (Primária), `Inter` (Secundária/Sistema), `JetBrains Mono` (Dados/Números).

| Nível | Tamanho | Peso | Uso |
| :--- | :--- | :--- | :--- |
| **Título 1** | 61px | Bold | Seções Hero |
| **Título 3** | 39px | Semibold | Títulos de Páginas Principais |
| **Título 5** | 25px | Semibold | Cabeçalhos de Cards |
| **Corpo** | 16px | Regular | Texto Geral |
| **Legenda** | 12px | Regular | Metadados, tooltips |

### 2.4 Elevação e Sombras
Evitamos bordas pesadas. Em vez disso, usamos **Oclusão Ambiental (Sombras em Camadas)** para simular profundidade física.

*   **Shadow MD**: `0 4px 6px -2px rgba(0,0,0,0.05), 0 10px 15px -3px rgba(0,0,0,0.08), 0 2px 4px -1px rgba(0,0,0,0.04)`
*   **Shadow LG**: `0 10px 15px -3px rgba(0,0,0,0.08), 0 20px 25px -5px rgba(0,0,0,0.10)`

---

## 3. Componentes de UI

### 3.1 O Precision Card
O bloco fundamental de construção. Cada módulo de dados ou grupo de formulários deve ser contido em um `.precision-card`.

```html
<div class="precision-card">
    <div class="precision-card-header precision-flex-between">
        <div class="precision-flex">
            <div class="icon-wrapper bg-blue-50">
                <i class="fas fa-icon text-blue-600"></i>
            </div>
            <h2 class="precision-heading-5">Título</h2>
        </div>
        <div class="actions">
            <!-- Botões aqui -->
        </div>
    </div>
    <div class="precision-mt-24">
        <!-- Conteúdo aqui -->
    </div>
</div>
```

### 3.2 Botões
Os botões usam transições sutis de hover e micro-sombras.

*   `.precision-btn-primary`: Fundo azul, texto branco. CTA Primário.
*   `.precision-btn-secondary`: Fundo cinza claro, borda zinc. Ações secundárias.
*   `.precision-btn-ghost`: Fundo transparente. Ações minimalistas (ícones de Editar/Visualizar/Excluir).

### 3.3 Badges de Status
Usadas para indicadores de status (Ativo, Inativo, Pendente). Use fundo de baixa saturação com texto de alta saturação para legibilidade.

| Tipo | Classes |
| :--- | :--- |
| **Primário** | `.precision-badge.precision-badge-primary` |
| **Sucesso** | `.precision-badge.precision-badge-success` |
| **Erro** | `.precision-badge.precision-badge-error` |

---

## 4. Avançado: Padronização de DataTables
Este é o "ingrediente secreto" do projeto Atines. Para manter a aparência premium das tabelas, sempre use o **Precision DataTable Wrapper**.

### 4.1 Estrutura HTML
```html
<div class="precision-datatable-wrapper">
    <table id="my-table" class="precision-table">
        <thead><!-- Cabeçalhos padrão --></thead>
        <tbody><!-- Linhas padrão --></tbody>
    </table>
</div>
```

### 4.2 Inicialização JavaScript (O Padrão)
```javascript
$('#my-table').DataTable({
    responsive: true,
    language: { url: "{{ asset('js/pt-BR.json') }}" },
    dom: '<"precision-datatable-header"lBf>rt<"precision-datatable-footer"ip>',
    buttons: [
        {
            extend: 'excel',
            text: '<i class="fas fa-file-excel mr-2"></i> Excel',
            className: 'precision-btn precision-btn-secondary precision-btn-sm'
        },
        // ... (PDF, Imprimir)
    ]
});
```

---

## 5. Padrões de UX

### 5.1 Feedback (Alertas de Sessão)
Sempre coloque alertas de sessão (`success`, `error`) no topo do `.precision-container`, antes de qualquer card. Use os ícones PDS personalizados e cantos levemente arredondados.

### 5.2 Iconografia
O sistema utiliza **Font Awesome 6 Pro/Free**.
*   **Cores**: Use `text-blue-600` para ícones ativos e `text-slate-400` para ícones passivos/metadados.
*   **Agrupamento**: Sempre envolva ícones com `precision-mr-8` quando colocados ao lado de texto.

### 5.3 Estados Vazios (Empty States)
Quando uma tabela estiver vazia, não mostre uma página em branco. Exiba uma **Box de Informação Âmbar** com um CTA claro (ex: "Nenhum dado encontrado - Clique em Novo").

---

## 6. Classes Utilitárias CSS
Embora usemos Variáveis CSS, temos um conjunto de "Utilitários Precision":
*   `.precision-p-24`: Padding consistente de card.
*   `.precision-mb-24`: Ritmo vertical consistente.
*   `.precision-flex-between`: Centralização padrão de cabeçalho.
*   `.precision-flex-center`: Usado para alinhamento de botões de ação dentro de células de tabela.

---

> [!IMPORTANT]
> **Consistência é Fundamental.** Não introduza códigos hexadecimais fixos nos arquivos Blade. Sempre use as variáveis `--color-*` definidas em `precision-design.css`.
