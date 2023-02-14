# Sequencia de Fibonaci: Escreva um programa que leia um número N inteiro qualquer e mostre na tela os N primeiros elementos de uma Sequência de Fibonacci. 

# Ex: 0 - 1 - 1 - 2 - 3 - 5 - 8

num = int(input('Digite um número de termo para sequência Fibonacci: '))

cont = 1

anterior = 0
proxima = 1
soma = 1

while cont <= num:
     print(anterior, end='-')
     cont += 1
     soma = proxima + anterior
     anterior = proxima
     proxima = soma
print('Fim')