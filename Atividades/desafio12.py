# Faça um algoritmo que leia os preços de um produto e mostre o seu novo preço. Com 5% de desconto.

p = float(input('Qual o preço do produto? '))
x = float(input('De quanto será o desconto? '))
d = (p/100) * x
v = p-d
print('O produto que custava R${:.2f}, com {}% de desconto vai custar R${:.2f}'.format(p, x, v))