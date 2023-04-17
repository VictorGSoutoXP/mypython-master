def print_board(board):
    for row in board:
        print(row)

def check_winner(board):
    # checa as linhas
    for row in board:
        if len(set(row)) == 1 and row[0] != ' ':
            return row[0]
    
    # checa as colunas
    for col in range(3):
        if len(set([board[row][col] for row in range(3)])) == 1 and board[0][col] != ' ':
            return board[0][col]
    
    # checa as diagonais
    if len(set([board[i][i] for i in range(3)])) == 1 and board[0][0] != ' ':
        return board[0][0]
    if len(set([board[i][2-i] for i in range(3)])) == 1 and board[0][2] != ' ':
        return board[0][2]
    
    # se ninguém ganhou
    return None

def main():
    # cria o tabuleiro vazio
    board = [[' ', ' ', ' '],
             [' ', ' ', ' '],
             [' ', ' ', ' ']]
    
    # variável para armazenar o jogador atual
    current_player = 'X'
    
    # loop principal do jogo
    while True:
        # imprime o tabuleiro atual
        print_board(board)
        
        # pede a jogada do jogador atual
        row = int(input(f'{current_player}, escolha uma linha (1-3): ')) - 1
        col = int(input(f'{current_player}, escolha uma coluna (1-3): ')) - 1
        
        # verifica se a jogada é válida
        if board[row][col] == ' ':
            board[row][col] = current_player
        else:
            print('Jogada inválida! Tente novamente.')
            continue
        
        # verifica se alguém ganhou
        winner = check_winner(board)
        if winner:
            print_board(board)
            print(f'O jogador {winner} ganhou!')
            break
        
        # verifica se houve empate
        if all([all(row) for row in board]):
            print_board(board)
            print('Empate!')
            break
        
        # passa a vez para o próximo jogador
        current_player = 'O' if current_player == 'X' else 'X'

if __name__ == '__main__':
    main()
