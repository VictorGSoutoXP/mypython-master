# Faça um programa que leia um número qualquer e mostre o seu fatorial.

# Ex: 5! = 5 x 4 x 3 x 2 x 1 = 120

n = int(input('Digite um numero para calcular seu fatorial: '))

c = 0
f = 1
for c in range (1, n):
    f *= n
    n -= 1
print('Seu fatorial é {}.'.format(f))