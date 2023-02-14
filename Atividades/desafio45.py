# Exercício Python 044: Elabore um programa que calcule o valor a ser pago por um produto, considerando o seu preço normal e condição de pagamento:
# - à vista dinheiro/cheque: 10% de desconto
# - à vista no cartão: 5% de desconto
# - em até 2x no cartão: preço formal
# - 3x ou mais no cartão: 20% de juros
valor = float(input('Digite o valor a ser pago: R$'))
prazo = int(input(''' Escolha um prazo de pagamento
 [ 1 ] À vista
 [ 2 ] À vista no cartão
 [ 3 ] Em até 2x no cartão
 [ 4 ] 3x ou mais
Digite o valor corresponde a forma de de pagamento: '''))

vista = int(1)
cartao = int(2)
duas_vezes = int(3)
tres_vezes = int(4)

if prazo == vista:
 desc = valor * 0.90
 print(f'A compra será realizada com desconto de 10%, ficando assim no valor de R${desc:.2f}')

elif prazo == cartao:
 desc = valor * 0.95
 print(f'A compra será realizada com desconto de 5%, ficando assim no de R${desc:.2f}')

elif prazo == duas_vezes:
 valor_parcelado = valor / 2
 print(f'A compra será realizada em duas parcelas no valor de R${valor_parcelado:.2f}')

elif prazo == tres_vezes:
 numero_parcelas = int(input('Digite o número de parcelas, considerando que o menor valor é 3: '))
 if numero_parcelas < 3:
  print('Número inválido. Por favor, insira um valor válido')
 else:
  valor_juros = valor * 1.2
  valor_parcelas_com_juros = valor_juros / numero_parcelas
  print(f'''A compra será realizada em {numero_parcelas} parcelas, com juros de 20% de juros. 
O novo valor do produto com júros será de R${valor_juros:.2f}.
Os valores das parcelas serão de R${valor_parcelas_com_juros:.2f}''')
 
else:
 print('Escolha inválida. Por favor, escolha uma das opções disponíveis')