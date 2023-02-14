# Vários números com flags
cont = soma = 0

while True:
    num = int(input('Digite um número (999 para sair): '))
    if num == 999:
        break
    cont += 1
    soma += num

print(f'\n{cont} números digitados\nSoma = {soma}')