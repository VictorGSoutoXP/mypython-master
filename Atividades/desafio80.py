# Valores únicos numa lista: Crie um programa onde o usuário possa digitar vários valores numéricos e cadastre-os em uma lista. Caso o número já exista lá dentro, ele não será adicionado. No final, serão exibidos todos os valores únicos digitados, em ordem crescente. 

nums=[]
while True:
    print('-=' * 20)
    n = int(input('Digite um valor: '))
    if n not in nums:
        nums.append(n)
        print('Valor adicionado')
    else:
        print('Valor duplicado, não será adicionado...')
    con = str(input('Quer continuar? [S / N]')) .strip() .upper() [0]
    while con not in 'S' 'N':
        con = str(input('Quer continuar? [S / N]')) .strip() .upper() [0]
    if con == 'N':
        break
nums.sort()
print('-=' * 25)
print('Os valores válidos foram: ',end='')
print(*nums,sep=',')
print('-=' * 25)