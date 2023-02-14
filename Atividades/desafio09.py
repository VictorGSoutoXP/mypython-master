# Faça um programa que leia um número inteiro qualquer e mostre a sua tabuada.

num=int(input("Digite um numero para ver sua tabuada: "))
cont=0
inicial=0
for tabuada in range(1,11):
  cont=cont+1
  inicial=inicial+1
  print('{} X {}= {}'.format(num,inicial,num*cont))