# Crie um programa que leia quantos dinheiro a pessoa tem na carteira e mostre quantos Dólares ela pode pode comprar.


print('Digite a quantia a ser convertida')
N=float(input('R$:'))
print(f'R${N} = U${N/5.52 :.2f}')
print(f'R${N} = €{N/6.30 :.2f}')
print(f'R${N} = ¥{N/0.048 :.2f}')