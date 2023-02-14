# Tabuada: Faça um programa que mostre a tabuada de vários números, um de cada vez, para cada valor digitado pelo usuário. O programa será interrompido quando o número solicitado for negativo. 
c = 0
while True:
    t = int(input('Digite um número inteiro que te daremos a sua tabuada: '))
    print('-'*20)
    if t < 0:
        break
    while c < 10:
        c += 1
        print(f'{t} * {c:2} = {t*c}')
    print('-'*20)
    c = 0 #para zerar o contador e poder inicar uma nova tabuada do 1 ao 10
print('Programa da tabuada encerrado.')
