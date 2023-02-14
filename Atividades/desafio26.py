# Crie um programa que leia o nome de uma pessoa e diga se ela tem "Silva" no nome.

nome_pessoa = str(input('Qual seu nome completo? ')).strip().upper()
if " SILVA " in nome_pessoa:
  print('Seu nome tem sim "Silva".')
else:
  print('Seu nome não tem "Silva".')