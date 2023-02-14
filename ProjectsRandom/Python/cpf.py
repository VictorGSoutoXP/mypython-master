# Criar um script
# Salvando  variaveis contendo: Nome, CPF e idade.
# Depois extrair os dados completos de uma pessoa.
# Cria um dicionario onde a chave será o nome da pessoa, e os valores serão o nome cpf e idade.
#Pesquisar
'''
Para criar um dicionário em Python, basicamente, as informações precisam ser passadas entre chaves {}, que por sua vez precisam seguir a estrutura de pares “chave: valor” - denotada na literatura pelos termos em inglês key:value. 

Os elementos de um dicionário são armazenados de forma não ordenada.

Isso ocorre de forma que seus elementos sejam exclusivos. Porém, os elementos de um mesmo valor podem ser duplicados, uma vez que a chave é diferente. 

A estrutura se assemelha à tabela de um banco de dados quando se tem uma chave primária composta.
'''
# Como aplicar?
# Dinheiro é segurança
# Melhorar explicação.
# Colocar dentro de uma função (Chamada de dados_do_aluno).
# Criar um dicionario com os dados finais, onde a chave é o nome da pessoa e o conteúdo é o retorno do dicionário dados que foi criado. 
# Permitir que o usário coloque dados de mais alunos neste dicionário final.
'''
{ "fulano_1" : {"nome" : "fulano_1", "cpf": "1234567", "idade": 23}, "fulano_2" : {"nome" : "fulano_2", "cpf": "7654321", "idade":  24},}

'''
# teste05
from platform import processor


def add_people():
  dicionario_interno = dict()
  dicionario_interno ['nome'] =str (input('Nome: '))
  dicionario_interno ['CPF'] =str (input('CPF: '))
  dicionario_interno ['Idade'] =str (input('Idade: '))
  return dicionario_interno

quantas_pessoas = int(input(" Quantidade de pessoas?"))
pessoas = []

for num in range(quantas_pessoas):
    individuo = quantas_pessoas()
    pessoas.append(individuo)

print(pessoas)







"""

#teste04
myDict = {} 
myDict["Nome"] = [1, 2] 
myDict["Nome"] = ["CPF", "Idade"]  
nome = input('Qual é seu nome completo? ')
cpf = input ('Qual é o seu CPF? ' )
idade = input ('Qual é a sua idade? ' )
print ( 'Seu nome completo é:', nome, 'O seu CPF é:', cpf, 'Sua idade é:', idade )
  
print(myDict)



#teste03
dados= dict()

nome = {"Nome": 1, "CPF": 2, "Idade": 3}

valor = nome["Nome"]
valor = nome.get("CPF")
dict[ nome ] = cpf




#teste02
if dados == "Dados pessoais":
    nome = input("Nome: ").strip()
    cpf = input(":Qual é o seu CPF? ").strip()
    idade = input("Qual é a sua idade? ").strip()
    ano = input("Qual é o seu ano de nascimento? ").strip()
    dados [nome] = {
      "nome": nome,
      "CPF": cpf,
      "idade": idade,
      "ano": ano
    }

print ( 'Seu nome completo é:', nome, 'O seu CPF é:', cpf, 'Sua idade é:', idade, 'e você nasceu no ano dê:', ano)




#teste01
nome = input('Qual é seu nome completo? ')
cpf = input ('Qual é o seu CPF? ' )
idade = input ('Qual é a sua idade? ' )
#teste01
ano = input ('Qual é o seu ano de nascimento? ' )


print ( 'Seu nome completo é:', nome, 'O seu CPF é:', cpf, 'Sua idade é:', idade, 'e você é nasceu ano dê:', ano)
print('Extração dos dados completos:',nome,'/',cpf,'/',idade,'/',ano)

"""