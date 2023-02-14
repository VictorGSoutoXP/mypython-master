# A professora quer sortear um dos seus quatros alunos para apagar o quadro. Faça um programa que ajude ela, lendo o nome deles e escrevendo o nome escolhido.
import random
a1 = input('Primeiro aluno: ')
a2 = input('Segundo aluno: ')
a3 = input('Terceiro aluno: ')
a4 = input('Quarto aluno: ')
print('O aluno escolhido foi {}'.format(random.choice([a1, a2, a3, a4])))