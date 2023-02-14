# Escreva um programa que pergunte a quantidade de KM percorridos por um carro alugado e a quantidade de dias pelos quais ele foi alugado. Calcule o preço a pagar. sabendo que o carro custa R$ 60 por dia R$ 0.15 por Km rodado.
print ('Nome do locador:')
nome = input ('')
print('Qual foi o dia que o carro foi alugado?')
dia = input('')
print ('Qual foi o mês que o carro foi alugado?')
mes = input ('')

print('Quantos dias o carro foi alugado?')
dias = int(input(''))
print ('')

print('Quantos KM ele foi rodado?')
km = float(input(''))
pago = (dias * 60) + (km * 0.15)
print ('')

print ('O total a pagar é de {:.2f} Reais. \nO carro foi alugado no dia {} e no mês {} \nO nome do locador é: \n{}'.format(pago, dia, mes, nome))
print ('')

print ('Qual foi o dia em que o carro foi devolvido?')
dia2 = input('')

print ('Qual foi o mês que o carro foi devolvido?')
mes2 = input ('')
print('')

print ('O locador devolveu o carro no dia e no mês de:')
print ('{}/{}'.format(dia2, mes2))