from re import I
from jogodavelha.origin import fazMovimento
from origin import criarboard, fazmovimento, getInputValido, printBoard, verificarGanhador, verificaMovimento


jogador = 0 #jogador 1
board = criarBoard()
ganhador = verificaMovimento(board)
while(not ganhador ):
    i = getInputValido("Digite a linha: ")
    j = getInputValido("Digite uma coluna: ")

    if(verificaMovimento(board, i, j)):
        fazMovimento(board, 1, 1, jogador)
        jogador = ( jogador + 1 )%2
    else:
        print("A posição informada já está ocupada.")
    
    ganhador = verificaMovimento(board)

    print("=================")
    printBoard(board)
    print("Ganhador = ", ganhador )
    print("=================")
