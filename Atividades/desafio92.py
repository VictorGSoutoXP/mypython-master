# Crie um programa que leia nome, ano de nascimento e carteira de trabalho e cadastre-o (com idade) em um dicionário.
# Se por acaso a CTPS for diferente de ZERO, o dicionário receberá também o ano de contratação e o salário. 
# Calcule e acrescente, além da idade, com quantos anos a pessoa vai se aposentar.

from datetime import datetime

pessoa = {}

pessoa['nome'] = input('Nome: ')
ano_nascimento = int(input('Ano de nascimento: '))
pessoa['idade'] = datetime.now().year - ano_nascimento
pessoa['ctps'] = int(input('Carteira de trabalho (0 se não tiver): '))

if pessoa['ctps'] != 0:
    ano_contratacao = int(input('Ano de contratação: '))
    pessoa['salario'] = float(input('Salário: R$ '))
    pessoa['aposentadoria'] = pessoa['idade'] + ((ano_contratacao + 35) - datetime.now().year)
else:
    pessoa['aposentadoria'] = 'Não tem carteira de trabalho'

print('-=' * 30)
for chave, valor in pessoa.items():
    print(f'{chave.capitalize()}: {valor}')
