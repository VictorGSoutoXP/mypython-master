# Crie um programa que leia o nome completo de uma pessoa e mostre:
# O nome com todas as letras maiscúlas e minúsculas.
# Quantas letras ao todo (Sem considerar espaços.)
# Quantas letras tem o primeiro nome.
'''
nome = str(input   ('Digite seu nome completo: ')).strip()
print('Analisando seu nome...')
print('Seu nome em maiscúlas é {}'.format(nome.upper()))
print('Seu nome em maiscúlas é {}'.format(nome.lower()))
print('Seu nome tem ao todo {} letras'.format(len(nome)-nome.count(' ')))
print('O seu primeiro nome é {} e possui {} letras'.format(lista[0], len(lista[0])))'''

x = str(input("Digite seu nome completo: ")).strip()
print(f"Seu nome em maiúsculas é {x.upper()}."
      f"\nSeu nome em minúsculas é {x.lower()}."
      f"\nSeu nome tem ao todo {len(x)-x.count(' ')} letras."
      f"\nO seu primeiro nome é {x.split()[0]} e possui {len(x.split()[0])} letras.")
