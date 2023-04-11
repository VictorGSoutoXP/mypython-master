# Crie um programa que leia nome e duas notas de vários alunos e guarde tudo em uma lista composta.
# O final, mostre um boletim contendo a média de cada um e permita que o usuário possa mostrar as notas de cada aluno individualmente.
# pedindo ao usuário quantos alunos devem ser cadastrados.

quantidade_alunos = int(input("Quantos alunos você quer cadastrar? "))

# criando a lista de alunos
alunos = []
for i in range(quantidade_alunos):
    nome = input(f"Digite o nome do aluno {i+1}: ")
    nota1 = float(input(f"Digite a primeira nota do aluno {i+1}: "))
    nota2 = float(input(f"Digite a segunda nota do aluno {i+1}: "))
    alunos.append({'nome': nome, 'notas': [nota1, nota2]})

# exibindo o boletim com as médias de cada aluno
print("Boletim:")
for i, aluno in enumerate(alunos):
    media = sum(aluno['notas']) / len(aluno['notas'])
    print(f"{i+1}. {aluno['nome']}: média = {media:.2f}")

# permitindo que o usuário visualize as notas de cada aluno
while True:
    indice = int(input("Digite o índice do aluno que você quer visualizar as notas (ou 0 para sair): "))
    if indice == 0:
        break
    elif indice < 1 or indice > len(alunos):
        print("Índice inválido!")
    else:
        aluno = alunos[indice-1]
        print(f"Notas do aluno {aluno['nome']}: {aluno['notas']}")
