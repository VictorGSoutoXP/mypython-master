# Faça um programa que leia três números e mostre qual é a maior e qual é a menor.
a = int(input('Primeiro valor: '))
b = int(input('Segundo valor: '))
c = int(input('Terceiro valor: '))
# Verifica quem é menor.
menor = a
if b<a and b<c:
    menor = b
if c<a and c<b:
    menor = c
# Verifica quem é maior 
maior = a
if b>a and b>c:
    maior = b
if c>a and c>b:
    maior = c
print('O menor valor digitado foi {}'.format(menor))
print('O maior valor digitado foi {}'.format(maior))