# Aprimore o desafio anterior, mostrando no final: 
# A) A soma de todos os valores pares digitados.
# B) A soma dos valores da terceira coluna.
# C) O maior valor da segunda linha.

# criando uma matriz 3x3
matriz = []
soma_pares = 0
soma_terceira_coluna = 0
maior_segunda_linha = float("-inf")

for i in range(3):
    linha = []
    for j in range(3):
        valor = int(input(f"Digite o valor para [{i},{j}]: "))
        linha.append(valor)

        if valor % 2 == 0:
            soma_pares += valor
        
        if j == 2:
            soma_terceira_coluna += valor
        
        if i == 1 and valor > maior_segunda_linha:
            maior_segunda_linha = valor
            
    matriz.append(linha)

# imprimindo a matriz na tela com a formatação correta
for i in range(3):
    for j in range(3):
        print(f"[{matriz[i][j]:^5}]", end="")
    print()

# exibindo as informações adicionais
print(f"A soma dos valores pares é {soma_pares}.")
print(f"A soma dos valores da terceira coluna é {soma_terceira_coluna}.")
print(f"O maior valor da segunda linha é {maior_segunda_linha}.")
