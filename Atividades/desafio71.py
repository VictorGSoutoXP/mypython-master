# Estatística em produtos:  Crie um programa que leia o nome e o preço de vários produtos. O programa deverá perguntar se o usuário vai continuar ou não. No final, mostre: A) qual é o total gasto na compra.
print('Lojão o Baratão')
print(30*'-')
barato=soma=cont=0
while True:
    produto = str(input('Nome do Produto :'))
    preco = float(input('Preço R$ :'))
    resp=str(' ')
    soma+=preco
    if preco < barato or barato==0:
        barato=preco
        prod=produto.upper()
    if preco > 1000:
        cont+=1
    while resp not in 'SsNn':
        resp = str(input('Quer continuar [S/N]')).strip().upper()[0]
    if resp in 'Nn':
        print('---------FIM DO PROGRAMA-----------')
        break
print(f'O total da compra foi {soma}\nTemos {cont} produto(s) custando mais de R$ 1000.00')
print(f'O produto mais barato foi {prod} e custou R$ {barato:.2f}')

'''
totgasto = totmais1000 = precomaisbarato = 0
nomemaisbarato = ' '
print('-' * 35)
print(f'{"LOJA SUPER BARATÃO":^35}')
print('-' * 35)

while True:
    resposta = ' '
    nome = input('Nome do produto: ').strip()
    preco = float(input('Preço: R$').strip().replace(',', '.'))
    totgasto += preco
    if preco > 1000:
        totmais1000 += 1
    if preco < precomaisbarato or nomemaisbarato == ' ':
        precomaisbarato = preco
        nomemaisbarato = nome
    while resposta not in 'SN':
        resposta = input('Quer continuar [S/N]? ').strip().upper()[0]
    if resposta == 'N':
        break
print(f'{" FIM DO PROGRAMA ":-^40}')
print(f'O total da compra foi R${totgasto:.2f}\n'
      f'Temos {totmais1000} produto(s) custando mais de R$1000.00\n'
      f'O produto mais barato foi "{nomemaisbarato}" que custa R${precomaisbarato:.2f}')
'''