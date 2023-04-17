branco = " "
jogadores = ['X', 'O']
token = {'X': 'X', 'O': 'O'}

def criarBoard():
    board = [
        [branco, branco, branco],
        [branco, branco, branco],
        [branco, branco, branco]
    ]
    return board

def printBoard(board):
    for i in range(3):
        print("|".join(board[i]))
        if(i < 2):
            print("------")

def getInputValido(mensagem):
    try:
        n = int(input(mensagem))
        if(n >= 1 and n <= 3):
            return n - 1
        else:
            print("Número precisa estar entre 1 e 3")
            return getInputValido(mensagem)
    except:
        print("Número inválido")
        return getInputValido(mensagem)

def verificaMovimento(board, i, j):
    if(board[i][j] == branco):
        return True
    else:
        return False

def fazMovimento(board, i, j, jogador):
    board[i][j] = token[jogador]

def verificaGanhador(board):
    # checa as linhas
    for row in board:
        if len(set(row)) == 1 and row[0] != branco:
            return row[0]
    
    # checa as colunas
    for col in range(3):
        if len(set([board[row][col] for row in range(3)])) == 1 and board[0][col] != branco:
            return board[0][col]
    
    # checa as diagonais
    if len(set([board[i][i] for i in range(3)])) == 1 and board[0][0] != branco:
        return board[0][0]
    if len(set([board[i][2-i] for i in range(3)])) == 1 and board[0][2] != branco:
        return board[0][2]
    
    # se ninguém ganhou
    return False

def jogar():
    board = criarBoard()
    jogador_atual = 0
    
    while True:
        printBoard(board)
        linha = getInputValido(f'Jogador {jogadores[jogador_atual]}, escolha uma linha (1-3): ')
        coluna = getInputValido(f'Jogador {jogadores[jogador_atual]}, escolha uma coluna (1-3): ')
        
        if verificaMovimento(board, linha, coluna):
            fazMovimento(board, linha, coluna, jogador_atual)
            ganhador = verificaGanhador(board)
            if ganhador:
                print(f'O jogador {ganhador} ganhou!')
                printBoard(board)
                break
            elif all([all(row) for row in board]):
                print('Empate!')
                printBoard(board)
                break
            else:
                jogador_atual = (jogador_atual + 1) % 2
        else:
            print("Jogada inválida! Tente novamente.")
