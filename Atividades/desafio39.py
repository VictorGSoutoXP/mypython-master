# APROVANDO EMPRÉSTIMO
# Escreva um programa para aprovar o empréstimo bancário para a compra de uma casa. Pergunte o valor de casa, o salário do comprador e em quantos anos ele vai apagar.
# A prestação mensal, não pode exceder 30% do salário ou então  empréstimo será negado.

casa = float(input('Valor da casa: R$'))
salário = float(input('Salário do comprador: R$'))
anos = int(input('Quantos anos de financiamento? '))
prestação = casa / (anos * 12 )
mínimo = salário * 30 / 100
print('Para pagar uma casa de R${:.2f} em {} anos'.format(casa, anos), end='')
print('A prestação será de R${:.2f}'.format(prestação))
if prestação <= mínimo:
    print(' Emprétismo pode ser CONCEDIDO!')
else:
    print('Emprétimo NEGADO!')