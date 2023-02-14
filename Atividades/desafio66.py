# Maior e menor valores: Crie um programa que leia vários números inteiros pelo teclado. No final da execução, mostre a média entre todos os valores e qual foi o maior e o menor valores lidos. O programa deve perguntar ao usuário se ele quer ou não continuar a digitar valores.

lista = []
soma = media = quantidade = 0
pergunta = 'S'
while pergunta in 'Ss':
    n = int(input('Digite um número: '))
    pergunta = str(input('Quer continuar? [S/N] ')).upper().strip()
    soma += n
    quantidade += 1
    lista += [n]
media = soma / quantidade
print(f'Você digitou {quantidade} números e a média foi {media}')
print(f'O maior valor digitado foi ', max(lista))
print(f'E o menor valor digitado  foi ', min(lista))