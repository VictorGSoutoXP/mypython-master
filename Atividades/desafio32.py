# Escreva um programa que pergunte a distância de uma viagem em Km. Calcule o preço da passagem, cobrando R$ 0,50 por Km para viagens até de 200Km e R$ 0,45 para viagens mais longas.
# Custo de viagem ônibus 
distância = float(input('Qual é distância da sua viagem? '))
print('Você está preste a começar uma viagem {} em Km.')
if distância <=200:
    preço = distância * 0.50
else:
    preço = distância * 0.45
print('e o preço da sua passagem será de R$ {:.2f}'.format(preço))