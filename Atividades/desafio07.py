# Desenvolva um programa que leia as duas notas de um aluno, calcule e mostre sua média.
# Versão mais antiga do python:
# As váriveis podemos utilizar acentuação sem problema nenhum!!!
""" 
n1 = float(input('Nota 1: '))
n2 = float(input('Nota 2: ')) 
m = (n1 + n2) / 2 
print ( A média enter {:.1f} e {:.1f} é igual a {:.1f}'.format (n1, n2, m1))    """

# à partir da versão mais recente do Pycharm podemos substituir o  .format pela letra f no início da função print antes da primeira aspas.
n1 = float(input('Nota 1: '))
n2 = float(input('Nota 2: '))
print(f'Resultado: \n - Nota final: {n1+n2} \n - Média: {(n1+n2)/2:.1f}')