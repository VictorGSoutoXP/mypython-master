N1=int(input('Digite um número '))
N2=int(input('Digite mais um número '))
s = N1 + N2
m = N1 * N2
d = N1 / N2
di = N1 ** N2
e = N1 ** N2
print('A soma é {}, \n a multiplicação é {}, \n e a divisão é {:.3f},'.format(s,m,d))
print( 'A inteira é {}, \n e a potência é {}.'.format(di,e))

nome = str(input('Qual é seu nome? '))
print('Prazer em te conhecer {:=^20}!'.format(nome))