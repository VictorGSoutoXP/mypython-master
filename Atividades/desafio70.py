# Análise de dados do grupo: Crie um programa que leia a idade e o sexo de várias pessoas. A cada pessoa cadastrada, o programa deverá perguntar se o usuário quer ou não continuar. No final, mostre:
def lin():
  print('-'*20)

  
homem_cadastrado = 0
maior_18 = 0
total_mulher = 0
while True:
  lin()
  print('CADASTRE UMA PESSOA')
  lin()
  
  idade = int(input('Idade: '))
  if idade >= 18:
    maior_18 += 1
  elif idade < 20:
    total_mulher += 1
  sexo = str(input('Sexo: [M/F] ')).upper().strip()
  while sexo not in 'MmFf':
    print('ERRO!!!\nVocê só poderá digitar "M" ou "F", tente novamente.')
    sexo = str(input('Sexo: [M/F] ')).upper().strip()
  if sexo == 'M':
    homem_cadastrado += 1
  lin()
  r = str(input('Quer continuar? [S/N] ')).upper().strip()
  while r not in 'SsNn':
    print('ERRO!!!\nVocê só poderá digitar "S" ou "N", tente novamente.')
    r = str(input('Quer continuar? [S/N] ')).upper().strip()
  if r == 'N':
    break
print(f'Total de pessoas com mais de 18 anos: {maior_18}')
print(f'Ao todo temos {homem_cadastrado} homens cadastrados.')
print(f'E temos {total_mulher} mulheres com menos de 20 anos')