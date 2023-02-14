# Maior e menores valores em Tuplas: Crie um programa que vai gerar cinco números aleatórios e colocar em uma tupla. Depois disso, mostre a listagem de números gerados e também indique o menor e o maior valor que estão na tupla.

from random import randint
lista = (randint(0,100), randint(0,100), randint(0,100), randint(0,100), randint(0,100))
organizado = (sorted(lista))
print(f'→ Os números gerados foram: {lista}.')
print(f'→ O menor número foi {organizado[0]}.')
print(f'→ O menor número foi {organizado[4]}.')