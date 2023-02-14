# Jogo do par ou ímpar Faça um programa que jogue par ou ímpar com o computador. O jogo só será interrompido quando o jogador perder, mostrando o total de vitórias consecutivas que ele conquistou no final do jogo. 

from time import sleep
from random import randint
cont = 0
soma = 0
escolha = ""
print('¨=¨' * 15)
print('vamos jogar par ou impar')
print('¨=¨' * 15)
sleep(0.1)
while True:
    computador = randint(0, 10)
    jogador = int(input('digite um numero: '))
    escolha = str(input('Par Ou Impar ? ')).strip().upper()[0]
    soma = jogador + computador
    if escolha in 'Pp':
        if soma % 2 == 0:
            sleep(1)
            print('você venceu, Parabéns!')
            cont += 1
        else:
            sleep(1)
            print('você perdeu, continue tentando!')
            print('-' * 20)
            print(f'seu números de vitorias é : {cont}')
            print('-' * 20)
            break
    elif escolha in 'Ii':
        if soma % 2 == 1:
            sleep(1)
            print('você venceu, Parabéns: ')
        else:
            sleep(1)
            print('você perdeu, tente novamente!')
            print('-=' * 20)
            print(f'seu número de vitorias é : {cont} ')
            print('-=' * 20)
            break