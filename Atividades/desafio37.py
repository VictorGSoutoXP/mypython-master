# Criar um commit com o nome de "Condições Aninhadas."
# CONVERSOR DE BASES NÚMERICAS
# Escreva um programa que leia um número inteiro qualquer e peça para o usuário escolher qual será as base de conversão:
# 1 para binário 
# 2 para octal 
# 3 para hexadecimal
# CONVERSOR DE BASES NÚMERICAS
num = int(input('Digite um número intenrio: '))
print('''Escolha uma das bases para conversão:
[1] converter para BINÁRIO
[2] converter para OCTAL
[3] converter para HEXADECIMAL''')
opção = int(input('Sua opção: '))
if opção == 1:
    print('{} convertido para BINÁRIO é igual a {}'.format(num, bin(num)))
elif opção ==2:
    print('{} convertido para OCTAL é igual a {}'.format(num, oct(num)))
elif opção == 3:
    print('{} convertido para HEXADECIMAL é igual a {}'.format(num, hex(num)))
else:
    print('Opção inválida. Tente novamente.')