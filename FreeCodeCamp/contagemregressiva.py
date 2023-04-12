# Explicação do código:

# A função contagem_regressiva(segundos) recebe um argumento segundos que representa a quantidade de segundos para a contagem regressiva.
# Usando um loop for, a função itera sobre uma sequência de números que vai de segundos até 1 (não incluindo 0) com um passo de -1 (ou seja, de forma decrescente).
# A cada iteração do loop, a função exibe o número atual usando a função print() e espera por 1 segundo usando a função time.sleep().
# Após o loop terminar, a função exibe a mensagem "Tempo esgotado!" usando a função print().
# Criado por Victor Souto. :)

import time

def contagem_regressiva(segundos):
    for i in range(segundos, 0, -1):
        print(i)
        time.sleep(1)
    print("Tempo esgotado!")

# Exemplo de uso
contagem_regressiva(10) # contagem regressiva de 10 segundos
