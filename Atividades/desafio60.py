# Crie um programa que leia dois valores e mostre um menu como o ao lado na tela:
# Seu programa deverá   realizar a operação solicitada em cada caso.
# [1] Soma [2] Multiplicar [3] Maior [4] Novos números [5] Sair do programa
from time import sleep
valor1 = int(input('Digite um valor:'))
valor2 = int(input('Digite outro valor:'))
fim = False
while not fim:
    print('''    [ 1 ] Somar
    [ 2 ] Multiplicar
    [ 3 ] Maior
    [ 4 ] Novos números
    [ 5 ] Sair do programa''')
    opção = int(input('>>>>opção:'))
    if opção == 1:
        fim = False
        soma = valor1 + valor2
        print('A soma dos dois valores é:{}'.format(soma))
    elif opção == 2:
        fim = False
        multiplicar = valor1 * valor2
        print('A multiplicação dos dois valores é igual a:{}'.format(multiplicar))
    elif opção == 3:
        fim = False
        if valor1 > valor2:
            print('{} é o maior valor'.format(valor1))
        elif valor2 > valor1:
            print('{} é o maior valor'.format(valor2))
        elif valor1 == valor2:
            print('Não tem valor maior,ambos possuem o mesmo valor.')
    elif opção == 4:
        fim = False
        valor1 = int(input('Digite um novo valor:'))
        valor2 = int(input('Digite um novo valor:'))
    elif opção == 5:
        fim = True
        print('Finalizando o programa...')
        sleep(2)
        print('Obrigado por usar este programa! Volte sempre!.')
    elif opção != (0,5):
        print('Opção inválida.Tente novamente!')
    print('-=-' * 15)