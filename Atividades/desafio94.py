#Crie um programa que leia nome, sexo e idade de várias pessoas, guardando os dados de cada pessoa em um dicionário e todos os dicionários em uma lista. No final, mostre: 
# A) Quantas pessoas foram cadastradas
# B) A média de idade
# C) Uma lista com as mulheres
# D) Uma lista de pessoas com idade acima da média
pessoas = []
soma_idades = 0

while True:
    pessoa = {}
    pessoa['nome'] = input('Nome: ')
    pessoa['sexo'] = input('Sexo (M/F): ').upper()
    pessoa['idade'] = int(input('Idade: '))
    pessoas.append(pessoa)
    soma_idades += pessoa['idade']
    
    continuar = input('Quer continuar? (S/N) ').upper()
    if continuar == 'N':
        break

qtd_pessoas = len(pessoas)
media_idades = soma_idades / qtd_pessoas
mulheres = [pessoa['nome'] for pessoa in pessoas if pessoa['sexo'] == 'F']
acima_media = [pessoa['nome'] for pessoa in pessoas if pessoa['idade'] > media_idades]

print('-=' * 30)
print(f'A) Total de pessoas cadastradas: {qtd_pessoas}')
print(f'B) Média de idade: {media_idades:.2f} anos')
print(f'C) Lista de mulheres: {mulheres}')
print(f'D) Lista de pessoas com idade acima da média: {acima_media}')

#Explicando o código:

# Criamos uma lista vazia chamada pessoas, que será utilizada para armazenar os dicionários com os dados de cada pessoa.
# Criamos uma variável soma_idades inicialmente igual a zero, que será utilizada para calcular a soma das idades das pessoas.
# Utilizamos um loop while para solicitar os dados de cada pessoa. Dentro do loop:
# Criamos um dicionário vazio chamado pessoa.
# Solicitamos ao usuário que digite o nome, o sexo e a idade da pessoa, e armazenamos essas informações no dicionário pessoa.
# Adicionamos o dicionário pessoa à lista pessoas.
# Atualizamos a variável soma_idades com a idade da pessoa.
# Perguntamos ao usuário se ele quer continuar adicionando pessoas. Se a resposta for não, saímos do loop com o comando break.
# Calculamos o total de pessoas cadastradas (qtd_pessoas) e a média de idade (media_idades).
# Utilizamos uma list comprehension para criar uma lista chamada mulheres contendo o nome das pessoas do sexo feminino.
# Utilizamos outra list comprehension para criar uma lista chamada acima_media contendo o nome das pessoas com idade acima da média.
# Imprimimos as informações solicitadas utilizando o comando print.
