# Faça um programa que tenha uma lista chamada números e duas funções chamadas sorteia() e somaPar().
# A primeira função vai sortear 5 números e vai colocá-los dentro da lista e a segunda função vai mostrar a soma entre todos os valores pares sorteados pela função anterior. 
import random

def sorteia():
    numeros = []
    for i in range(5):
        numeros.append(random.randint(1, 10))
    print(f'Os números sorteados foram: {numeros}')
    return numeros

def somaPar(lista):
    soma = 0
    for num in lista:
        if num % 2 == 0:
            soma += num
    print(f'A soma dos números pares é: {soma}')
    return soma

# Exemplo de uso das funções
numeros = sorteia()
somaPar(numeros)
