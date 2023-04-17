# Explicação do código:

# Primeiro, importamos o módulo random para gerar uma escolha aleatória do computador.
# Em seguida, definimos uma função chamada jogo() que realiza o jogo.
# Dentro da função, temos uma lista opcoes que contém as três opções do jogo.
# O jogador é solicitado a escolher uma opção por meio da função input().
# Em seguida, verificamos se a escolha do jogador é válida e retornamos uma mensagem de erro se não for.
# O computador faz uma escolha aleatória usando a função random.choice() e a escolha é exibida na tela.
# Por fim, verificamos o resultado do jogo usando as regras do jogo de pedra, papel e tesoura. Se o jogador ganhar, uma mensagem de vitória é exibida, caso contrário, uma mensagem de derrota é exibida.
# Você pode adicionar mais recursos ao jogo, como pontuação e múltiplas rodadas.
# Criado por Victor Souto. :)
import random

def jogo():
    # Opções do jogo
    opcoes = ['Pedra', 'Papel', 'Tesoura']

    # Pergunta ao jogador qual é sua escolha
    jogador = input("Pedra, papel ou tesoura? ").capitalize()

    # Verifica se a escolha do jogador é válida
    if jogador not in opcoes:
        print("Escolha inválida.")
        return

    # Escolha aleatória do computador
    computador = random.choice(opcoes)

    # Exibe a escolha do computador
    print(f"O computador escolheu: {computador}")

    # Verifica o resultado do jogo
    if jogador == computador:
        print("Empate!")
    elif jogador == 'Pedra' and computador == 'Tesoura' or jogador == 'Papel' and computador == 'Pedra' or jogador == 'Tesoura' and computador == 'Papel':
        print("Você venceu!")
    else:
        print("O computador venceu!")

# Executa o jogo
jogo()
