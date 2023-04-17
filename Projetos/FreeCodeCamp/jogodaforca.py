# Explicação do código:

# Primeiro, definimos uma lista de palavras para o jogo.
# Em seguida, definimos uma função chamada jogo() que realiza o jogo.
# Dentro da função, escolhemos uma palavra aleatória da lista de palavras usando a função random.choice().
# Inicializamos as variáveis de jogo letras_erradas, letras_certas e tentativas.
# Em seguida, entramos em um loop while que continua até que o jogador adivinhe a palavra secreta ou perca todas as tentativas.
# Dentro do loop, exibimos a palavra atualizada com as letras adivinhadas até agora.
# Verificamos se o jogador ganhou comparando a palavra atualizada com a palavra secreta. Se forem iguais, exibimos uma mensagem de vitória e saímos do loop usando a instrução break.
# Pedimos ao jogador para adivinhar uma letra usando a função input().
# Verificamos se a letra já foi adivinhada antes, se sim, exibimos uma mensagem para o jogador escolher outra letra.
# Se a letra ainda não foi adivinhada, verificamos se a letra está na palavra secreta. Se estiver, adicionamos a letra à lista letras_certas. Se não estiver, adicionamos a letra à lista letras_erradas e diminuímos o número de tentativas.
# Verificamos se o jogador
# Criado por Victor Souto. :)


import random

# Lista de palavras para o jogo
palavras = ['abacaxi', 'banana', 'laranja', 'morango', 'uva']

def jogo():
    # Escolhe uma palavra aleatória da lista
    palavra = random.choice(palavras)

    # Inicializa as variáveis de jogo
    letras_erradas = []
    letras_certas = []
    tentativas = 6

    # Loop principal do jogo
    while True:
        # Exibe a palavra atualizada com as letras adivinhadas
        palavra_atual = ""
        for letra in palavra:
            if letra in letras_certas:
                palavra_atual += letra
            else:
                palavra_atual += "_"

        print(palavra_atual)

        # Verifica se o jogador ganhou
        if palavra_atual == palavra:
            print("Parabéns, você ganhou!")
            break

        # Pede ao jogador para adivinhar uma letra
        palpite = input("Adivinhe uma letra: ").lower()

        # Verifica se a letra já foi adivinhada antes
        if palpite in letras_certas or palpite in letras_erradas:
            print("Você já adivinhou essa letra antes.")
        # Verifica se a letra está na palavra secreta
        elif palpite in palavra:
            print("Acertou!")
            letras_certas.append(palpite)
        # Se a letra não estiver na palavra secreta
        else:
            print("Errou.")
            letras_erradas.append(palpite)
            tentativas -= 1

            # Verifica se o jogador perdeu
            if tentativas == 0:
                print("Você perdeu. A palavra era", palavra)
                break

            print(f"Você ainda tem {tentativas} tentativas.")

# Executa o jogo
jogo()
