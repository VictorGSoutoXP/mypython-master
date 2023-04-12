# Faça um programa que tenha uma função chamada contador(), que receba três parâmetros: início, fim e passo. 
# Seu programa tem que realizar três contagens através da função criada:

# a) de 1 até 10, de 1 em 1
# b) de 10 até 0, de 2 em 2
# c) uma contagem personalizada

def contador(inicio, fim, passo):
    if passo == 0:
        print('ERRO: O valor de passo não pode ser zero.')
        return

    if inicio < fim:
        contagem = range(inicio, fim + 1, passo)
    else:
        contagem = range(inicio, fim - 1, -passo)

    for valor in contagem:
        print(f'{valor} ', end='')

    print('FIM!')


# Contagem de 1 a 10, de 1 em 1
print('Contagem de 1 a 10, de 1 em 1:')
contador(1, 10, 1)

# Contagem de 10 a 0, de 2 em 2
print('\nContagem de 10 a 0, de 2 em 2:')
contador(10, 0, 2)

# Contagem personalizada
print('\nContagem personalizada:')
inicio = int(input('Início: '))
fim = int(input('Fim: '))
passo = int(input('Passo: '))
contador(inicio, fim, passo)
