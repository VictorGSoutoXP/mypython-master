# Lista composta e análise de dados: Faça um programa que leia nome e peso de várias pessoas, guardando tudo em uma lista. No final, mostre: A) Quantas pessoas foram cadastradas.

lista1 = list()
lista2 = list()
maior = 0
menor = 9999999999999999999999

while True:
    nome = str(input('Nome: ')).strip().capitalize()
    peso = float(input('Peso[kg]: '))
    resp = str(input('Quer continuar? [S/N]: ')).strip().upper()
    resp2 = ''

    lista1.append(nome)
    lista1.append(peso)
    lista2.append(lista1[:])
    lista1.clear()

    for elemento in lista2:
        if elemento[1] >= maior:
            maior = elemento[1]

        if elemento[1] <= menor:
            menor = elemento[1]
    
    if (resp != 'S') and (resp != 'N'):
        while (resp2 != 'S') and (resp2 != 'N'):
            resp2 = str(input('Quer continuar? [S/N]: ')).strip().upper()
    
    if (resp == 'N') or (resp2 == 'N'):
        break

print('-='*25)
print(f'Ao todo, você cadastrou {len(lista2)} pessoas.')

print(f'O maior peso foi de {maior:.2f} kg. Peso de ', end='')
for elemento1 in lista2:
    if elemento1[1] == maior:
        print(f'[{elemento1[0]}]', end='')

print(f'\nO menor peso foi de {menor:.2f} kg. Peso de ', end='')
for elemento2 in lista2:
    if elemento2[1] == menor:
        print(f'[{elemento2[0]}]', end='')