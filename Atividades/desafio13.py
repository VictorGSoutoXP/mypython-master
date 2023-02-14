# Faça um algoritmo que leia o salário de um funcionário e mostre seu novo salário, com 15% de desconto.

s=float(input('Qual é o salario do funcionário?'))
a=float(input('Quanto vai ser o aumento em porcentagem?'))
ap=s*(a/100)
print('Sálario com desconto ', ap)