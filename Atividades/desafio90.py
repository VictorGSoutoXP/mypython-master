# Faça um programa que leia nome e média de um aluno, guardando também a situação em um dicionário."
# No final, mostre o conteúdo da estrutura na tela."

# pedindo ao usuário que informe o nome e a média do aluno

nome = input("Digite o nome do aluno: ")
media = float(input("Digite a média do aluno: "))

# definindo a situação do aluno com base na média
if media >= 7:
    situacao = "aprovado"
elif media >= 5:
    situacao = "recuperação"
else:
    situacao = "reprovado"

# criando o dicionário com os dados do aluno
aluno = {'nome': nome, 'media': media, 'situacao': situacao}

# exibindo o conteúdo do dicionário na tela
print("Dados do aluno:")
print(f"Nome: {aluno['nome']}")
print(f"Média: {aluno['media']:.1f}")
print(f"Situação: {aluno['situacao']}")
