# Faça um programa que calcule a soma entre todos os números que são múltiplos de três e que se encontram no intervalo de 1 até 500.

soma = 0
for i in range(1,500):
    if i % 3 == 0:
        if i % 2 == 1:
            soma += i
            print(i, end=' ')
print(f'\nA soma entre eles é {soma}', end='')