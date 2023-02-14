# Crie um programa que mostre na tela todos os números pares que estão no intervalo entre 1 e 50.
fim = int(input('Qual o último número? '))
for i in range(2, fim+1, 2):
    print(i, end = ', ')
print(' fim')