## CRUD - API-PHP - MySQL

CRUD - basico usando a lib javascript Vue.js, e chamando uma API em PHP, e salvando no banco de dados MySQL.

Para realizar o CRUD pelo postman, devesse usar os seguintes methods abaixo.

## GET - READ
http://localhost/api-2sow/api.php?action=read

Lista todos os usuarios cadastrados em ordem alfabetica crescente.


## POST - CREATE
http://localhost/api-2sow/api.php?action=create

Salva as informações, escolha a opção Body > x-www-form-urlencoded passando uma estrutura de informações conforme mostrado no exemplo abaixo.

name: Teste
surname: 2SOW
cpf: 123.456.789-02
phone: (47) 3214.5679
email: teste@2sow.com.br
cellphone: (47) 9 8865.9725
zipcode: 88338-233
logradouro: Rua Libéria
neighborhood: Nações
city: Balneário Camboriú
state: SC


## POST - UPDATE
http://localhost/api-2sow/api.php?action=update

Edita as informações selecionadas, escolha a opção Body > x-www-form-urlencoded passando uma estrutura de informações conforme mostrado no exemplo abaixo.

id: 1
name: Teste
surname: 2SOW
cpf: 123.456.789-01
id_citizen: 1
phone: (47) 3985-2145
email: teste@2sow.com.br
cellphone: (47) 9 8795-2587
zipcode: 88220-001
logradouro: Rua 418
neighborhood: Morretes
city: Itapema
state: SC


## POST - DELETE
http://localhost/api-2sow/api.php?action=delete

Deleta as informações selecionadas, escolha a opção Body > x-www-form-urlencoded passando uma estrutura de informações conforme mostrado no exemplo abaixo.

id:1


## Autor
<table>
  <tr>
    <td>
      <img src="https://avatars2.githubusercontent.com/u/8739638?s=460&v=4" width="100">
    </td>
    <td>
      :octocat: Rodrigo Pereira<br />
      <a href="mailto:rodrigopluz@gmail.com">:point_right: rodrigopluz@gmail.com</a><br />
    </td>
  </tr>
</table>
