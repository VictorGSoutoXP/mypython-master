# A confedaração Nacional de Natação precisa de um programa que leia o ano de nascimento de um atleta e mostre sua categoria, de acordo com sua idade. - Até 9 Anos: Mirim / - Até 14 Anos: Infantil / - Até 19 Anos: Junior / - Até 25 Anos: Sénior / - Acima: Master

from datetime import date
atual = date.today().year
nascimento = int(input('Ano de nascimento: '))
idade = atual - nascimento
print ('O atleta tem {} anos.'.format(idade))
if idade <= 9:
    print('Classificação: Mirim')
elif idade <= 14:
     print('Classificação: Infantil')
elif idade <= 19:
     print('Classificação: Junior')
elif idade <= 25:
     print('Classificação: Sênior')
else:
    print('Classificação: Master')