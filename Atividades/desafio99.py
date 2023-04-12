# Faça um programa que tenha uma função chamada maior(), que receba vários parâmetros com valores inteiros. 
# Seu programa tem que analisar todos os valores e dizer qual deles é o maior.

def maior(*numeros):
    maior = None
    for num in numeros:
        if maior is None or num > maior:
            maior = num
    return maior

# Exemplo de uso da função
print(maior(2, 5, 1, 8, 4)) # imprime 8
