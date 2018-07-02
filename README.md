# Consulta de Índices Financeiros

### Definição

Um simples componente que consulta os índices financeiros do site [Debit](http://www.debit.com.br). Este componente consulta os Índicies:

- IGP-DI (FGV);
- IGP-M (FGV);
- IPC (FIPE);
- IPCA (IBGE);
- INPC (IBGE);
- ICV (DIEESE);

### Instalação

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

### Exemplos de Uso

```php
$cotacoesDebit = new DebitService;
$cotacoesDebit->getIndicesByCurrentMonth(); // Pega as cotações do mês atual de cada índice
$cotacoesDebit->getCotacoesByIndiceCode(IGPMFGV::getCodigo()); // Pega as cotações por um determindo índice
$cotacoesDebit->getCurrentCotacaoByIndiceCode(IPCFIPE::getCodigo()); // Pega a cotação do mês atual de um determinado índice
```