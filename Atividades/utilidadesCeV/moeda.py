def aumentar(valor, taxa):
    novo_valor = valor + (valor * taxa / 100)
    return novo_valor

def diminuir(valor, taxa):
    novo_valor = valor - (valor * taxa / 100)
    return novo_valor

def dobro(valor):
    novo_valor = valor * 2
    return novo_valor

def metade(valor):
    novo_valor = valor / 2
    return novo_valor

import moeda

def resumo(valor=0, taxa_a=0, taxa_r=0):
    print('-' * 30)
    print(f'RESUMO DO VALOR'.center(30))
    print('-' * 30)
    print(f'Preço analisado: \t{moeda.moeda(valor)}')
    print(f'Dobro do preço: \t{moeda.dobro(valor, True)}')
    print(f'Metade do preço: \t{moeda.metade(valor, True)}')
    print(f'{taxa_a}% de aumento: \t{moeda.aumentar(valor, taxa_a, True)}')
    print(f'{taxa_r}% de redução: \t{moeda.diminuir(valor, taxa_r, True)}')
    print('-' * 30)

