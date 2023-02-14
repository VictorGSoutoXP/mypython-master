# Faça um programa que leia um ano qualquer e mostre se ele é BISSEXTO.
# Chama-se ano bissexto o ano ao qual é acrescentado um dia extra, ficando com 366 dias, um dia a mais do que os anos normais de 365 dias, ocorrendo a cada quatro anos. Isto é feito com o objetivo de manter o calendário anual ajustado com a translação da Terra e com os eventos sazonais relacionados às estações do ano. O ano presente é bissexto. O ano bissexto anterior foi 2016 e o próximo será 2024.
# Calendário Ano Bissesxto

from datetime import date

ano = int(input('Que ano quer analisar? Coloque para 0 para analisar o ano atual: '))
if ano == 0:
    ano = date.today().year
if ano % 4 == 0 and ano % 100 != 0 or ano % 400 == 0:
    print('O ano {} é BISSEXTO'.format(ano))
else:
    print('O ano {} NÃO é BISSEXTO'.format(ano))
