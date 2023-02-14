# Tratando vários valores: Crie um programa que leia vários números inteiros pelo teclado. O programa só vai parar quando o usuário digitar o valor 999, que é a condição de parada. No final, mostre quantos números foram digitados e qual foi a soma entre eles (desconsiderando o flag)

c = 0
parar = True
res = 0
while parar:
    valor = int(input('Lembre-se 999 encerra a operação, Digite um novo número: '))
    if valor != 999:
        c = c + 1
        res = res + valor
    if valor == 999:
        parar = False
        print('voce digitou {} numeros e a soma entre eles foi dê:  {}'.format(c, res))