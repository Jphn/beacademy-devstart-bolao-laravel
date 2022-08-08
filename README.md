
# Projeto Individual - Bolão

O projeto Bolão é um simples sistema de gerenciamento de sorteios. Neste projeto foi utilizada uma integração com a [API Loterias Caixa](https://github.com/guto-alves/loterias-api).

## Stack utilizada

**Front-end:** Bootstrap, CSS, FontAwesome.

**Back-end:** PHP, Laravel, MySQL.

## Funcionalidades

- Listagem de participantes
- Seleção de dezenas
- Painel de controle do administrador
- Sincronização dos participantes com os últimos resultados do sorteio
- Dentre outras...

## Projeto

- [Todo List](https://flask.io/gl8xZlv2GEIW)

## Rodando localmente

```sh
# Clone o projeto
git clone <url>
```

```sh
# Acesse a pasta
cd <folder>
```

```sh
# Instale as dependências
composer install
```

```sh
# Copie e configure o arquivo de ambiente
copy .env.example .env
```

```sh
# Gere uma chave para a aplicação
php artisan key:generate
```

```sh
# Faça as migrações
php artisan migrate
```

```sh
# E por fim, rode!
php artisan serve
```

## Rodando os testes

Para rodar os testes, rode o seguinte comando

```sh
# Comando integrado do artisan.
php artisan test
# OU
# PHPUnit.
.\vendor\bin\phpunit --testdox
```

## Autor

- [João Pedro Holanda Neves](https://www.github.com/Jphn)
