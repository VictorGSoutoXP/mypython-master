# Alistamento militar
# Faça um programa que leia o ano de nascimento de um jovem e informe, de acordo com sua idade, se ele ainda vai se alistar ao serviço militar, se já é a hora de se alistar ou se já passou do tempo do alistamento . 
# Seu programa também deverá mostrar o tempo que falta ou que passou do prazo.

from datetime import date
atual = date.today().year
nasc = int(input('Ano de nascimento:  '))
idade = atual - nasc
print('Quem nasceu em {} tem {} anos em {}. '.format(nasc, idade,atual))
if idade == 18:
    print('Você tem que se alistar IMEDIATAMENTE!')
elif idade < 18:
    saldo = 18 - idade
    print('Ainda faltam {} anos para o alistamento'.format(saldo))
    ano = atual + saldo
    print('Seu alistamento será em {} '.format(ano))
elif idade > 18:
    saldo = idade - 18
    print ('Você já deveria ter se alistado há {} anos.'.format(saldo))
    ano = atual - saldo
    print ('Seu alistamento foi em {}. '.format(ano))