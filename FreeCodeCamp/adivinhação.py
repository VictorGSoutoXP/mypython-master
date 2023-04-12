# Explicação do código:

# Primeiro, importamos o módulo random para gerar um número aleatório.
# Em seguida, definimos uma função chamada jogo() que realiza o jogo.
# Dentro da função, geramos um número aleatório usando a função random.randint() e armazenamos na variável numero.
# Inicializamos a variável tentativas com 0.
# Em seguida, entramos em um loop while que continua até que o jogador adivinhe o número correto.
# Dentro do loop, pedimos ao jogador para adivinhar o número usando a função input().
# Convertemos a entrada do jogador em um número inteiro usando a função int().
# Contabilizamos a tentativa incrementando a variável tentativas.
# Verificamos se o palpite do jogador está correto. Se estiver correto, exibimos uma mensagem de vitória e o número de tentativas. Se o palpite for muito baixo, exibimos uma mensagem para o jogador escolher um número maior. Se o palpite for muito alto, exibimos uma mensagem para o jogador escolher um número menor.
# O loop continua até que o jogador adivinhe o número correto e a instrução break seja executada para sair do loop.
# Finalmente, executamos a função jogo() para iniciar o jogo.

import random

def jogo():
    # Gera um número aleatório entre 1 e 100
    numero = random.randint(1, 100)

    # Inicializa o contador de tentativas
    tentativas = 0

    # Repete até que o jogador adivinhe o número correto
    while True:
        # Pede ao jogador para adivinhar o número
        palpite = int(input("Adivinhe o número entre 1 e 100: "))

        # Contabiliza a tentativa
        tentativas += 1

        # Verifica se o palpite do jogador está correto
        if palpite == numero:
            print(f"Parabéns, você acertou em {tentativas} tentativas!")
            break
        elif palpite < numero:
            print("O número é maior.")
        else:
            print("O número é menor.")

# Executa o jogo
jogo()
