# netflix_clientes_api

Uma API RESTful para gerenciar clientes e assinaturas em uma plataforma semelhante à Netflix.

## Índice

- [Descrição](#descrição)
- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação](#instalação)
- [Como Usar](#como-usar)
- [Contribuição](#contribuição)
- [Licença](#licença)
- [Contato](#contato)

## Descrição

Este projeto é uma API desenvolvida para gerenciar clientes, assinaturas e conteúdo em uma plataforma de streaming semelhante à Netflix. Ela permite operações como cadastro de usuários, gerenciamento de planos de assinatura, autenticação e recomendação de filmes.

## Funcionalidades

- Cadastro e autenticação de usuários
- Gerenciamento de planos de assinatura
- Recomendações de filmes
- Pesquisa de conteúdo
- Gerenciamento de listas de reprodução

## Tecnologias Utilizadas

- [Laravel](https://laravel.com/) - Framework PHP
- [MySQL](https://www.mysql.com/) - Banco de dados relacional
- [JWT](https://jwt.io/) - Autenticação baseada em token

## Instalação

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/arseniomuanda/netflix_clientes_api.git
   cd netflix_clientes_api
   ```

2. **Instale as dependências:**

   ```bash
   composer install
   npm install
   ```

3. **Configure o arquivo `.env`:**

   - Duplique o arquivo `.env.example` e renomeie para `.env`.
   - Configure as variáveis de ambiente, como informações do banco de dados.

4. **Gere a chave da aplicação:**

   ```bash
   php artisan key:generate
   ```

5. **Execute as migrações e seeders:**

   ```bash
   php artisan migrate --seed
   ```

6. **Inicie o servidor de desenvolvimento:**

   ```bash
   php artisan serve
   ```

   A aplicação estará disponível em `http://localhost:8000`.

## Como Usar

- **Documentação da API:**

  Acesse `http://localhost:8000/api/documentation` para visualizar os endpoints disponíveis e testar as funcionalidades.

- **Autenticação:**

  - Registre um novo usuário através do endpoint `/api/register`.
  - Faça login com o endpoint `/api/login` para obter um token JWT.
  - Inclua o token JWT no cabeçalho das requisições para acessar endpoints protegidos.

## Contribuição

Contribuições são bem-vindas! Siga os passos abaixo para contribuir:

1. Faça um fork deste repositório.
2. Crie uma branch para sua feature ou correção: `git checkout -b minha-feature`.
3. Commit suas alterações: `git commit -m 'Minha nova feature'`.
4. Envie para o repositório remoto: `git push origin minha-feature`.
5. Abra um Pull Request detalhando suas alterações.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

## Contato

Arsênio Muanda - [LinkedIn](https://www.linkedin.com/in/arseniomuanda/)

Sinta-se à vontade para clonar e explorar este projeto. Contribuições são encorajadas para aprimorar ainda mais a aplicação.

