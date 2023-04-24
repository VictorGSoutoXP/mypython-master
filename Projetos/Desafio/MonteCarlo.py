# Neste exemplo, o código simula o lançamento de uma moeda num_tosses vezes. Para cada lançamento, o código usa a função random.random() para gerar um número aleatório entre 0 e 1. Se esse número for menor que 0.5, o código considera que a moeda caiu "cara" (heads), caso contrário, considera que a moeda caiu "coroa" (tails). O código mantém uma contagem do número de vezes que a moeda caiu "cara" e retorna a proporção de vezes que a moeda caiu "cara" em relação ao total de lançamentos.

# Você pode ajustar o valor de num_tosses para aumentar ou diminuir a precisão da simulação. Quanto mais lançamentos você fizer, mais próxima a proporção de "caras" deve estar de 0.5 (a proporção esperada para uma moeda justa).

import random

def simulate_coin_tosses(num_tosses):
    """
    Simula o lançamento de uma moeda num_tosses vezes.
    Retorna a proporção de caras (heads) em relação ao total de lançamentos.
    """
    num_heads = 0
    for i in range(num_tosses):
        if random.random() < 0.5:
            num_heads += 1
    return num_heads / num_tosses

# exemplo de uso
print(simulate_coin_tosses(10000)) # simula 10000 lançamentos de moeda
