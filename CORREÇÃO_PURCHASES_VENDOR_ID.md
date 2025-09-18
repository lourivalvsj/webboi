# Correção do Erro na Tabela Purchases - vendor_id

## Problema Identificado

**Erro**: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'vendor_id' in 'field list'`

O sistema estava tentando inserir dados na tabela `purchases` com uma coluna `vendor_id` que não existia na estrutura da tabela.

## Diagnóstico

### Migration Original
A migration `2021_10_17_224321_create_purchases_table.php` criava a tabela sem a coluna `vendor_id`:

```php
Schema::create('purchases', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('animal_id');
    $table->date('purchase_date')->nullable();
    $table->decimal('value', 10, 2)->nullable();
    $table->decimal('freight_cost', 10, 2)->nullable();
    $table->string('transporter')->nullable();
    $table->decimal('commission_value', 10, 2)->nullable();
    $table->decimal('commission_percent', 5, 2)->nullable();
    $table->timestamps();
    
    $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
});
```

### Modelo Purchase
O modelo estava configurado para usar `vendor_id`:

```php
protected $fillable = [
    'animal_id',
    'vendor_id',  // ← COLUNA QUE NÃO EXISTIA
    'purchase_date',
    'value',
    'freight_cost',
    'transporter',
    'commission_value',
    'commission_percent'
];

public function vendor()
{
    return $this->belongsTo(Vendor::class);  // ← RELACIONAMENTO INVÁLIDO
}
```

### Controller
O controller validava e tentava salvar com `vendor_id`:

```php
$request->validate([
    'vendor_id' => 'nullable|exists:vendors,id',  // ← VALIDAÇÃO PARA COLUNA INEXISTENTE
]);
```

## Solução Implementada

### 1. Criação da Migration de Correção

**Arquivo**: `2025_09_18_231433_add_vendor_id_to_purchases_table.php`

```php
public function up()
{
    Schema::table('purchases', function (Blueprint $table) {
        $table->unsignedBigInteger('vendor_id')->nullable()->after('animal_id');
        $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('purchases', function (Blueprint $table) {
        $table->dropForeign(['vendor_id']);
        $table->dropColumn('vendor_id');
    });
}
```

### 2. Atualização do Controller

**Melhorias implementadas**:
- Validações mais robustas
- Uso de `only()` para maior segurança
- Mensagens em português
- Validação de todos os campos disponíveis

```php
public function store(Request $request)
{
    $request->validate([
        'animal_id' => 'required|exists:animals,id',
        'vendor_id' => 'nullable|exists:vendors,id',
        'purchase_date' => 'nullable|date',
        'value' => 'required|numeric|min:0',
        'freight_cost' => 'nullable|numeric|min:0',
        'transporter' => 'nullable|string|max:255',
        'commission_value' => 'nullable|numeric|min:0',
        'commission_percent' => 'nullable|numeric|min:0|max:100',
    ]);

    $data = $request->only([
        'animal_id', 'vendor_id', 'purchase_date', 'value',
        'freight_cost', 'transporter', 'commission_value', 'commission_percent'
    ]);

    Purchase::create($data);
    return redirect()->route('purchases.index')->with('success', 'Compra registrada com sucesso.');
}
```

### 3. Modernização do Formulário

**Melhorias implementadas**:
- Layout responsivo moderno
- Validação visual de erros
- Todos os campos disponíveis
- Melhor UX com labels descritivas
- Estilo consistente com o resto do sistema

## Estrutura Final da Tabela

Após a correção, a tabela `purchases` possui:

```sql
- id (primary key)
- animal_id (foreign key → animals.id) [obrigatório]
- vendor_id (foreign key → vendors.id) [opcional]
- purchase_date (date, nullable)
- value (decimal 10,2, obrigatório)
- freight_cost (decimal 10,2, opcional)
- transporter (string, opcional)
- commission_value (decimal 10,2, opcional)
- commission_percent (decimal 5,2, opcional)
- created_at
- updated_at
```

## Relacionamentos

```php
// Purchase → Animal (obrigatório)
public function animal() {
    return $this->belongsTo(Animal::class);
}

// Purchase → Vendor (opcional)
public function vendor() {
    return $this->belongsTo(Vendor::class);
}
```

## Comandos Executados

```bash
# Criar migration
php artisan make:migration add_vendor_id_to_purchases_table --table=purchases

# Executar migration
php artisan migrate
```

## Resultado

✅ **Erro resolvido**: A coluna `vendor_id` foi adicionada com sucesso
✅ **Sistema funcional**: Compras podem ser criadas normalmente
✅ **Relacionamentos corretos**: Purchase → Vendor funcionando
✅ **Validações implementadas**: Dados seguros e validados
✅ **Interface moderna**: Formulário atualizado e responsivo

---

**Status**: ✅ **RESOLVIDO**  
**Data**: 18/09/2025  
**Migration executada**: 97.61ms de duração  
**Impacto**: Sistema de compras totalmente funcional