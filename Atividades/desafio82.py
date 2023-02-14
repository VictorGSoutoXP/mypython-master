# Extraindo dados de uma lista: Crie um programa que vai ler vários números e colocar em uma lista. Depois disso, mostre: A) Quantos números foram digitados.
valores = []
while True:
    while True:
        num = (input('Digite um valor: '))
        if num.isdigit() == True: # isdigit(é dígito) ou isnumeric(é numérico)
            num = int(num)
            valores.append(num)
            break
        else:
            num = str(num)
            print('Opção invalida ', end='')
    resp = 'S'
    resp = str(input(('Digite [S/N]: ')))    
    while resp not in 'SsNn':
        resp = str(input(('Digite [S/N]: ')))
    if resp in 'Nn':
        break
print('-=' * 25)
print(f'Você digitou {len(valores)} valores.')
valores.sort(reverse=True)
print(f'Os valores em ordem decrecente são {valores}')
if 5 in valores:
    print('O valor 5 faz parte da lista')
else:
    print('Valor 5 não encontrado na lista')