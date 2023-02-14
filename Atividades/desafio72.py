# Simulador de caixa eletronico: Crie um programa que simule o funcionamento de um caixa eletrônico. No início, pergunte ao usuário qual será o valor a ser sacado (número inteiro) e o programa vai informar quantas cédulas de cada valor serão entregues.

print('-'*30)
print('{:^30}' .format(' BANCO VGS '))
print('-'*30)
d = int(input('Qual valor você quer sacar? R$'))
cont_cinquenta = cont_vinte = cont_dez = cont_um = 0
while True:
    while d - 50 >= 0:
        d -= 50
        cont_cinquenta += 1
    while d - 20 >= 0:
        d -= 20
        cont_vinte += 1
    while d - 10 >= 0:
        d -= 10
        cont_dez += 1
    while d - 1 >= 0:
        d -= 1
        cont_um += 1
    break
if cont_cinquenta != 0:
    print(f'Total de {cont_cinquenta} cedulas de R$50')
if cont_vinte != 0:
    print(f'Total de {cont_vinte} cedulas de R$20')
if cont_dez != 0:
    print(f'Total de {cont_dez} cedulas de R$10')
if cont_um != 0:
    print(f'Total de {cont_um} cedulas de R$1')