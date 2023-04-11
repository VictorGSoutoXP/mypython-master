# Crie um programa que declare uma matriz de dimensão 3x3 e preencha com valores lidos pelo teclado.
# No final, mostre a matriz na tela, com a formatação correta.
# Criando uma matriz 3x3
matriz = []
for i in range(3):
    linha = []
    for j in range(3):
        valor = int(input(f"Digite o valor para [{i},{j}]: "))
        linha.append(valor)
    matriz.append(linha)

# imprimindo a matriz na tela com a formatação correta
for i in range(3):
    for j in range(3):
        print(f"[{matriz[i][j]:^5}]", end="")
    print()

