# Validação de dados: Faça um programa que leia o sexo de uma pessoa, mas só aceite os valores 'M' ou 'F'. Caso esteja errado, peça a digitação novamente até ter um valor correto.


s = str(input('Por favor, digite o sexo (M ou F): ')).upper().strip()[0]
while s != 'F' and s != 'M':
    s = str(input('Dados inválidos. Por favor, digite o sexo (M ou F): ')
            ).upper().strip()[0]
if s == 'F':
    print('Sexo Feminino cadastrado.')
if s == 'M':
    print('Sexo Masculino cadastrado.')

"""sexo = ' '
while sexo != 'M' and sexo != 'F':
    sexo = str(input('Qual é o seu sexo [M/F]: ')).strip().upper()
    if sexo != 'M' and sexo != 'F':
        print('Por favor digite M (Masculino) ou F (Feminino) para validar seu sexo.')
    else:
        print(f'Validação feita com sucesso, você é {sexo}.')
int(input('Qual a sua idade: ')).strip"""