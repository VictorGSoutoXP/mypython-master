# Escreva um programa que converta uma temperatura digitada em °C e converta em °F.

dados = float(input('informe a temperatura em ºc: '))
F = (1.8 * dados) + 32
K = dados + 273
print('A temperatura de {} ºC corresponde a {:.2f}ºF'.format(dados, F))
print('Dada a tempatura de {} ºC convertendo em kelvin é {}K'.format(dados, K))