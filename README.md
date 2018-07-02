# Consulta de Índices Financeiros

## Definição

Um simples componente que consulta os índices financeiros do site [Debit](http://www.debit.com.br). Este componente consulta os Índicies:

- IGP-DI (FGV);
- IGP-M (FGV);
- IPC (FIPE);
- IPCA (IBGE);
- INPC (IBGE);
- ICV (DIEESE);

## Instalação

A maneira recomendada para instalar esta extensão é através [composer](http://getcomposer.org/download/).

Execute no seu terminal

```
$ php composer.phar require dersonsena/indices-financeiros "dev-master"
```

ou adicione

```
"dersonsena/indices-financeiros": "dev-master"
```

na seção ```require``` do seu arquivo `composer.json`.

## Exemplos de Uso

### Obter todos as Cotações do Mês atual

O Exemplo abaixo irá retornar todos os índices financeiros do mês corrente:

```php
$debit = DebitService::newDebitService();
$cotacoesDebit->getIndicesByCurrentMonth();
```

### Obter as cotações por um determinando Índice Financeiro

```php
$debit = DebitService::newDebitService();

// IGP-M (FGV)
$cotacoesDebit->getCotacoesByIndiceCode(IGPMFGV::getCodigo());

// IPC (FIPE)
$cotacoesDebit->getCotacoesByIndiceCode(IPCFIPE::getCodigo());
```

### Obter a cotação atual de um determinado Índice Financeiro

```php
$debit = DebitService::newDebitService();

// IGP-M (FGV)
$cotacoesDebit->getCurrentCotacaoByIndiceCode(IGPMFGV::getCodigo());

// IPC (FIPE)
$cotacoesDebit->getCurrentCotacaoByIndiceCode(IGPMFGV::getCodigo());
```

## AGRADECIMENTOS

- Agradeço fortemente ao **Pedro Arthur Duarte (@pedroarthur)** pela ajuda na refatoração e adicionar boas práticas na estrutura do componente.