# Crie um programa onde 4 jogadores joguem um dado e tenham resultados aleatórios. Guarde esses resultados em um dicionário em Python. 
# No final, coloque esse dicionário em ordem, sabendo que o vencedor tirou o maior número no dado.

import random

# criando o dicionário para armazenar os resultados dos jogadores
resultados = {}

# gerando um número aleatório de 1 a 6 para cada jogador
for i in range(1, 5):
    resultados[f"Jogador {i}"] = random.randint(1, 6)

# exibindo os resultados dos jogadores na tela
print("Resultados dos jogadores:")
for jogador, resultado in resultados.items():
    print(f"{jogador}: {resultado}")

# ordenando o dicionário de acordo com os valores dos resultados
resultados_ordenados = sorted(resultados.items(), key=lambda x: x[1], reverse=True)

# exibindo o vencedor na tela
print(f"\nVencedor: {resultados_ordenados[0][0]}")
