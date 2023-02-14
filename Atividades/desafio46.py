# Crie um programa que faça o computador jogar Jokenpô com você.
from random import randint
itens = ('Pedra ', 'Papel ', 'Tesoura ')
computador = randint(0, 2)
print('''Suas opções:'
      [ 0 ] PEDRA
      [ 1 ] PAPEL
      [ 2 ] TESOURA''')
jogador = int(input('Qual a sua jogada? '))
if jogador != 0 and jogador != 1 and jogador !=2:
    print('JOGADA INVALIDA \nJogue novamente')

else:
    print('O computador jogou {}'.format(itens[computador]))
    print('O jogador jogou {}'.format(itens[jogador]))
if computador == 0:
    if jogador == 0:
        print('EMPATE')
    elif jogador == 1:
        print('JOGADOR VENCE')
    elif jogador == 2:
        print('COMPUTADOR VENCE')
    #else:
     #print('JOGADA INVALIDA')

elif computador == 1:
    if jogador == 0:
        print('COMPUTADOR VENCE')
    elif jogador == 1:
        print('EMPATE')
    elif jogador == 2:
        print('JOGADOR VENCE')
    #else:
     # print('JOGADA INVALIDA')


elif computador == 2:
    if jogador == 0:
        print('JOGADOR VENCE')
    elif jogador == 1:
        print('COMPUTADOR VENCE')
    elif jogador == 2:
        print('EMPATE')
    #else:
     #  print('JOGADA INVALIDA')