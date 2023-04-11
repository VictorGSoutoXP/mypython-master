#Faça um programa que ajude um jogador da MEGA SENA a criar palpites.
# O programa vai perguntar quantos jogos serão gerados e vai sortear 6 números entre 1 e 60 para cada jogo, cadastrando tudo em uma lista composta.

import random

# pedindo ao usuário quantos jogos devem ser gerados
quantidade_jogos = int(input("Quantos jogos você quer gerar? "))

# gerando os jogos
jogos = []
for i in range(quantidade_jogos):
    numeros = []
    while len(numeros) < 6:
        numero = random.randint(1, 60)
        if numero not in numeros:
            numeros.append(numero)
    jogos.append(sorted(numeros))

# exibindo os jogos gerados
for jogo in jogos:
    print(jogo)
