# Crie um algoritmo que leia um número e mostre o seu dobro, triplo e raiz quadrada.

# Este exemplo funciona em Python 2.7
'''
n = (input  ('Digite um valor  '))
d = n * 2
t = n * 3
r = n ** (1/2)
print ( ' O dobro de {} vale {} '.format(n , d))
print (' O triplo de {} vale {}. A raiz quadrada de {} é igual a {} '.format(n , t , n, r)) '''
# Para python 3.9.12

n = int(input('Digite um número: '))
print(f'O dobro de {n} é {n*2}.\nO triplo é {n*3}\nA raiz quadrada é {n**(1/2):.2f}.')