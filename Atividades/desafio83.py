# Dividindo valores em várias listas: Crie um programa que vai ler vários números e colocar em uma lista. Depois disso, crie duas listas extras que vão conter apenas os valores pares e os valores ímpares digitados, respectivamente. Ao final, mostre o conteúdo das três listas geradas.

lista = []
par = []
impar = []
continuar = ' '
while continuar != 'N' and continuar != 'n':
    lista.append(int(input('Digite um numero: ')))
    while continuar != 'N' and continuar != 'n':
        continuar = str(input('Deseja continuar? [S/N] ')).upper()
        if continuar == 'S':
               break
for c in lista:
    if c % 2 == 0:
        par.append(c)
    else:
        impar.append(c)
print(f'A lista completa é {lista}')
print(f'Os valores pares da lista são: {par}')
print(f'Os valores ímpares da lista são: {impar}')