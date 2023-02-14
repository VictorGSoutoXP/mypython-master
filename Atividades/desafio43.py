# Exercício Python 043: Acrescentando o recurso de mostrar que tipo de triângulo será formado:
# - EQUILÁTERO: todos os lados iguais
# - ISÓSCELES: dois lados iguais, um diferente
# - ESCALENO: todos os lados diferentes

a = float(input('digite o primeiro valor: '))
b = float(input('digite o segundo: '))
c = float(input('digite o último: '))
if a<b+c and b<a+c and c<a+b:
    print('será possivel sim, fazer um triângulo')
    if a==b==c:
         print('equilatero')
    elif a != b != c != a:
        print('escaleno')
    else:
         print('isosceles')
else:
    print('Desta maneira não formará um triângulo.')