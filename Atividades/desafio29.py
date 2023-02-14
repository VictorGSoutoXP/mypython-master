# Escreva um programa que faça o computador "pensar" em um número inteiro entre 0 e 5 e peça para o usuário tentar descobrir qual foi o número escolhido pelo computador. O programa deverá escrever na tela se o usuário venceu ou perdeu.
# Jogo de adivinhação v.1.0
# Primeira aula condições simples e compostas.

from random import randint
from time import sleep  
computador = randint(0, 5) # "Faz o computador pensar"
print('-=-' * 20)
print ('Vou pensar em um número entre 0 e 5. tente adivinhar...')
print('-=-' * 20)
print('PROCESSANDO...')
sleep(3)
print('-=-' * 20)
jogador = int(input('Em que número eu pensei?  ')) # Jogador tenta adivinhar 
if jogador == computador: 
    print('Parabéns você ganhou!!!')
else:
    print('Você perdeu!!! Pois eu pensei no número {} e não no {}!'.format(computador, jogador))
print('-=-' * 20)

